<?php
require_once __DIR__ . '/conexion.php';

class MegapagosClient
{
    private $conn;
    private $config;
    private $accessToken = null;
    private $idusuario = null;
    private $cachedBanks = null;

    private function log($mensaje, $data = null)
    {
        $dir = __DIR__ . '/../logs';
        if (!is_dir($dir)) { mkdir($dir, 0755, true); }
        $line = '[' . date('Y-m-d H:i:s') . '] MEGAPAGOS: ' . $mensaje;
        if ($data !== null) {
            $line .= ' | ' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        $line .= PHP_EOL;
        file_put_contents($dir . '/megapagos_' . date('Y-m-d') . '.log', $line, FILE_APPEND | LOCK_EX);
    }

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->cargarConfig();
    }

    private function cargarConfig()
    {
        $sql = "SELECT * FROM megapagos_config WHERE id = 1 LIMIT 1";
        $res = mysqli_query($this->conn, $sql);
        if (!$res || mysqli_num_rows($res) === 0) {
            throw new Exception('No se encontró la configuración de MEGAPAGOS. Configure la tabla megapagos_config.');
        }
        $this->config = mysqli_fetch_assoc($res);
    }

    private function baseUrl()
    {
        return $this->config['test_mode'] == 1
            ? $this->config['base_url_qa']
            : $this->config['base_url_prod'];
    }

    private function postPlain($endpoint, $plainData)
    {
        $url = $this->baseUrl() . $endpoint;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: text/plain',
            'Accept: application/json',
            'Authorization: Bearer ' . $this->accessToken,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $plainData);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception('Error de conexión con MEGAPAGOS: ' . $error);
        }

        return ['code' => $httpCode, 'body' => json_decode($response, true)];
    }

    public function encryptData($plainText)
    {
        if (!$this->accessToken) {
            $this->login();
        }

        $res = $this->postPlain('/api/transaction/encrypt-data', $plainText);

        if ($res['code'] === 401) {
            $this->login();
            $res = $this->postPlain('/api/transaction/encrypt-data', $plainText);
        }

        if ($res['code'] !== 200) {
            $this->log('encryptData ERROR: HTTP ' . $res['code'], $res['body']);
            throw new Exception('Error al encriptar datos: HTTP ' . $res['code'] . ' - ' . json_encode($res['body']));
        }

        $this->log('encryptData OK');
        return $res['body']['data'] ?? null;
    }

    private function post($endpoint, $data, $auth = false)
    {
        $url = $this->baseUrl() . $endpoint;
        $payload = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);
        if ($auth && $this->accessToken) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer ' . $this->accessToken,
            ]);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception('Error de conexión con MEGAPAGOS: ' . $error);
        }

        return ['code' => $httpCode, 'body' => json_decode($response, true)];
    }

    private function get($endpoint)
    {
        $url = $this->baseUrl() . $endpoint;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Authorization: Bearer ' . $this->accessToken,
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception('Error de conexión con MEGAPAGOS: ' . $error);
        }

        return ['code' => $httpCode, 'body' => json_decode($response, true)];
    }

    public function login()
    {
        $res = $this->post('/api/user/login-comercio', [
            'user' => $this->config['api_user'],
            'pass' => $this->config['api_pass'],
            'tokens' => null,
            'loginDirecto' => true,
            'client' => 'api',
        ]);

        if ($res['code'] === 200 && isset($res['body']['data']['token']['accessToken'])) {
            $this->accessToken = $res['body']['data']['token']['accessToken'];
            $this->idusuario = $res['body']['data']['comercio']['idusuario'] ?? null;
            $this->log('login OK, idusuario: ' . $this->idusuario);
            return $res['body']['data'];
        }

        $this->log('login ERROR: HTTP ' . $res['code'], $res['body']);
        $errorMsg = $res['body']['error'] ?? 'Error de autenticación';
        throw new Exception($errorMsg);
    }

    public function getBanks()
    {
        if (!$this->accessToken) {
            $this->login();
        }

        $res = $this->get('/api/transaction/get-banks');

        if ($res['code'] === 401) {
            $this->login();
            $res = $this->get('/api/transaction/get-banks');
        }

        return $res['body'];
    }

    public function createPseTransaction($orderData)
    {
        if (!$this->accessToken) {
            $this->login();
        }

        $docTypeMap = [
            'CC' => 'CedulaDeCiudadania',
            'CE' => 'CedulaDeExtranjeria',
            'NIT' => 'Nit',
            'TI' => 'TarjetaDeIdentidad',
            'PP' => 'Pasaporte',
            'PEP' => 'Pasaporte',
        ];
        $rawDocType = $orderData['document_type'] ?? 'CedulaDeCiudadania';
        $mappedDocType = $docTypeMap[$rawDocType] ?? $rawDocType;

        $bankCode = $orderData['bank_code'] ?? '';
        $validBanks = $this->getBanksCached();
        $validCodes = [];
        if (isset($validBanks['data']) && is_array($validBanks['data'])) {
            foreach ($validBanks['data'] as $b) {
                $c = $b['financialInstitutionCode'] ?? $b['code'] ?? '';
                if ($c !== '' && $c !== '0') {
                    $validCodes[] = $c;
                }
            }
        }
        if (!empty($validCodes) && !in_array($bankCode, $validCodes, true)) {
            $this->log('ERROR: bank_code invalido: ' . $bankCode, ['valid_codes' => $validCodes]);
            throw new Exception('Código de banco inválido: ' . $bankCode);
        }

        $unitPrice = (float) ($orderData['unit_price'] ?? 0);
        $quantity = (int) ($orderData['quantity'] ?? 1);
        $shippingCost = (float) ($orderData['shipping_cost'] ?? 0);
        $totalAmount = (float) ($orderData['total_amount'] ?? 0);

        $expectedTotal = ($unitPrice * $quantity) + $shippingCost;
        if ($totalAmount <= 0) {
            $totalAmount = $expectedTotal;
        }

        $payload = [
            'data' => [
                'extraData' => [
                    'idusuario' => (string) $this->idusuario,
                    'idtipooperacion' => 5,
                    'idtiposolicitud' => 5,
                    'linkcode' => '-1',
                    'solicitudenvio' => 'N',
                    'externalurl' => $orderData['external_url'] ?? '',
                ],
                'step1' => [
                    'name' => $orderData['product_name'] ?? 'Producto Poder Down',
                    'description' => $orderData['product_description'] ?? 'Compra en tienda Poder Down',
                    'value' => $unitPrice,
                    'in_stock' => true,
                    'idimpuesto' => $orderData['tax_id'] ?? 21,
                    'shipping_cost' => $shippingCost,
                    'requested_units' => $quantity,
                    'total_amount' => $totalAmount,
                    'payment_amount' => 0,
                ],
                'step3' => [
                    'terms_and_conditions' => true,
                    'payment_method' => 'pse',
                    'biller_name' => $orderData['payer_name'],
                    'biller_email' => $orderData['payer_email'],
                    'biller_address' => $orderData['payer_address'] ?? '',
                    'payment_info' => [
                        'pse_bank' => $bankCode,
                        'pse_person_type' => $orderData['person_type'] ?? 'person',
                        'pse_document' => $orderData['document_number'],
                        'pse_name' => $orderData['payer_name'],
                        'pse_phone' => $orderData['payer_phone'],
                        'pse_document_type' => $mappedDocType,
                    ],
                ],
            ],
        ];

        $this->log('createPseTransaction payload (plain)', $payload);
        $this->log('createPseTransaction numeric check', [
            'unit_price' => $unitPrice,
            'quantity' => $quantity,
            'shipping_cost' => $shippingCost,
            'total_amount' => $totalAmount,
            'expected_total' => $expectedTotal,
            'bank_code' => $bankCode,
            'document_type' => $mappedDocType . ' (raw: ' . $rawDocType . ')',
        ]);

        $plainJson = json_encode($payload, JSON_UNESCAPED_UNICODE);
        $encrypted = $this->encryptData($plainJson);

        if (!$encrypted) {
            throw new Exception('No se pudo encriptar los datos para la transacción.');
        }

        $res = $this->post('/api/transaction/create', ['data' => $encrypted], true);

        if ($res['code'] === 401) {
            $this->login();
            $encrypted = $this->encryptData($plainJson);
            $res = $this->post('/api/transaction/create', ['data' => $encrypted], true);
        }

        if ($res['code'] === 422) {
            $this->log('createPseTransaction 422 ERROR - FULL BODY', $res['body']);
            $errorMsg = $res['body']['data']['error'] ?? json_encode($res['body']);
            throw new Exception('Error de validación: ' . $errorMsg);
        }

        if ($res['code'] === 500) {
            $this->log('createPseTransaction 500 ERROR - FULL BODY', $res['body']);
            $errorMsg = $res['body']['error'] ?? json_encode($res['body']);
            throw new Exception('Error interno MEGAPAGOS: ' . $errorMsg);
        }

        $this->log('createPseTransaction OK', $res['body']);
        return $res['body']['data'] ?? $res['body'];
    }

    private function getBanksCached()
    {
        if ($this->cachedBanks !== null) {
            return $this->cachedBanks;
        }
        $this->cachedBanks = $this->getBanks();
        return $this->cachedBanks;
    }

    public function getTransactionInfo($transactionId)
    {
        if (!$this->accessToken) {
            $this->login();
        }

        $this->log('getTransactionInfo for: ' . $transactionId);

        $publicKey = $this->getPublicKey();
        $encryptedId = $this->rsaEncrypt($transactionId, $publicKey);
        $this->log('getTransactionInfo encrypted (RSA): ' . substr($encryptedId, 0, 50) . '...');

        $payload = ['transactionId' => $encryptedId];
        $this->log('getTransactionInfo payload', $payload);

        $res = $this->post('/api/transaction/get-info', $payload, true);

        if ($res['code'] === 401) {
            $this->login();
            $res = $this->post('/api/transaction/get-info', $payload, true);
        }

        $this->log('getTransactionInfo response: HTTP ' . $res['code'], $res['body']);
        return $res['body'];
    }

    private function getPublicKey()
    {
        $res = $this->get('/api/key/public');
        if ($res['code'] !== 200) {
            throw new Exception('No se pudo obtener la llave pública');
        }
        $key = $res['body']['data']['public_key'] ?? null;
        if (!$key) {
            throw new Exception('Llave pública vacía');
        }
        return $key;
    }

    private function rsaEncrypt($data, $publicKeyBase64)
    {
        $publicKey = base64_decode($publicKeyBase64);
        if (!$publicKey) {
            throw new Exception('No se pudo decodificar la llave pública');
        }
        $keyResource = openssl_pkey_get_public($publicKey);
        if (!$keyResource) {
            throw new Exception('No se pudo cargar la llave pública RSA');
        }
        $encrypted = '';
        if (!openssl_public_encrypt($data, $encrypted, $keyResource, OPENSSL_PKCS1_PADDING)) {
            throw new Exception('Error al encriptar con RSA');
        }
        $inner = json_encode(['encryptedKey' => base64_encode($encrypted)], JSON_UNESCAPED_UNICODE);
        return base64_encode($inner);
    }
}
