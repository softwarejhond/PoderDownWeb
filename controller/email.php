<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class OrderMailer
{
    private $conn;
    private $smtp;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->cargarSmtp();
    }

    private function cargarSmtp()
    {
        $res = mysqli_query($this->conn, "SELECT * FROM smtpconfig WHERE id = 1 LIMIT 1");
        if (!$res || mysqli_num_rows($res) === 0) {
            throw new Exception('No se encontró configuración SMTP.');
        }
        $this->smtp = mysqli_fetch_assoc($res);
    }

    public function sendOrderConfirmation($orderId, $paymentId)
    {
        $order = $this->getOrder($orderId);
        if (!$order) return false;

        $items = $this->getOrderItems($orderId);
        $customerEmail = $order['customer_email'];
        $customerName = $order['customer_name'] ?: 'Cliente';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = $this->smtp['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->smtp['username'];
            $mail->Password = $this->smtp['password'];
            $mail->Port = (int) $this->smtp['port'];
            $mail->SMTPSecure = ($this->smtp['port'] == 465) ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;

            $mail->setFrom($this->smtp['email'], 'Poder Down');
            $mail->addAddress($customerEmail, $customerName);

            $mail->isHTML(true);
            $mail->Subject = 'Tu pedido ' . $order['order_number'] . ' está confirmado — Poder Down';

            $mail->Body = $this->buildEmailHtml($order, $items);
            $mail->AltBody = $this->buildEmailText($order, $items);

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('OrderMailer ERROR: ' . $e->getMessage());
            return false;
        }
    }

    private function getOrder($orderId)
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM orders WHERE id = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 'i', $orderId);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);
        return $row;
    }

    private function getOrderItems($orderId)
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM order_items WHERE order_id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $orderId);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $items = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $items[] = $row;
        }
        mysqli_stmt_close($stmt);
        return $items;
    }

    private function buildEmailHtml($order, $items)
    {
        $nombre = htmlspecialchars($order['customer_name'] ?: 'Cliente');
        $codigo = htmlspecialchars($order['order_number']);
        $total = number_format($order['total'], 0, ',', '.');
        $subtotal = number_format($order['subtotal'], 0, ',', '.');
        $envioDB = (float) ($order['shipping_cost'] ?? 0);
        $envio = $envioDB > 0 ? $envioDB : ((float) $order['total'] - (float) $order['subtotal']);
        $envioStr = number_format($envio, 0, ',', '.');
        $direccion = htmlspecialchars(($order['shipping_address'] ?? '') . ', ' . ($order['shipping_city'] ?? '') . ', ' . ($order['shipping_department'] ?? ''));
        $fecha = date('d/m/Y H:i', strtotime($order['created_at'] ?? 'now'));

        $itemsHtml = '';
        foreach ($items as $item) {
            $nombreItem = htmlspecialchars($item['product_name']);
            $cant = (int) $item['quantity'];
            $lineTotal = number_format($item['total'], 0, ',', '.');
            $itemsHtml .= "
                <tr>
                    <td style='padding:10px 0;border-bottom:1px solid #d6d4cc;font-size:14px;'>{$nombreItem} x{$cant}</td>
                    <td style='padding:10px 0;border-bottom:1px solid #d6d4cc;text-align:right;font-size:14px;white-space:nowrap;'>\${$lineTotal}</td>
                </tr>";
        }

        return <<<HTML
        <!DOCTYPE html>
        <html lang="es">
        <head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"></head>
        <body style="margin:0;padding:0;background:#ebeae4;font-family:Arial,Helvetica,sans-serif;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background:#ebeae4;padding:30px 0;">
            <tr><td align="center">
                <table width="560" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(26,58,92,.08);">
                    <tr>
                        <td style="background:linear-gradient(135deg,#1A3A5C,#0D2136);padding:28px 30px;text-align:center;">
                            <h1 style="font-family:'Trebuchet MS',Arial,sans-serif;font-size:22px;color:#fff;margin:0;">¡Gracias por tu compra, {$nombre}!</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px 30px;">
                            <p style="font-size:15px;color:#1A3A5C;line-height:1.7;margin:0 0 16px;">
                                Tu pedido <strong style="color:#3CAEE0;">{$codigo}</strong> ha sido confirmado y ya estamos preparando todo para que llegue pronto a ti.
                            </p>

                            <div style="background:#f8f7f4;border-radius:12px;padding:18px 20px;margin-bottom:20px;">
                                <p style="font-size:13px;color:#666;margin:0 0 12px;"><strong>Resumen de compra</strong></p>
                                <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;color:#1A3A5C;">
                                    {$itemsHtml}
                                    <tr>
                                        <td style="padding:10px 0;font-size:14px;">Subtotal</td>
                                        <td style="padding:10px 0;text-align:right;font-size:14px;">\${$subtotal}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 0;font-size:14px;color:#888;">Envío</td>
                                        <td style="padding:10px 0;text-align:right;font-size:14px;color:#888;">\${$envioStr}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:12px 0;font-weight:700;font-size:16px;border-top:2px solid #1A3A5C;">TOTAL</td>
                                        <td style="padding:12px 0;text-align:right;font-weight:700;font-size:16px;border-top:2px solid #1A3A5C;color:#3CAEE0;">\${$total}</td>
                                    </tr>
                                </table>
                            </div>

                            <p style="font-size:13px;color:#888;line-height:1.7;margin:0 0 8px;">
                                <strong>Dirección de envío:</strong> {$direccion}
                            </p>
                            <p style="font-size:13px;color:#888;line-height:1.7;margin:0 0 20px;">
                                <strong>Fecha:</strong> {$fecha}
                            </p>

                            <p style="font-size:14px;color:#1A3A5C;line-height:1.7;margin:0;">
                                Te notificaremos cuando tu pedido sea despachado. Si tienes alguna duda, responde a este correo o escríbenos a <a href="mailto:info@poderdown.com" style="color:#3CAEE0;">info@poderdown.com</a>.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f0efe9;padding:18px 30px;text-align:center;">
                            <p style="font-size:12px;color:#999;margin:0;">
                                Poder Down &mdash; Arte e inclusión<br>
                                <a href="https://poderdown.com" style="color:#3CAEE0;text-decoration:none;">poderdown.com</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td></tr>
        </table>
        </body>
        </html>
        HTML;
    }

    private function buildEmailText($order, $items)
    {
        $nombre = $order['customer_name'] ?: 'Cliente';
        $codigo = $order['order_number'];
        $total = number_format($order['total'], 0, ',', '.');
        $lines = [];
        $lines[] = "¡Gracias por tu compra, {$nombre}!";
        $lines[] = "";
        $lines[] = "Tu pedido {$codigo} está confirmado y en proceso.";
        $lines[] = "";
        foreach ($items as $item) {
            $lines[] = "{$item['product_name']} x{$item['quantity']} — \$" . number_format($item['total'], 0, ',', '.');
        }
        $lines[] = "TOTAL: \${$total}";
        $lines[] = "";
        $lines[] = "Te notificaremos cuando sea despachado.";
        $lines[] = "Poder Down — poderdown.com";
        return implode("\n", $lines);
    }
}
