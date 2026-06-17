<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/conexion.php';

function registerCustomer($email, $password, $first_name, $last_name, $phone = null) {
    global $conn;

    $stmt = mysqli_prepare($conn, "SELECT id FROM customers WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        return ['success' => false, 'message' => 'El correo ya está registrado.'];
    }
    mysqli_stmt_close($stmt);

    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $stmt = mysqli_prepare($conn,
        "INSERT INTO customers (email, password, first_name, last_name, phone, is_active, email_verified, created_at) VALUES (?, ?, ?, ?, ?, 1, 1, NOW())");
    $e = $email; $h = $hashed; $fn = $first_name; $ln = $last_name; $ph = $phone;
    mysqli_stmt_bind_param($stmt, "sssss", $e, $h, $fn, $ln, $ph);

    if (mysqli_stmt_execute($stmt)) {
        $customer_id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);
        $_SESSION['customer_id'] = $customer_id;
        return ['success' => true, 'customer_id' => $customer_id];
    }
    mysqli_stmt_close($stmt);
    return ['success' => false, 'message' => 'Error al registrar. Intenta de nuevo.'];
}

function loginCustomer($email, $password) {
    global $conn;

    $stmt = mysqli_prepare($conn,
        "SELECT id, password, first_name, last_name, is_active, login_attempts, locked_until FROM customers WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $customer = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$customer) {
        return ['success' => false, 'message' => 'Correo o contraseña incorrectos.'];
    }

    if (!$customer['is_active']) {
        return ['success' => false, 'message' => 'Cuenta desactivada. Contacta con soporte.'];
    }

    if ($customer['locked_until'] && strtotime($customer['locked_until']) > time()) {
        $mins = ceil((strtotime($customer['locked_until']) - time()) / 60);
        return ['success' => false, 'message' => "Cuenta bloqueada. Intenta de nuevo en {$mins} minuto(s)."];
    }

    if (!password_verify($password, $customer['password'])) {
        $attempts = $customer['login_attempts'] + 1;
        $locked = null;
        if ($attempts >= 5) {
            $locked = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        }
        $stmt2 = mysqli_prepare($conn, "UPDATE customers SET login_attempts = ?, locked_until = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt2, "isi", $attempts, $locked, $customer['id']);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
        return ['success' => false, 'message' => 'Correo o contraseña incorrectos.'];
    }

    $stmt2 = mysqli_prepare($conn, "UPDATE customers SET login_attempts = 0, locked_until = NULL, last_login = NOW() WHERE id = ?");
    mysqli_stmt_bind_param($stmt2, "i", $customer['id']);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);

    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+7 days'));
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

    $stmt3 = mysqli_prepare($conn, "INSERT INTO customer_sessions (customer_id, session_token, ip_address, user_agent, expires_at) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt3, "issss", $customer['id'], $token, $ip, $ua, $expires);
    mysqli_stmt_execute($stmt3);
    mysqli_stmt_close($stmt3);

    $_SESSION['customer_id'] = $customer['id'];

    return ['success' => true, 'customer' => [
        'id' => $customer['id'],
        'first_name' => $customer['first_name'],
        'last_name' => $customer['last_name']
    ]];
}

function isLoggedIn() {
    return isset($_SESSION['customer_id']);
}

function getCurrentUser() {
    global $conn;
    if (!isLoggedIn()) return null;

    $stmt = mysqli_prepare($conn,
        "SELECT id, email, first_name, last_name, phone, document_type, document_number, gender, birthdate, avatar, newsletter_subscribed, created_at, last_login FROM customers WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $cid);
    $cid = (int)$_SESSION['customer_id'];
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $user;
}

function logoutCustomer() {
    global $conn;
    if (isset($_SESSION['customer_id'])) {
        $stmt = mysqli_prepare($conn, "DELETE FROM customer_sessions WHERE customer_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['customer_id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    session_unset();
    session_destroy();
}

function updateProfile($customer_id, $data) {
    global $conn;

    $fields = [];
    $params = [];
    $types = '';

    if (isset($data['first_name'])) { $fields[] = 'first_name = ?'; $params[] = $data['first_name']; $types .= 's'; }
    if (isset($data['last_name'])) { $fields[] = 'last_name = ?'; $params[] = $data['last_name']; $types .= 's'; }
    if (isset($data['phone'])) { $fields[] = 'phone = ?'; $params[] = $data['phone']; $types .= 's'; }
    if (isset($data['gender'])) { $fields[] = 'gender = ?'; $params[] = $data['gender']; $types .= 's'; }
    if (isset($data['birthdate'])) { $fields[] = 'birthdate = ?'; $params[] = $data['birthdate']; $types .= 's'; }
    if (isset($data['document_type'])) { $fields[] = 'document_type = ?'; $params[] = $data['document_type']; $types .= 's'; }
    if (isset($data['document_number'])) { $fields[] = 'document_number = ?'; $params[] = $data['document_number']; $types .= 's'; }
    if (isset($data['newsletter_subscribed'])) { $fields[] = 'newsletter_subscribed = ?'; $params[] = (int)$data['newsletter_subscribed']; $types .= 'i'; }

    if (!empty($data['new_password'])) {
        $hashed = password_hash($data['new_password'], PASSWORD_BCRYPT);
        $fields[] = 'password = ?';
        $params[] = $hashed;
        $types .= 's';
    }

    if (empty($fields)) return ['success' => false, 'message' => 'No hay datos para actualizar.'];

    $sql = "UPDATE customers SET " . implode(', ', $fields) . " WHERE id = ?";
    $params[] = $customer_id;
    $types .= 'i';

    $stmt = mysqli_prepare($conn, $sql);
    $refs = [];
    foreach ($params as $i => $v) { $refs[$i] = &$params[$i]; }
    array_unshift($refs, $types);
    call_user_func_array([$stmt, 'bind_param'], $refs);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return ['success' => true, 'message' => 'Perfil actualizado correctamente.'];
    }
    mysqli_stmt_close($stmt);
    return ['success' => false, 'message' => 'Error al actualizar el perfil.'];
}
