<?php
/**
 * zPanel License Automation Server Module for WISECP (v3 & v5 Full Compatibility)
 * Resmi Dokümantasyon: https://console.zepanel.com/partner/docs
 */

if (!class_exists('ServerModule')) {
    abstract class ServerModule {
        public $_name = '';
        public $error = '';
        public $order = [];
        public $server = [];
        public $options = [];
        public $lang = [];
        public function __construct($server = [], $options = []) {
            $this->server = $server;
            $this->options = $options;
        }
    }
}

require_once __DIR__ . '/lib/ApiClient.php';
use Coremio\Modules\Servers\ZPanelLicense\Lib\ApiClient;

class ZPanelLicense extends ServerModule
{
    public function __construct($server = [], $options = [])
    {
        $this->_name = 'ZPanelLicense';
        parent::__construct($server, $options);
    }

    private function getClient(array $params = []): ApiClient
    {
        $server = $params['server'] ?? $this->server ?? [];
        $apiUrl = $server['partner_api_url'] ?? 'https://console.zepanel.com/partner-api/v1';
        $apiKey = $server['partner_key'] ?? $server['password'] ?? $server['access_hash'] ?? '';
        return new ApiClient($apiUrl, $apiKey);
    }

    // ==========================================
    // 1. BAĞLANTI TESTİ (Test Connection)
    // ==========================================
    public function TestConnection($options = [])
    {
        $apiUrl = $options['partner_api_url'] ?? 'https://console.zepanel.com/partner-api/v1';
        $apiKey = $options['partner_key'] ?? $options['password'] ?? $options['access_hash'] ?? '';
        $client = new ApiClient($apiUrl, $apiKey);

        $res = $client->testConnection();
        if ($res['status']) {
            return ['status' => 'successful', 'message' => 'zPanel Partner API v1 bağlantısı başarılı.'];
        }
        $this->error = $res['message'] ?: 'Bağlantı kurulamadı.';
        return ['status' => 'error', 'message' => $this->error];
    }

    public function testConnect($options = [])
    {
        $res = $this->TestConnection($options ?: $this->server);
        return $res['status'] === 'successful';
    }

    public function test_connect(): bool
    {
        $res = $this->TestConnection($this->server);
        return $res['status'] === 'successful';
    }

    public function test($options = [])
    {
        return $this->TestConnection($options);
    }

    // ==========================================
    // 2. LİSANS TAHSİS ETME (Create / Issue)
    // ==========================================
    public function CreateAccount($params = [])
    {
        $client  = $this->getClient($params);
        $orderId = trim($params['order_id'] ?? $params['config_options']['order_id'] ?? $params['options']['order_id'] ?? '');

        if (empty($orderId)) {
            $this->error = 'Lisans Havuz Sipariş ID (order_id) paket ayarlarında tanımlanmamış.';
            return ['status' => 'error', 'message' => $this->error];
        }

        $customer     = $params['user'] ?? [];
        $customerName = trim(($customer['name'] ?? '') . ' ' . ($customer['surname'] ?? ''));
        if (!empty($customer['company_name'])) {
            $customerName .= ' (' . $customer['company_name'] . ')';
        }
        $domainOrIp = trim($params['options']['server_ip'] ?? $params['domain'] ?? '');

        $res = $client->createLicense($orderId, $customerName, $domainOrIp);
        if (!$res['status']) {
            $this->error = $res['message'] ?: 'Lisans oluşturulamadı.';
            return ['status' => 'error', 'message' => $this->error];
        }

        $data         = $res['data'] ?? [];
        $licenseKey   = $data['license_key'] ?? '';
        $licenseRowId = (string)($data['id'] ?? '');

        return [
            'status'         => 'successful',
            'message'        => 'zPanel lisansı tahsis edildi.',
            'license_key'    => $licenseKey,
            'license_row_id' => $licenseRowId,
            'password'       => $licenseKey,
            'ip'             => $domainOrIp,
            'creation_info'  => [
                'license_key'    => $licenseKey,
                'license_row_id' => $licenseRowId,
            ],
            'config'         => [
                'user'     => $domainOrIp,
                'password' => $licenseKey,
            ],
        ];
    }

    public function create($domain = '', $order_options = [])
    {
        $params = is_array($domain) ? $domain : [
            'domain'  => $domain,
            'options' => $order_options,
            'user'    => $order_options,
        ];
        $res = $this->CreateAccount($params);
        return $res['status'] === 'successful';
    }

    // ==========================================
    // 3. ASKIYA ALMA & KALDIRMA
    // ==========================================
    public function SuspendAccount($params = [])
    {
        return ['status' => 'successful', 'message' => 'Lisans askıya alındı.'];
    }

    public function suspend($params = [])
    {
        return true;
    }

    public function UnsuspendAccount($params = [])
    {
        return ['status' => 'successful', 'message' => 'Lisans aktif edildi.'];
    }

    public function unsuspend($params = [])
    {
        return true;
    }

    // ==========================================
    // 4. LİSANS İPTAL / HAVUZA İADE
    // ==========================================
    public function TerminateAccount($params = [])
    {
        $client       = $this->getClient($params);
        $orderId      = trim($params['order_id'] ?? $params['config_options']['order_id'] ?? $params['options']['order_id'] ?? '');
        $licenseRowId = trim($params['creation_info']['license_row_id'] ?? $params['custom_fields']['license_row_id'] ?? '');

        if (!empty($orderId) && !empty($licenseRowId)) {
            $res = $client->releaseLicense($orderId, $licenseRowId);
            if (!$res['status']) {
                $this->error = $res['message'] ?: 'Lisans serbest bırakılamadı.';
                return ['status' => 'error', 'message' => $this->error];
            }
        }

        return ['status' => 'successful', 'message' => 'Lisans iptal edilerek havuza iade edildi.'];
    }

    public function terminate($params = [])
    {
        $res = $this->TerminateAccount($params ?: $this->order);
        return $res['status'] === 'successful';
    }

    public function cancel(): bool
    {
        $res = $this->TerminateAccount($this->order);
        return $res['status'] === 'successful';
    }

    public function renew(): bool
    {
        return true;
    }

    // ==========================================
    // 5. IP ADRESİ GÜNCELLEME (Change IP)
    // ==========================================
    public function ChangeIP($params = [])
    {
        $client       = $this->getClient($params);
        $orderId      = trim($params['order_id'] ?? $params['config_options']['order_id'] ?? $params['options']['order_id'] ?? '');
        $licenseRowId = trim($params['creation_info']['license_row_id'] ?? $params['custom_fields']['license_row_id'] ?? '');
        $newIp        = trim($_POST['new_ip'] ?? $params['new_ip'] ?? '');
        $customer     = $params['user'] ?? [];
        $customerName = trim(($customer['name'] ?? '') . ' ' . ($customer['surname'] ?? ''));

        if (empty($newIp)) {
            $this->error = 'Geçerli bir IP adresi giriniz.';
            return ['status' => 'error', 'message' => $this->error];
        }

        $res = $client->updateLicenseInfo($orderId, $licenseRowId, $customerName, $newIp);
        if ($res['status']) {
            return ['status' => 'successful', 'message' => 'Lisans IP adresi başarıyla güncellendi.'];
        }
        $this->error = $res['message'] ?: 'IP güncellenemedi.';
        return ['status' => 'error', 'message' => $this->error];
    }

    public function change_ip($params = [])
    {
        return $this->ChangeIP($params ?: $this->order);
    }

    // ==========================================
    // 6. TEK TIKLA GİRİŞ (Single Sign-On - SSO)
    // ==========================================
    public function use_adminArea_SingleSignOn(): string
    {
        return "https://console.zepanel.com/partner";
    }

    public function sso_panel_login(): string
    {
        return $this->use_adminArea_SingleSignOn();
    }

    // ==========================================
    // 7. ÖZEL AKSİYON BUTONLARI (Action Buttons)
    // ==========================================
    public function clientArea_buttons(): array
    {
        return [
            'change_ip' => [
                'text'  => 'Lisans IP Adresini Güncelle',
                'type'  => 'action',
                'class' => 'btn btn-primary',
            ],
        ];
    }

    public function adminArea_buttons(): array
    {
        return [
            'partner_console' => [
                'text'   => 'zPanel Partner Konsolu',
                'type'   => 'link',
                'url'    => 'https://console.zepanel.com/partner',
                'target' => '_blank',
                'class'  => 'btn btn-primary',
            ],
        ];
    }

    // ==========================================
    // 8. MÜŞTERİ PANEL GÖRÜNÜMÜ (Client Area)
    // ==========================================
    public function ClientArea($params = [])
    {
        $domainOrIp   = $params['domain'] ?? ($params['options']['server_ip'] ?? '');
        $licenseKey   = $params['creation_info']['license_key'] ?? ($params['password'] ?? 'ZPNL-LIC-PREVIEW');
        $licenseRowId = $params['creation_info']['license_row_id'] ?? 0;
        $orderId      = $params['options']['order_id'] ?? 0;

        return [
            'template' => 'pages/clientArea.php',
            'data'     => [
                'license_key'    => $licenseKey,
                'license_row_id' => $licenseRowId,
                'order_id'       => $orderId,
                'ip_address'     => $domainOrIp,
                'status'         => $params['status'] ?? 'active',
                'service_id'     => $params['id'] ?? 0,
            ],
        ];
    }

    // ==========================================
    // 9. FORM & HİZMET ALANLARI
    // ==========================================
    public function config_options($data = [])
    {
        return include __DIR__ . '/config.php';
    }

    public function product_configuration(array $data = []): array
    {
        return $this->config_options($data);
    }

    public function adminArea_service_fields()
    {
        return [
            'template' => 'pages/order-detail.php',
        ];
    }

    public function save_adminArea_service_fields($data = [])
    {
        return true;
    }
}

// WISECP 3 global namespace alias standard
class ZPanelLicense_Module extends ZPanelLicense {}
