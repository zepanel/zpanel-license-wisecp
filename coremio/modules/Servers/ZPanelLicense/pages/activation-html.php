<?php
/**
 * zPanel Lisans - Aktivasyon E-postası (HTML)
 */
defined('CORE_FOLDER') OR exit('You can not access this file.');
$licenseKey = $options['creation_info']['license_key'] ?? ($options['password'] ?? '');
$domainOrIp = $options['domain'] ?? ($order['domain'] ?? '');
?>
<link rel="stylesheet" href="coremio/modules/Servers/ZPanelLicense/assets/css/client.css">

<div class="zp-mail-wrap">
    <h2>zPanel Lisansınız Aktif Edildi!</h2>
    <p>Merhaba,</p>
    <p>zPanel kontrol paneli lisansınız başarıyla üretilmiştir. Lisans anahtarınız ve detaylar:</p>
    
    <table class="zp-table">
        <tr class="zp-row-alt">
            <td class="zp-cell-bold">Lisans Anahtarı:</td>
            <td class="zp-code-bold zp-color-primary"><?php echo htmlspecialchars($licenseKey, ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td class="zp-cell-bold">Lisanslı IP / Hostname:</td>
            <td class="zp-code-bold"><?php echo htmlspecialchars($domainOrIp, ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
    </table>
    
    <p>Lisans anahtarınızı sunucunuzda aktifleştirmek için SSH üzerinden şu komutu çalıştırabilirsiniz:</p>
    <pre class="zp-pre-code">zpanel license activate <?php echo htmlspecialchars($licenseKey, ENT_QUOTES, 'UTF-8'); ?></pre>
    
    <p>Saygılarımızla,<br>Lisanslama &amp; Destek Departmanı</p>
</div>
