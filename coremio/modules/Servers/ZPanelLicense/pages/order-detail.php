<?php
/**
 * zPanel Lisans Dağıtım - Admin Sipariş Detay Formu (Order Detail)
 * WiseCP 3 ve WiseCP 5 Çekirdek Standartlarına Uygundur.
 */
defined('CORE_FOLDER') OR exit('You can not access this file.');

$LANG     = $module->lang ?? [];
$order    = isset($order) && $order ? $order : [];
$options  = isset($order['options']) ? $order['options'] : [];
$config   = isset($options['config']) ? $options['config'] : [];
$creation = isset($options['creation_info']) ? $options['creation_info'] : [];

$licenseKey   = $creation['license_key'] ?? ($config['password'] ?? ($options['license_key'] ?? ''));
$licenseRowId = $creation['license_row_id'] ?? ($options['license_row_id'] ?? '');
$domainOrIp   = $options['domain'] ?? ($order['domain'] ?? ($config['user'] ?? ''));
$partnerUrl   = 'https://console.zepanel.com/partner';

$esc = function ($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); };
?>
<link rel="stylesheet" href="coremio/modules/Servers/ZPanelLicense/assets/css/admin.css">

<div class="zp-admin-section">
    <h4 class="zp-admin-section-heading">zPanel Lisans Yönetimi</h4>

    <div class="zp-admin-grid-server">
        <div>
            <label class="zp-admin-label">Lisans Anahtarı (License Key)</label>
            <input type="text" name="creation_info[license_key]" value="<?php echo $esc($licenseKey); ?>" class="zp-admin-input-mono">
        </div>
        <div>
            <label class="zp-admin-label">Lisans Sıra ID (Row ID)</label>
            <input type="text" name="creation_info[license_row_id]" value="<?php echo $esc($licenseRowId); ?>" readonly class="zp-admin-input">
        </div>
        <div>
            <label class="zp-admin-label">Lisanslı IP Adresi</label>
            <input type="text" name="domain" value="<?php echo $esc($domainOrIp); ?>" class="zp-admin-input-bold">
        </div>
    </div>

    <div class="zp-admin-row-margin">
        <a href="<?php echo $esc($partnerUrl); ?>" target="_blank" class="zp-btn-test-conn">
            <span>zPanel Partner Konsoluna Git &rarr;</span>
        </a>
    </div>
</div>
