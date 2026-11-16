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

<div class="zp-wisecp-license" style="font-family: inherit;">
  
  <!-- Üst Başlık Kartı -->
  <div class="zp-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px; margin-bottom: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
      <div>
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
          <h2 style="font-size: 19px; font-weight: 700; margin: 0; color: #0f172a;"><?php echo htmlspecialchars($packageName); ?></h2>
          <span style="background: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 9999px;">zPanel v1.0</span>
        </div>
        <div style="font-size: 13px; color: #64748b;">
          Durum: 
          <?php if (strtolower($status) === 'active'): ?>
            <span style="background: #dcfce7; color: #15803d; font-weight: 600; padding: 2px 8px; border-radius: 9999px;">Aktif</span>
          <?php else: ?>
            <span style="background: #f1f5f9; color: #475569; font-weight: 600; padding: 2px 8px; border-radius: 9999px;"><?php echo htmlspecialchars($status); ?></span>
          <?php endif; ?>
        </div>
      </div>
      
      <?php if ($isIssued): ?>
      <div>
        <button type="button" class="btn btn-primary" onclick="navigator.clipboard.writeText('<?php echo addslashes($licenseKey); ?>'); this.innerText = 'Kopyalandı!'; setTimeout(() => this.innerText = 'Lisans Anahtarını Kopyala', 2500);" style="background: #2563eb; color: #fff; font-weight: 600; padding: 9px 18px; border-radius: 8px; border: none; cursor: pointer;">
          Lisans Anahtarını Kopyala
        </button>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Lisans Detayı -->
  <div class="zp-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px; margin-bottom: 20px;">
    <h3 style="font-size: 15px; font-weight: 700; margin: 0 0 14px 0; color: #1e293b;">Resmi Lisans Bilgileri</h3>
    
    <?php if ($isIssued): ?>
      <div style="background: #0f172a; border-radius: 8px; padding: 16px 20px; font-family: ui-monospace, monospace; font-size: 16px; font-weight: 700; color: #38bdf8; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <span><?php echo htmlspecialchars($licenseKey); ?></span>
        <span style="font-size: 11.5px; color: #94a3b8; font-family: sans-serif; font-weight: normal; background: #1e293b; padding: 3px 8px; border-radius: 4px;">Partner API Onaylı</span>
      </div>

      <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
          <div>
            <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 4px;">LİSANSA TANIMLI SUNUCU IP</div>
            <div style="font-weight: 700; font-family: ui-monospace, monospace; font-size: 15px; color: #0f172a;">
              <?php echo htmlspecialchars($licenseIp ?: 'Tanımlanmadı (Kurulumda Otomatik Kilitlenir)'); ?>
            </div>
          </div>
          
          <form method="post" action="" style="display: flex; gap: 8px; align-items: center;">
            <input type="hidden" name="module_action" value="ChangeIP">
            <input type="text" name="new_ip" value="<?php echo htmlspecialchars($licenseIp); ?>" placeholder="Yeni IP (Örn: 185.120.45.67)" required style="border: 1px solid #cbd5e1; padding: 7px 12px; border-radius: 6px; font-family: ui-monospace, monospace; font-size: 13px; width: 210px;">
            <button type="submit" style="background: #0f172a; color: #ffffff; border: none; padding: 7px 15px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer;">
              IP Güncelle
            </button>
          </form>
        </div>
      </div>
    <?php else: ?>
      <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 16px; color: #92400e; font-size: 13.5px;">
        Lisans anahtarınız henüz oluşturulmadı veya provizyon aşamasındadır. Lütfen birkaç dakika sonra sayfayı yenileyiniz.
      </div>
    <?php endif; ?>
  </div>

  <?php if ($isIssued): ?>
  <!-- Kurulum Kılavuzu -->
  <div class="zp-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px;">
    <h3 style="font-size: 15px; font-weight: 700; margin: 0 0 10px 0; color: #1e293b;">Hızlı Sunucu Kurulum Komutu</h3>
    <p style="font-size: 13px; color: #64748b; margin-bottom: 12px;">Sunucunuzun root SSH terminaline bağlanarak aşağıdaki tek satırlık komutu çalıştırabilirsiniz:</p>
    <div style="background: #0f172a; color: #38bdf8; font-family: ui-monospace, monospace; padding: 14px 18px; border-radius: 8px; font-size: 13px; overflow-x: auto;">
      curl -fsSL https://get.zepanel.com/install.sh | bash -s -- --license=<?php echo htmlspecialchars($licenseKey); ?>
    </div>
  </div>
  <?php endif; ?>

</div>
