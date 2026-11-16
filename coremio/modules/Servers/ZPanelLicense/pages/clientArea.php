<?php
/**
 * WISECP v3 zPanel License Module - Client Area View
 * Reference: https://github.com/wisecp-v3/sample-server-module
 */
defined('CORE_FOLDER') OR exit('You can not access this file.');

$licenseKey  = $data['license_key'] ?? '';
$licenseIp   = $data['license_ip'] ?? '';
$status      = $data['status'] ?? 'Active';
$packageName = $data['package_name'] ?? 'zPanel Sınırsız Lisans';
?>

<!-- Modül Kendi Varlıkları (Assets) -->
<link rel="stylesheet" href="coremio/modules/Servers/ZPanelLicense/assets/css/client.css">
<script src="coremio/modules/Servers/ZPanelLicense/assets/js/client.js"></script>

<div class="zp-wisecp-license">
  <div class="zp-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <div>
        <h2 class="h5 fw-bold mb-1 text-dark"><?php echo htmlspecialchars($packageName); ?></h2>
        <p class="text-muted small mb-0 font-monospace">Durum: <span class="badge bg-success"><?php echo htmlspecialchars($status); ?></span></p>
      </div>
      <div>
        <button class="btn btn-primary fw-bold px-4 py-2 rounded-pill" onclick="copyLicenseKey('<?php echo addslashes($licenseKey); ?>')">
          Anahtarı Kopyala &rarr;
        </button>
      </div>
    </div>
  </div>

  <div class="zp-card">
    <h3 class="h6 fw-bold mb-3 text-dark">Lisans Anahtarı &amp; Tanımlı IP</h3>
    <div class="zp-key-box mb-3 d-flex justify-content-between align-items-center">
      <span><?php echo htmlspecialchars($licenseKey); ?></span>
      <button class="btn btn-sm btn-outline-secondary" onclick="copyLicenseKey('<?php echo addslashes($licenseKey); ?>')">Kopyala</button>
    </div>

    <div class="border rounded-3 p-3 bg-light">
      <div class="row g-3 align-items-center">
        <div class="col-sm-6">
          <div class="small text-muted fw-bold">LİSANSA TANIMLI IP</div>
          <div class="fw-bold font-monospace"><?php echo htmlspecialchars($licenseIp ?: 'Henüz Tanımlanmadı (Kurulumda Otomatik Bağlanır)'); ?></div>
        </div>
        <div class="col-sm-6">
          <form onsubmit="handleReissueIP(event);" class="d-flex gap-2">
            <input type="text" id="zp-license-new-ip" class="form-control form-control-sm font-monospace" placeholder="Yeni IP Girin">
            <button type="submit" class="btn btn-sm btn-dark text-nowrap">IP Değiştir</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="zp-card">
    <h3 class="h6 fw-bold mb-2 text-dark">Tek Komut ile Kurulum</h3>
    <p class="text-muted small mb-3">Temiz Ubuntu / Debian sunucunuzda aşağıdaki komutu çalıştırarak zPanel ve lisansınızı anında kurabilirsiniz:</p>
    <div class="p-3 bg-dark text-white rounded font-monospace small">
      <code>curl -sSL https://get.zepanel.com/install.sh | bash -s -- --license=<?php echo htmlspecialchars($licenseKey); ?></code>
    </div>
  </div>
</div>
