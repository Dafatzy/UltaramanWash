# CarWashPro

Sistem Informasi Manajemen Jasa Cuci Kendaraan berbasis PHP + MySQL + Docker.

## Menjalankan dengan Docker

```bash
docker compose up -d --build
```

Buka:
- Aplikasi: http://localhost:8080
- phpMyAdmin: http://localhost:8081

## Akun demo

- Admin: `admin` / `admin123`
- Kasir: `kasir` / `kasir123`
- Washer: `washer` / `washer123`

## Menghentikan aplikasi

```bash
docker compose down
```

Data database tetap tersimpan pada Docker volume `db_data`.
