Write-Host "=== SIMRS RS Ar Bunda Lubuklinggau ===" -ForegroundColor Cyan
Write-Host ""
Write-Host "Memulai server di http://localhost:8000" -ForegroundColor Yellow
Write-Host "Login: admin@rsarbunda.com / password" -ForegroundColor Green
Write-Host ""

php artisan serve --port=8000 --host=0.0.0.0
