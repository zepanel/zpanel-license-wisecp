<?php
/**
 * WISECP v3 zPanel License Module - Client Area View
 * Reference: https://github.com/wisecp-v3/sample-server-module
 * Dokümantasyon: https://console.zepanel.com/partner/docs
 */
defined('CORE_FOLDER') OR exit('You can not access this file.');

$licenseKey  = $data['license_key'] ?? '';
$licenseIp   = $data['license_ip'] ?? '';
$status      = $data['status'] ?? 'Active';
$packageName = $data['package_name'] ?? 'zPanel Sunucu Lisansı';
$isIssued    = !empty($licenseKey);
?>

<link rel="stylesheet" href="coremio/modules/Servers/ZPanelLicense/assets/css/client.css">

<div class="zp-wisecp-license">
  
  <!-- Üst Başlık Kartı -->
  <div class="zp-card">
    <div class="zp-header-flex">
      <div>
        <div class="zp-title-wrap">
          <h2 class="zp-main-title"><?php echo htmlspecialchars($packageName, ENT_QUOTES, 'UTF-8'); ?></h2>
          <span class="zp-ver-badge">zPanel v1.0</span>
        </div>
        <div class="zp-meta-sub">
          Durum: 
          <?php if (strtolower($status) === 'active'): ?>
            <span class="zp-status-active">Aktif</span>
          <?php else: ?>
            <span class="zp-status-default"><?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?></span>
          <?php endif; ?>
        </div>
      </div>
      
      <?php if ($isIssued): ?>
      <div>
        <button type="button" class="zp-btn-copy" onclick="navigator.clipboard.writeText('<?php echo addslashes($licenseKey); ?>'); this.innerText = 'Kopyalandı!'; setTimeout(() => this.innerText = 'Lisans Anahtarını Kopyala', 2500);">
          Lisans Anahtarını Kopyala
        </button>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Lisans Detayı -->
  <div class="zp-card">
    <h3 class="zp-section-title">Resmi Lisans Bilgileri</h3>
    
    <?php if ($isIssued): ?>
      <div class="zp-key-box">
        <span><?php echo htmlspecialchars($licenseKey, ENT_QUOTES, 'UTF-8'); ?></span>
        <span class="zp-key-tag">Partner API Onaylı</span>
      </div>

      <div class="zp-ip-panel">
        <div class="zp-ip-inner">
          <div>
            <div class="zp-ip-label">LİSANSA TANIMLI SUNUCU IP</div>
            <div class="zp-ip-val">
              <?php echo htmlspecialchars($licenseIp ?: 'Tanımlanmadı (Kurulumda Otomatik Kilitlenir)', ENT_QUOTES, 'UTF-8'); ?>
            </div>
          </div>
          
          <form method="post" action="" class="zp-ip-form">
            <?php if (function_exists('token')): ?>
              <input type="hidden" name="token" value="<?php echo token(); ?>">
            <?php endif; ?>
            <input type="hidden" name="module_action" value="ChangeIP">
            <input type="text" name="new_ip" value="<?php echo htmlspecialchars($licenseIp, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Yeni IP (Örn: 185.120.45.67)" required class="zp-ip-input">
            <button type="submit" class="zp-ip-submit">
              IP Güncelle
            </button>
          </form>
        </div>
      </div>
    <?php else: ?>
      <div class="zp-alert-pending">
        Lisans anahtarınız henüz oluşturulmadı veya provizyon aşamasındadır. Lütfen birkaç dakika sonra sayfayı yenileyiniz.
      </div>
    <?php endif; ?>
  </div>

  <?php if ($isIssued): ?>
  <!-- Kurulum Kılavuzu -->
  <div class="zp-card">
    <h3 class="zp-section-title">Hızlı Sunucu Kurulum Komutu</h3>
    <p class="zp-guide-p">Sunucunuzun root SSH terminaline bağlanarak aşağıdaki tek satırlık komutu çalıştırabilirsiniz:</p>
    <div class="zp-code-terminal">
      curl -fsSL https://get.zepanel.com/install.sh | bash -s -- --license=<?php echo htmlspecialchars($licenseKey, ENT_QUOTES, 'UTF-8'); ?>
    </div>
  </div>
  <?php endif; ?>

</div>
