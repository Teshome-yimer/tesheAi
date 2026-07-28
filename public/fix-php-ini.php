<?php
// Check current PHP limits
echo "<div style='background:#0a0a0f;color:#e2e8f0;font-family:monospace;padding:32px;font-size:14px;'>";
echo "<h2 style='color:#6366f1;'>PHP Upload Limits</h2>";
echo "<br>";
echo "upload_max_filesize: <b style='color:" . (ini_get('upload_max_filesize') == '2M' ? '#ef4444' : '#10b981') . "'>" . ini_get('upload_max_filesize') . "</b><br>";
echo "post_max_size: <b style='color:#22d3ee'>" . ini_get('post_max_size') . "</b><br>";
echo "max_execution_time: <b style='color:#22d3ee'>" . ini_get('max_execution_time') . "s</b><br>";
echo "memory_limit: <b style='color:#22d3ee'>" . ini_get('memory_limit') . "</b><br><br>";

$iniFile = php_ini_loaded_file();
echo "php.ini location: <b style='color:#fbbf24'>" . $iniFile . "</b><br><br>";

// Try to update php.ini
if ($iniFile && is_writable($iniFile)) {
    $content = file_get_contents($iniFile);
    $content = preg_replace('/upload_max_filesize\s*=\s*\S+/', 'upload_max_filesize = 2048M', $content);
    $content = preg_replace('/post_max_size\s*=\s*\S+/', 'post_max_size = 2048M', $content);
    $content = preg_replace('/max_execution_time\s*=\s*\S+/', 'max_execution_time = 300', $content);
    $content = preg_replace('/memory_limit\s*=\s*\S+/', 'memory_limit = 512M', $content);
    file_put_contents($iniFile, $content);
    echo "<span style='color:#10b981'>✅ php.ini updated! Restart Apache then come back.</span><br>";
} else {
    echo "<span style='color:#fbbf24'>⚠️ Cannot auto-update php.ini. Update manually:</span><br><br>";
    echo "Open: <b>" . $iniFile . "</b><br><br>";
    echo "Find and change these 4 lines:<br>";
    echo "<pre style='background:#13131a;padding:16px;border-radius:8px;margin-top:8px;color:#22d3ee;'>";
    echo "upload_max_filesize = 2048M\n";
    echo "post_max_size = 2048M\n";
    echo "max_execution_time = 300\n";
    echo "memory_limit = 512M";
    echo "</pre>";
}
echo "</div>";
