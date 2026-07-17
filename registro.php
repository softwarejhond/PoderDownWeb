<?php
require_once __DIR__ . '/controller/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');

    $errors = [];
    if (empty($first_name)) $errors[] = 'El nombre es obligatorio.';
    if (empty($last_name)) $errors[] = 'El apellido es obligatorio.';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Ingresa un correo válido.';
    if (strlen($password) < 6) $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
    if ($password !== $confirm) $errors[] = 'Las contraseñas no coinciden.';

    if (empty($errors)) {
        $result = registerCustomer($email, $password, $first_name, $last_name, $phone);
        if ($result['success']) {
            header('Location: perfil.php?welcome=1');
            exit;
        } else {
            $error = $result['message'];
        }
    } else {
        $error = implode('<br>', $errors);
    }
}

$pageTitle = 'Crear Cuenta — Poder Down';
$pageDescription = 'Regístrate en Poder Down y accede a beneficios exclusivos.';
$activePage = 'registro';
$showNavSearch = false;
$metaRobots = 'noindex, follow';
require 'components/header.php';
?>

<style>
.auth-wrapper {
    min-height: calc(100vh - 180px);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    padding: 2rem 1rem;
}

.auth-wrapper .blob {
    width: 320px;
    height: 320px;
}
.auth-wrapper .blob:nth-child(1) {
    top: -60px;
    right: -100px;
    background: var(--pd-coral);
    opacity: 0.25;
    animation-delay: 0s;
    width: 380px;
    height: 380px;
}
.auth-wrapper .blob:nth-child(2) {
    bottom: -80px;
    left: -90px;
    background: var(--pd-azul);
    opacity: 0.22;
    animation-delay: 2s;
    width: 340px;
    height: 340px;
}
.auth-wrapper .blob:nth-child(3) {
    top: 30%;
    left: 10%;
    background: var(--pd-amarillo);
    opacity: 0.18;
    animation-delay: 4s;
    width: 200px;
    height: 200px;
}

.auth-card {
    background: #fff;
    border-radius: var(--radius-card, 24px);
    box-shadow: var(--shadow-suave, 0 8px 32px rgba(26,58,92,0.10));
    padding: 2.8rem 2.2rem;
    width: 100%;
    max-width: 480px;
    z-index: 1;
    animation: authFadeInUp .7s cubic-bezier(.22,.61,.36,1) both;
    position: relative;
}

@keyframes authFadeInUp {
    from { opacity: 0; transform: translateY(40px); }
    to   { opacity: 1; transform: translateY(0); }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 50%, 90% { transform: translateX(-6px); }
    30%, 70% { transform: translateX(6px); }
}

.auth-card .auth-icon {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: var(--pd-azul-light, rgba(60,174,224,.12));
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.8rem;
    color: var(--pd-azul);
}
.auth-card .auth-icon i { transition: transform .4s; }
.auth-card:hover .auth-icon i { transform: rotate(-8deg) scale(1.1); }

.auth-card h2 {
    font-family: var(--font-gilroy, 'Nunito', sans-serif);
    font-weight: 800;
    font-size: 1.65rem;
    color: var(--pd-oscuro);
    text-align: center;
    margin-bottom: .25rem;
}
.auth-card .auth-subtitle {
    text-align: center;
    color: #888;
    font-size: .88rem;
    margin-bottom: 1.8rem;
}

.row-cami {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0 .9rem;
}

.input-group-cami {
    position: relative;
    margin-bottom: 1.15rem;
}
.input-group-cami .input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #b0b0b0;
    font-size: 1.1rem;
    transition: color .3s;
    z-index: 2;
    pointer-events: none;
}
.input-group-cami input {
    width: 100%;
    padding: .72rem 1rem .72rem 2.7rem;
    border: 2px solid var(--pd-beige-borde, #d6d4cc);
    border-radius: 14px;
    font-family: var(--font-archivo, 'Archivo', sans-serif);
    font-size: .92rem;
    background: #fafaf8;
    transition: border-color .3s, box-shadow .3s, background .3s;
    outline: none;
}
.input-group-cami input:focus {
    border-color: var(--pd-azul);
    box-shadow: 0 0 0 4px rgba(60,174,224,.12);
    background: #fff;
}
.input-group-cami input:focus ~ .input-icon,
.input-group-cami input:focus + .input-icon { color: var(--pd-azul); }

.input-group-cami .toggle-password {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #b0b0b0;
    cursor: pointer;
    padding: 4px 6px;
    font-size: 1.05rem;
    transition: color .2s;
}
.input-group-cami .toggle-password:hover { color: var(--pd-oscuro); }

.auth-card .btn-submit {
    width: 100%;
    margin-top: .4rem;
    justify-content: center;
    padding: .82rem 2rem;
    font-size: .98rem;
    letter-spacing: 0.3px;
    position: relative;
    overflow: hidden;
}
.auth-card .btn-submit::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,.25) 50%, transparent 70%);
    transform: translateX(-100%);
    transition: transform .6s;
}
.auth-card .btn-submit:hover::after { transform: translateX(100%); }

.auth-footer {
    text-align: center;
    margin-top: 1.5rem;
    font-size: .88rem;
    color: #888;
}
.auth-footer a {
    color: var(--pd-azul);
    font-weight: 700;
    text-decoration: none;
    transition: color .2s;
}
.auth-footer a:hover { color: var(--pd-coral); }

.auth-card .auth-divider {
    display: flex;
    align-items: center;
    gap: .8rem;
    margin: 1.5rem 0 1rem;
    color: #bbb;
    font-size: .78rem;
}
.auth-card .auth-divider::before,
.auth-card .auth-divider::after {
    content: ''; flex: 1; height: 1px; background: var(--pd-beige-borde, #d6d4cc);
}

.btn-home-link {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    color: var(--pd-oscuro);
    text-decoration: none;
    font-size: .85rem;
    font-weight: 600;
    margin-bottom: 1rem;
    transition: color .2s;
}
.btn-home-link:hover { color: var(--pd-azul); }

.error-message {
    background: #fde8e8;
    color: #c53030;
    padding: .65rem 1rem;
    border-radius: 12px;
    font-size: .84rem;
    text-align: center;
    margin-bottom: 1rem;
    animation: shake .5s ease both;
    line-height: 1.5;
}

@media (max-width: 480px) {
    .auth-card { padding: 2rem 1.3rem; }
    .row-cami { grid-template-columns: 1fr; gap: 0; }
    .auth-wrapper .blob:nth-child(1) { width: 220px; height: 220px; right: -80px; }
    .auth-wrapper .blob:nth-child(2) { width: 200px; height: 200px; left: -70px; }
}
</style>

<div class="auth-wrapper">
    <div class="blob"></div>
    <div class="blob"></div>
    <div class="blob"></div>

    <div style="z-index:1;width:100%;max-width:480px;">
        <a href="index.php" class="btn-home-link"><i class="bi bi-arrow-left"></i> Volver al inicio</a>

        <div class="auth-card">
            <div class="auth-icon"><i class="bi bi-person-plus"></i></div>
            <h2>Crear tu cuenta</h2>
            <p class="auth-subtitle">Únete a la comunidad Poder Down</p>

            <?php if (isset($error)): ?>
            <div class="error-message"><i class="bi bi-exclamation-triangle me-1"></i> <?= $error ?></div>
            <?php endif; ?>

            <form method="POST" novalidate autocomplete="off">
                <div class="row-cami">
                    <div class="input-group-cami">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="first_name" placeholder="Nombre"
                               value="<?= htmlspecialchars($first_name ?? '') ?>" required>
                    </div>
                    <div class="input-group-cami">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="last_name" placeholder="Apellido"
                               value="<?= htmlspecialchars($last_name ?? '') ?>" required>
                    </div>
                </div>
                <div class="input-group-cami">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" name="email" placeholder="Correo electrónico"
                           value="<?= htmlspecialchars($email ?? '') ?>" required autocomplete="email">
                </div>
                <div class="input-group-cami">
                    <i class="bi bi-telephone input-icon"></i>
                    <input type="tel" name="phone" placeholder="Teléfono (opcional)"
                           value="<?= htmlspecialchars($phone ?? '') ?>" autocomplete="tel">
                </div>
                <div class="input-group-cami">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" name="password" id="regPassword" placeholder="Contraseña (mín. 6 caracteres)" required autocomplete="new-password">
                    <button type="button" class="toggle-password" onclick="togglePass('regPassword', this)" aria-label="Mostrar contraseña">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div class="input-group-cami">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input type="password" name="confirm_password" id="regConfirm" placeholder="Confirmar contraseña" required autocomplete="new-password">
                    <button type="button" class="toggle-password" onclick="togglePass('regConfirm', this)" aria-label="Mostrar contraseña">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <button type="submit" class="btn-cami-primary btn-submit">
                    <i class="bi bi-person-check"></i> Crear Cuenta
                </button>
            </form>

            <div class="auth-divider">o también</div>

            <div class="auth-footer">
                ¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function togglePass(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>

<?php require_once __DIR__ . '/components/footer_mini.php'; ?>
