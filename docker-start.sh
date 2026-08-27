#!/bin/bash

echo "🚀 Menjalankan SIMORO SMANLI dengan Docker Compose..."

# 1. Pastikan Docker berjalan
if ! docker info > /dev/null 2>&1; then
  echo "❌ Error: Docker Desktop belum berjalan. Silakan buka aplikasi Docker Desktop terlebih dahulu."
  exit 1
fi

# 2. Salin .env.docker jika .env belum ada
if [ ! -f .env ]; then
  echo "📄 Membuat file .env dari .env.docker.example..."
  cp .env.docker.example .env
fi

# 3. Build & Run Containers
echo "📦 Membangun & menyalakan container (App, Nginx, MySQL, phpMyAdmin, Redis)..."
docker compose up -d --build

# 4. Tunggu MySQL siap
echo "⏳ Menunggu database MySQL siap..."
sleep 5

# 5. Jalankan composer install, storage link, dan migrasi
echo "⚙️ Menyiapkan dependensi & database..."
docker compose exec app composer install --optimize-autoloader
docker compose exec app php artisan storage:link
docker compose exec app php artisan migrate --force
docker compose exec app php artisan cache:clear
docker compose exec app php artisan view:clear

echo ""
echo "=========================================================="
echo "🎉 SIMORO SMANLI Docker Berhasil Dijalankan!"
echo "=========================================================="
echo "🌐 Web Portal & API   : http://localhost:8000"
echo "📱 Mobile Dashboard    : http://localhost:8000/mobile/dashboard"
echo "⚡ Public API Config   : http://localhost:8000/api/config"
echo "🗄️  phpMyAdmin GUI     : http://localhost:8081 (User: root / Pass: rootsecret123)"
echo "📲 Android Emulator    : http://10.0.2.2:8000/api"
echo "=========================================================="
echo "Untuk mematikan container: docker compose down"
echo ""
