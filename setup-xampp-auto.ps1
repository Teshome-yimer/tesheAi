# Run as Administrator
$xampp = "C:\xampp java333333"
$public = "C:\xampp java333333\htdocs\tesheai\course-platform\public"
$httpdConf = "$xampp\apache\conf\httpd.conf"
$vhostsConf = "$xampp\apache\conf\extra\httpd-vhosts.conf"
$hostsFile = "C:\Windows\System32\drivers\etc\hosts"

Write-Host "=== EduPlatform XAMPP Auto Setup ===" -ForegroundColor Cyan

# 1. Enable mod_rewrite
$c = Get-Content $httpdConf -Raw
$c = $c -replace '#LoadModule rewrite_module', 'LoadModule rewrite_module'
$c = $c -replace '#Include conf/extra/httpd-vhosts.conf', 'Include conf/extra/httpd-vhosts.conf'
Set-Content $httpdConf $c -Encoding UTF8
Write-Host "[1] httpd.conf updated" -ForegroundColor Green

# 2. Write vhosts
$v = @"
<VirtualHost *:80>
    DocumentRoot "$xampp/htdocs"
    ServerName localhost
    <Directory "$xampp/htdocs">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

<VirtualHost *:80>
    DocumentRoot "$public"
    ServerName course.local
    <Directory "$public">
        AllowOverride All
        Require all granted
        Options -Indexes +FollowSymLinks
    </Directory>
</VirtualHost>
"@
Set-Content $vhostsConf $v -Encoding UTF8
Write-Host "[2] httpd-vhosts.conf written" -ForegroundColor Green

# 3. hosts file
$h = Get-Content $hostsFile -Raw
if ($h -notmatch 'course\.local') {
    Add-Content $hostsFile "`r`n127.0.0.1   course.local"
    Write-Host "[3] hosts file updated" -ForegroundColor Green
} else {
    Write-Host "[3] hosts file already has course.local" -ForegroundColor Yellow
}

# 4. Restart Apache
Write-Host "[4] Restarting Apache..." -ForegroundColor Yellow
Stop-Process -Name "httpd" -Force -ErrorAction SilentlyContinue
Start-Sleep -Seconds 2
Start-Process "$xampp\apache\bin\httpd.exe" -WindowStyle Hidden
Start-Sleep -Seconds 3

if (Get-Process -Name "httpd" -ErrorAction SilentlyContinue) {
    Write-Host "[4] Apache running!" -ForegroundColor Green
} else {
    Write-Host "[4] Apache failed - starting via XAMPP..." -ForegroundColor Red
    Start-Process "$xampp\xampp-control.exe"
}

Write-Host ""
Write-Host "DONE! Open: http://course.local" -ForegroundColor Cyan
Write-Host "Admin: http://course.local/admin/dashboard" -ForegroundColor White
Read-Host "Press Enter to close"
