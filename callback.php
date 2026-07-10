<?php
require_once __DIR__ . '/controller/conexion.php';
require_once __DIR__ . '/controller/megapagos.php';

define('LOG_DIR', __DIR__ . '/logs');
define('LOG_FILE', LOG_DIR . '/callback_' . date('Y-m-d') . '.log');

function log_callback($msg, $data = null) {
    if (!is_dir(LOG_DIR)) mkdir(LOG_DIR, 0755, true);
    $line = '[' . date('Y-m-d H:i:s') . '] ' . $msg;
    if ($data !== null) $line .= ' | ' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    $line .= PHP_EOL;
    file_put_contents(LOG_FILE, $line, FILE_APPEND | LOCK_EX);
}

log_callback('=== CALLBACK RECIBIDO ===');
log_callback('GET', $_GET);

$pageTitle = 'Resultado del pago — Poder Down';
$pageDescription = 'Estado de tu pago en Poder Down';
require 'components/header_simple.php';

$orderId = (int) ($_GET['order'] ?? 0);
$paymentId = (int) ($_GET['payment'] ?? 0);
$transactionId = null;
$estado = 'pending';
$mensaje = 'Estamos verificando tu pago...';
$icono = 'bi-hourglass-split';
$color = 'var(--cami-azul)';
$orderNumber = '';

if ($orderId && $paymentId) {
    $stmt = mysqli_prepare($conn, "SELECT p.gateway_transaction_id, o.order_number FROM payments p JOIN orders o ON o.id = p.order_id WHERE p.id = ? AND p.order_id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 'ii', $paymentId, $orderId);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);

    if ($row) {
        $transactionId = $row['gateway_transaction_id'];
        $orderNumber = $row['order_number'];

        if ($transactionId) {
            try {
                $megapagos = new MegapagosClient($conn);
                $megapagos->login();
                $info = $megapagos->getTransactionInfo($transactionId);
                log_callback('MEGAPAGOS getTransactionInfo', $info);

                $status = $info['status'] ?? $info['data']['status'] ?? $info['transaction']['status'] ?? null;
                log_callback('STATUS DETECTADO: ' . var_export($status, true));

                if ($status !== null) {
                    $status = (int) $status;
                }

                if (in_array($status, [1, 9])) {
                    $estado = 'approved';
                    $mensaje = 'Tu pago fue aprobado exitosamente.';
                    $icono = 'bi-check-circle-fill';
                    $color = '#28a745';
                } elseif (in_array($status, [2, 3, 5, 6, 7, 10, 11, 12, 13, 14, 15])) {
                    $estado = 'rejected';
                    $mensaje = 'El pago fue rechazado. Intenta nuevamente.';
                    $icono = 'bi-x-circle-fill';
                    $color = '#dc3545';
                } elseif ($status === 4) {
                    $estado = 'expired';
                    $mensaje = 'La sesión de pago expiró. Por favor intenta de nuevo.';
                    $icono = 'bi-clock-fill';
                    $color = '#ffc107';
                } else {
                    $estado = 'pending';
                    $mensaje = 'Tu pago está siendo procesado. Te notificaremos cuando se confirme.';
                    $icono = 'bi-hourglass-split';
                    $color = 'var(--cami-azul)';
                }

                $paymentStatus = $estado;
                $orderStatus = ($estado === 'approved') ? 'processing' : (($estado === 'rejected') ? 'cancelled' : 'pending');

                $stmtUpd = mysqli_prepare($conn, "UPDATE payments SET status = ?, response_message = ?, franchise = 'PSE' WHERE id = ?");
                $infoDesc = $info['externalDetails']['payment_code'] ?? '';
                mysqli_stmt_bind_param($stmtUpd, 'ssi', $paymentStatus, $infoDesc, $paymentId);
                mysqli_stmt_execute($stmtUpd);
                mysqli_stmt_close($stmtUpd);

                $stmtOrd = mysqli_prepare($conn, "UPDATE orders SET payment_status = ?, status = ?, updated_at = NOW() WHERE id = ?");
                mysqli_stmt_bind_param($stmtOrd, 'ssi', $paymentStatus, $orderStatus, $orderId);
                mysqli_stmt_execute($stmtOrd);
                mysqli_stmt_close($stmtOrd);

                if ($estado === 'approved') {
                    $stmtPayUpd = mysqli_prepare($conn, "UPDATE payments SET paid_at = NOW() WHERE id = ?");
                    mysqli_stmt_bind_param($stmtPayUpd, 'i', $paymentId);
                    mysqli_stmt_execute($stmtPayUpd);
                    mysqli_stmt_close($stmtPayUpd);
                }

            } catch (Exception $e) {
                $mensaje = 'No pudimos verificar tu pago en este momento. Contáctanos si necesitas ayuda.';
                $icono = 'bi-exclamation-triangle-fill';
                $color = '#ffc107';
            }
        }
    } else {
        $mensaje = 'No se encontró información del pedido.';
        $icono = 'bi-question-circle-fill';
        $color = '#6c757d';
    }
}
?>
<style>
.result-page { min-height:70vh;display:flex;align-items:center;justify-content:center;padding:2rem 1rem; }
.result-card { background:white;border-radius:24px;padding:2.5rem 2rem;text-align:center;max-width:460px;width:100%;box-shadow:0 8px 32px rgba(0,51,102,.08); }
.result-icon { font-size:4rem;margin-bottom:1rem; }
.result-card h2 { font-family:var(--font-kranky);font-size:1.5rem;margin-bottom:.8rem; }
.result-card p { opacity:.8;line-height:1.7;font-size:.9rem;margin-bottom:1.5rem; }
.result-card .order-code { font-family:monospace;background:var(--cami-bg);padding:.3rem .8rem;border-radius:8px;font-size:.85rem;color:var(--cami-azul); }
.result-card .btn-p1 { display:inline-flex;align-items:center;gap:.4rem; }
</style>

<div class="result-page">
  <div class="result-card">
    <div class="result-icon" style="color:<?= $color ?>;">
      <i class="bi <?= $icono ?>"></i>
    </div>
    <h2 style="color:var(--cami-azul);"><?= $estado === 'approved' ? '¡Pago exitoso!' : ($estado === 'rejected' ? 'Pago rechazado' : 'Verificando pago') ?></h2>
    <p><?= htmlspecialchars($mensaje) ?></p>
    <?php if ($orderNumber): ?>
      <p style="margin-bottom:1.5rem;">Código de pedido: <span class="order-code"><?= htmlspecialchars($orderNumber) ?></span></p>
    <?php endif; ?>
    <div style="display:flex;gap:.7rem;justify-content:center;flex-wrap:wrap;">
      <?php if ($estado === 'approved'): ?>
        <a href="productos.php" class="btn-p1"><i class="bi bi-shop"></i> Seguir comprando</a>
      <?php elseif ($estado === 'rejected' || $estado === 'expired'): ?>
        <a href="javascript:history.back()" class="btn-p1"><i class="bi bi-arrow-left"></i> Volver a intentar</a>
        <a href="productos.php" class="btn-p2"><i class="bi bi-shop"></i> Ir a tienda</a>
      <?php else: ?>
        <a href="https://wa.me/573137468039" target="_blank" class="btn-p1"><i class="bi bi-whatsapp"></i> Contactar por WhatsApp</a>
        <a href="productos.php" class="btn-p2"><i class="bi bi-shop"></i> Ir a tienda</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="fl-bar-fija">
  &copy; <?= date('Y') ?> Poder Down by <a href="https://www.agenciaeaglesoftware.com/" target="_blank" rel="noopener noreferrer" class="fl-eagle-link">Eagle Software</a> &mdash; Todos los derechos reservados
</div>

<style>
.fl-bar-fija { position:fixed;bottom:0;left:0;right:0;background:#ebeae4;border-top:2px solid #d6d4cc;padding:.75rem 1.5rem;text-align:center;font-size:.82rem;color:rgba(0,51,102,.6);font-family:'Archivo',sans-serif;box-shadow:0 -2px 12px rgba(0,51,102,.06);z-index:1000; }
.fl-eagle-link { color:#1A3A5C;text-decoration:none;font-weight:700;font-family:'Nunito','Gilroy',sans-serif;transition:color .2s; }
.fl-eagle-link:hover { color:#3CAEE0; }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
