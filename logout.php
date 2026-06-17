<?php
require_once __DIR__ . '/controller/auth.php';
logoutCustomer();
header('Location: index.php?logged_out=1');
exit;
