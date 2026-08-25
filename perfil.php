<?php
require_once __DIR__ . '/controller/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user = getCurrentUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name' => trim($_POST['last_name'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'gender' => $_POST['gender'] ?? null,
        'birthdate' => $_POST['birthdate'] ?? null,
        'document_type' => $_POST['document_type'] ?? null,
        'document_number' => trim($_POST['document_number'] ?? ''),
        'newsletter_subscribed' => isset($_POST['newsletter_subscribed']) ? 1 : 0,
    ];

    $updateError = null;

    if (!empty($_POST['new_password'])) {
        if (strlen($_POST['new_password']) < 6) {
            $updateError = 'La nueva contraseña debe tener al menos 6 caracteres.';
        } elseif ($_POST['new_password'] !== ($_POST['confirm_new_password'] ?? '')) {
            $updateError = 'Las contraseñas no coinciden.';
        } else {
            $data['new_password'] = $_POST['new_password'];
        }
    }

    if (!$updateError) {
        $result = updateProfile($user['id'], $data);
        if ($result['success']) {
            header('Location: perfil?updated=success');
            exit;
        } else {
            $updateError = $result['message'];
        }
    }

    if ($updateError) {
        $msg = urlencode($updateError);
        header("Location: perfil?updated=error&msg={$msg}");
        exit;
    }
}

$pageTitle = 'Mi Perfil — Poder Down';
$pageDescription = 'Administra tu perfil y configuración de cuenta.';
$activePage = 'perfil';
$showNavSearch = false;
$metaRobots = 'noindex, follow';
require 'components/header.php';
?>

<style>
.profile-wrapper {
    min-height: calc(100vh - 180px);
    padding: 2.5rem 1rem;
    position: relative;
    overflow: hidden;
}

.profile-wrapper .blob {
    width: 320px; height: 320px;
}
.profile-wrapper .blob:nth-child(1) {
    top: 10%; left: -120px;
    background: var(--pd-azul);
    opacity: 0.15;
    animation-delay: 0s;
}
.profile-wrapper .blob:nth-child(2) {
    bottom: 5%; right: -100px;
    background: var(--pd-coral);
    opacity: 0.12;
    animation-delay: 2s;
}

.profile-container {
    max-width: 860px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

.profile-header-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: .8rem;
    margin-bottom: 1.5rem;
}
.profile-header-bar h1 {
    font-family: var(--font-gilroy, 'Nunito', sans-serif);
    font-weight: 800;
    font-size: 1.7rem;
    color: var(--pd-oscuro);
    margin: 0;
}
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    color: var(--pd-oscuro);
    text-decoration: none;
    font-size: .85rem;
    font-weight: 600;
    transition: color .2s;
}
.btn-back:hover { color: var(--pd-azul); }

.profile-grid {
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 1.5rem;
}

.profile-sidebar {
    animation: slideInLeft .6s cubic-bezier(.22,.61,.36,1) both;
}
@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-30px); }
    to   { opacity: 1; transform: translateX(0); }
}

.profile-main {
    animation: slideInRight .6s cubic-bezier(.22,.61,.36,1) .1s both;
}
@keyframes slideInRight {
    from { opacity: 0; transform: translateX(30px); }
    to   { opacity: 1; transform: translateX(0); }
}

.card-cami {
    background: #fff;
    border-radius: var(--radius-card, 24px);
    box-shadow: var(--shadow-suave, 0 8px 32px rgba(26,58,92,0.10));
    padding: 1.6rem;
    margin-bottom: 1.5rem;
}

.profile-sidebar .avatar-circle {
    width: 90px; height: 90px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--pd-azul), var(--pd-coral));
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-family: var(--font-gilroy, 'Nunito', sans-serif);
    font-weight: 800;
    font-size: 2.2rem;
    margin: 0 auto .8rem;
}
.profile-sidebar .side-name {
    text-align: center;
    font-family: var(--font-gilroy, 'Nunito', sans-serif);
    font-weight: 800;
    font-size: 1.1rem;
    color: var(--pd-oscuro);
    margin-bottom: .15rem;
}
.profile-sidebar .side-email {
    text-align: center;
    font-size: .82rem;
    color: #888;
    word-break: break-all;
    margin-bottom: 1rem;
}
.profile-sidebar .side-info {
    font-size: .8rem;
    color: #999;
}
.profile-sidebar .side-info i { width: 18px; color: var(--pd-azul); }

.card-cami h3 {
    font-family: var(--font-gilroy, 'Nunito', sans-serif);
    font-weight: 800;
    font-size: 1.15rem;
    color: var(--pd-oscuro);
    margin-bottom: 1.3rem;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.card-cami h3 i { color: var(--pd-azul); }

.input-group-cami {
    position: relative;
    margin-bottom: 1.1rem;
}
.input-group-cami label {
    display: block;
    font-size: .8rem;
    font-weight: 700;
    color: var(--pd-oscuro);
    margin-bottom: .3rem;
    font-family: var(--font-archivo, 'Archivo', sans-serif);
    letter-spacing: .3px;
}
.input-group-cami input,
.input-group-cami select {
    width: 100%;
    padding: .68rem 1rem;
    border: 2px solid var(--pd-beige-borde, #d6d4cc);
    border-radius: 12px;
    font-family: var(--font-archivo, 'Archivo', sans-serif);
    font-size: .9rem;
    background: #fafaf8;
    transition: border-color .3s, box-shadow .3s, background .3s;
    outline: none;
}
.input-group-cami input:focus,
.input-group-cami select:focus {
    border-color: var(--pd-azul);
    box-shadow: 0 0 0 4px rgba(60,174,224,.12);
    background: #fff;
}

.row-cami {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0 .9rem;
}

.profile-main .btn-submit {
    justify-content: center;
    padding: .72rem 2.4rem;
    font-size: .92rem;
    position: relative;
    overflow: hidden;
}
.profile-main .btn-submit::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,.25) 50%, transparent 70%);
    transform: translateX(-100%);
    transition: transform .6s;
}
.profile-main .btn-submit:hover::after { transform: translateX(100%); }

.profile-main .form-actions {
    display: flex;
    gap: .7rem;
    margin-top: 1.5rem;
    flex-wrap: wrap;
}

.password-section {
    margin-top: 1rem;
    padding-top: 1.2rem;
    border-top: 1px solid var(--pd-beige-borde, #d6d4cc);
}
.password-section .section-label {
    font-size: .8rem;
    font-weight: 700;
    color: #888;
    margin-bottom: .8rem;
    letter-spacing: .3px;
}

.toggle-switch {
    display: flex;
    align-items: center;
    gap: .65rem;
    font-size: .85rem;
    font-weight: 500;
    color: var(--pd-oscuro);
    cursor: pointer;
    user-select: none;
    line-height: 1.3;
}
/* Sobrescribir reglas de .input-group-cami label para el toggle */
.input-group-cami label.toggle-switch {
    display: flex;
    font-weight: 500;
    font-size: .85rem;
    margin-bottom: 0;
    letter-spacing: 0;
}
.toggle-switch input { display: none; }
.toggle-switch .toggle-track {
    width: 44px; min-width: 44px; height: 24px;
    background: #c5c3ba;
    border-radius: 24px;
    position: relative;
    transition: background .3s;
    flex-shrink: 0;
    order: -1;
}
.toggle-switch .toggle-track::after {
    content: '';
    position: absolute;
    top: 2px; left: 2px;
    width: 20px; height: 20px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,.18);
    transition: transform .3s, background .3s;
}
.toggle-switch input:checked + .toggle-track {
    background: var(--pd-azul);
}
.toggle-switch input:checked + .toggle-track::after {
    transform: translateX(20px);
    background: #fff;
}

.stats-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: .7rem;
    margin-bottom: 1rem;
}
.stat-box {
    background: var(--pd-bg, #ebeae4);
    border-radius: 14px;
    padding: .8rem;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .6rem;
}
.stat-box .stat-num {
    font-family: var(--font-gilroy, 'Nunito', sans-serif);
    font-weight: 800;
    font-size: 1.4rem;
    color: var(--pd-azul);
    min-width: 36px;
    text-align: right;
}
.stat-box .stat-label {
    font-size: .78rem;
    color: #888;
}

@media (max-width: 768px) {
    .profile-grid { grid-template-columns: 1fr; }
    .profile-sidebar { order: -1; }
}
@media (max-width: 480px) {
    .row-cami { grid-template-columns: 1fr; }
    .card-cami { padding: 1.2rem; }
}
</style>

<div class="profile-wrapper">
    <div class="blob"></div>
    <div class="blob"></div>

    <div class="profile-container">
        <div class="profile-header-bar">
            <div>
                <a href="index.php" class="btn-back d-inline-flex mb-1"><i class="bi bi-arrow-left"></i> Volver a la tienda</a>
                <h1>Mi Perfil</h1>
            </div>
            <a href="logout.php" class="btn-cami-secondary" style="font-size:.82rem;padding:.5rem 1.2rem;">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </a>
        </div>

        <div class="profile-grid">
            <div class="profile-sidebar">
                <div class="card-cami text-center">
                    <div class="avatar-circle">
                        <?= strtoupper(substr($user['first_name'] ?? 'U', 0, 1)) ?>
                    </div>
                    <div class="side-name"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></div>
                    <div class="side-email"><?= htmlspecialchars($user['email']) ?></div>
                    <hr style="border-color:var(--pd-beige-borde);opacity:.5;">
                    <div class="side-info text-start mt-3">
                        <p><i class="bi bi-calendar3 me-2"></i> Miembro desde <?= date('M Y', strtotime($user['created_at'] ?? 'now')) ?></p>
                        <?php if ($user['last_login']): ?>
                        <p><i class="bi bi-clock-history me-2"></i> Último acceso: <?= date('d/m/Y H:i', strtotime($user['last_login'])) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-cami">
                    <div class="stats-row">
                        <div class="stat-box">
                            <div class="stat-num">0</div>
                            <div class="stat-label">Pedidos</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-num">0</div>
                            <div class="stat-label">Reseñas</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-num">0</div>
                            <div class="stat-label">Favoritos</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-main">
                <div class="card-cami">
                    <h3><i class="bi bi-pencil-square"></i> Editar Información</h3>

                    <form method="POST" novalidate>
                        <div class="row-cami">
                            <div class="input-group-cami">
                                <label>Nombre</label>
                                <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" required>
                            </div>
                            <div class="input-group-cami">
                                <label>Apellido</label>
                                <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="row-cami">
                            <div class="input-group-cami">
                                <label>Teléfono</label>
                                <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="300 123 4567">
                            </div>
                            <div class="input-group-cami">
                                <label>Fecha de nacimiento</label>
                                <input type="date" name="birthdate" value="<?= htmlspecialchars($user['birthdate'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="row-cami">
                            <div class="input-group-cami">
                                <label>Tipo de documento</label>
                                <select name="document_type">
                                    <option value="">Seleccionar...</option>
                                    <option value="CC" <?= ($user['document_type'] ?? '') === 'CC' ? 'selected' : '' ?>>Cédula de Ciudadanía</option>
                                    <option value="CE" <?= ($user['document_type'] ?? '') === 'CE' ? 'selected' : '' ?>>Cédula de Extranjería</option>
                                    <option value="TI" <?= ($user['document_type'] ?? '') === 'TI' ? 'selected' : '' ?>>Tarjeta de Identidad</option>
                                    <option value="NIT" <?= ($user['document_type'] ?? '') === 'NIT' ? 'selected' : '' ?>>NIT</option>
                                    <option value="PP" <?= ($user['document_type'] ?? '') === 'PP' ? 'selected' : '' ?>>Pasaporte</option>
                                    <option value="PEP" <?= ($user['document_type'] ?? '') === 'PEP' ? 'selected' : '' ?>>PEP</option>
                                </select>
                            </div>
                            <div class="input-group-cami">
                                <label>Número de documento</label>
                                <input type="text" name="document_number" value="<?= htmlspecialchars($user['document_number'] ?? '') ?>" placeholder="1234567890">
                            </div>
                        </div>
                        <div class="row-cami">
                            <div class="input-group-cami">
                                <label>Género</label>
                                <select name="gender">
                                    <option value="">No especificado</option>
                                    <option value="M" <?= ($user['gender'] ?? '') === 'M' ? 'selected' : '' ?>>Masculino</option>
                                    <option value="F" <?= ($user['gender'] ?? '') === 'F' ? 'selected' : '' ?>>Femenino</option>
                                    <option value="O" <?= ($user['gender'] ?? '') === 'O' ? 'selected' : '' ?>>Otro</option>
                                </select>
                            </div>
                            <div class="input-group-cami" style="display:flex;align-items:flex-end;padding-bottom:.68rem;">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="newsletter_subscribed" <?= ($user['newsletter_subscribed'] ?? 0) ? 'checked' : '' ?>>
                                    <span class="toggle-track"></span>
                                    Recibir newsletter
                                </label>
                            </div>
                        </div>

                        <div class="password-section">
                            <div class="section-label">CAMBIO DE CONTRASEÑA (opcional)</div>
                            <div class="row-cami">
                                <div class="input-group-cami">
                                    <label>Nueva contraseña</label>
                                    <input type="password" name="new_password" placeholder="Mínimo 6 caracteres" autocomplete="new-password">
                                </div>
                                <div class="input-group-cami">
                                    <label>Confirmar nueva contraseña</label>
                                    <input type="password" name="confirm_new_password" placeholder="Repite la contraseña" autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-cami-primary btn-submit">
                                <i class="bi bi-check-lg"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        customClass: {
            popup: 'swal-toast-cami',
            title: 'swal-toast-title',
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    const params = new URLSearchParams(window.location.search);
    const updated = params.get('updated');
    const welcome = params.get('welcome');
    const login = params.get('login');

    if (welcome === '1') {
        Toast.fire({
            icon: 'success',
            title: '¡Bienvenido! Tu cuenta fue creada exitosamente.',
        });
    } else if (login === 'success') {
        Toast.fire({
            icon: 'success',
            title: '¡Hola de nuevo! Has iniciado sesión correctamente.',
        });
    } else if (updated === 'success') {
        Toast.fire({
            icon: 'success',
            title: 'Perfil actualizado correctamente.',
        });
    } else if (updated === 'error') {
        const msg = params.get('msg') || 'Error al actualizar. Intenta de nuevo.';
        Toast.fire({
            icon: 'error',
            title: decodeURIComponent(msg),
            timer: 5000,
        });
    }

    if (params.has('updated') || params.get('welcome') || params.get('login')) {
        window.history.replaceState({}, document.title, 'perfil');
    }
})();
</script>

<style>
.swal-toast-cami {
    border-radius: 16px !important;
    background: #fff !important;
    box-shadow: 0 6px 28px rgba(26,58,92,.15) !important;
    font-family: 'Archivo', sans-serif !important;
    padding: .85rem 1.2rem !important;
}
.swal-toast-cami .swal2-icon {
    margin: 0 .7rem 0 0 !important;
}
.swal-toast-cami .swal2-icon.swal2-success {
    border-color: #3CAEE0 !important;
    color: #3CAEE0 !important;
}
.swal-toast-cami .swal2-icon.swal2-success [class^='swal2-success-line'] {
    background-color: #3CAEE0 !important;
}
.swal-toast-cami .swal2-icon.swal2-success .swal2-success-ring {
    border-color: rgba(60,174,224,.3) !important;
}
.swal-toast-cami .swal2-icon.swal2-error {
    border-color: #E87A7A !important;
    color: #E87A7A !important;
}
.swal-toast-cami .swal2-icon.swal2-error [class^='swal2-x-mark-line'] {
    background-color: #E87A7A !important;
}
.swal-toast-cami .swal2-title {
    font-family: 'Archivo', sans-serif !important;
    font-size: .88rem !important;
    color: #1A3A5C !important;
    font-weight: 500 !important;
}
.swal-toast-cami .swal2-timer-progress-bar {
    background: linear-gradient(90deg, #3CAEE0, #1A3A5C) !important;
    height: 3px !important;
}
</style>

<?php require_once __DIR__ . '/components/footer_mini.php'; ?>
