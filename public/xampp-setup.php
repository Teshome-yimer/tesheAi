<?php
// Auto XAMPP setup - open in browser via XAMPP Apache
// http://localhost/tesheai/course-platform/public/xampp-setup.php

$xampp   = 'C:\\xampp java333333';
$public  = 'C:\\xampp java333333\\htdocs\\tesheai\\course-platform\\public';
$results = [];

// 1. Read & update httpd.conf
$httpdConf = $xampp . '\\apache\\conf\\httpd.conf';
if (file_exists($httpdConf)) {
    $c = file_get_contents($httpdConf);
    $changed = false;

    if (strpos($c, '#LoadModule rewrite_module') !== false) {
        $c = str_replace('#LoadModule rewrite_module', 'LoadModule rewrite_module', $c);
        $changed = true;
    }
    if (strpos($c, '#Include conf/extra/httpd-vhosts.conf') !== false) {
        $c = str_replace('#Include conf/extra/httpd-vhosts.conf', 'Include conf/extra/httpd-vhosts.conf', $c);
        $changed = true;
    }

    if ($changed) {
        file_put_contents($httpdConf, $c);
        $results[] = ['✅', 'httpd.conf updated (mod_rewrite + vhosts enabled)'];
    } else {
        $results[] = ['ℹ️', 'httpd.conf already configured'];
    }
} else {
    $results[] = ['❌', 'httpd.conf not found at: ' . $httpdConf];
}

// 2. Write httpd-vhosts.conf
$vhostsConf = $xampp . '\\apache\\conf\\extra\\httpd-vhosts.conf';
$vhost = '<VirtualHost *:80>
    DocumentRoot "' . str_replace('\\','/',$xampp) . '/htdocs"
    ServerName localhost
    <Directory "' . str_replace('\\','/',$xampp) . '/htdocs">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

<VirtualHost *:80>
    DocumentRoot "' . str_replace('\\','/',$public) . '"
    ServerName course.local
    <Directory "' . str_replace('\\','/',$public) . '">
        AllowOverride All
        Require all granted
        Options -Indexes +FollowSymLinks
    </Directory>
</VirtualHost>
';

if (file_put_contents($vhostsConf, $vhost)) {
    $results[] = ['✅', 'httpd-vhosts.conf written successfully'];
} else {
    $results[] = ['❌', 'Failed to write httpd-vhosts.conf'];
}

// 3. Update hosts file
$hostsFile = 'C:\\Windows\\System32\\drivers\\etc\\hosts';
$hostsContent = file_get_contents($hostsFile);
if (strpos($hostsContent, 'course.local') === false) {
    if (file_put_contents($hostsFile, $hostsContent . "\r\n127.0.0.1   course.local\r\n")) {
        $results[] = ['✅', 'hosts file updated — course.local added'];
    } else {
        $results[] = ['⚠️', 'Could not write hosts file — run browser as Administrator OR add manually'];
    }
} else {
    $results[] = ['ℹ️', 'hosts file already has course.local'];
}

// 4. Restart Apache
$apacheExe = $xampp . '\\apache\\bin\\httpd.exe';
$xamppCtrl  = $xampp . '\\xampp_stop.exe';
exec('"' . $xamppCtrl . '"', $out, $code);
sleep(2);
exec('start /B "" "' . $apacheExe . '"', $out2, $code2);
$results[] = ['✅', 'Apache restart command sent — check XAMPP Control Panel'];

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>XAMPP Auto Setup</title>
<style>
body { background:#0a0a0f; color:#e2e8f0; font-family:monospace; padding:40px; }
h1 { color:#6366f1; margin-bottom:24px; }
.row { display:flex; gap:12px; padding:12px 16px; border-radius:8px; margin-bottom:8px; background:#13131a; border:1px solid #2a2a3a; font-size:15px; }
.icon { font-size:1.2rem; }
.next { background:#13131a; border:1px solid #6366f1; border-radius:12px; padding:24px; margin-top:24px; }
.next h2 { color:#22d3ee; margin-bottom:16px; }
.step { padding:10px 0; border-bottom:1px solid #2a2a3a; }
.step:last-child { border:none; }
a.btn { display:inline-block; background:linear-gradient(135deg,#6366f1,#22d3ee); color:#000; font-weight:700; padding:14px 28px; border-radius:8px; text-decoration:none; margin-top:16px; font-size:16px; }
</style>
</head>
<body>
<h1>🔧 XAMPP Auto Setup — EduPlatform</h1>

<?php foreach($results as [$icon, $msg]): ?>
<div class="row"><span class="icon"><?= $icon ?></span><span><?= $msg ?></span></div>
<?php endforeach; ?>

<div class="next">
    <h2>📋 ቀጣይ ደረጃዎች / Next Steps</h2>
    <div class="step">1️⃣ XAMPP Control Panel → Apache → <strong>Stop</strong> then <strong>Start</strong> (Restart)</div>
    <div class="step">2️⃣ Browser ውስጥ ይህን ክፈት: <strong style="color:#22d3ee;">http://course.local</strong></div>
    <div class="step">3️⃣ Admin: <strong>http://course.local/admin/dashboard</strong></div>
    <div class="step" style="color:#fbbf24;">⚠️ hosts file ካልተሰራ — Notepad (Admin) → <code>C:\Windows\System32\drivers\etc\hosts</code> → ይህን ጨምር: <strong>127.0.0.1   course.local</strong></div>
</div>

<a href="http://course.local" class="btn">→ http://course.local ክፈት</a>
</body>
</html>
