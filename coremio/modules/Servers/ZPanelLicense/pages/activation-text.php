<?php
/**
 * zPanel Lisans - Aktivasyon E-postası (Metin)
 */
defined('CORE_FOLDER') OR exit('You can not access this file.');
$licenseKey = $options['creation_info']['license_key'] ?? ($options['password'] ?? '');
$domainOrIp = $options['domain'] ?? ($order['domain'] ?? '');
?>
zPanel Lisansınız Aktif Edildi!

Lisans Anahtarı: <?php echo $licenseKey; ?>

Lisanslı IP / Hostname: <?php echo $domainOrIp; ?>

Lisansı aktifleştirmek için SSH üzerinden:
zpanel license activate <?php echo $licenseKey; ?>

Saygılarımızla,
Lisanslama & Destek Departmanı
