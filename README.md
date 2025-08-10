cara menjalanakan backup di cli contoh :

php artisan transactionmonth:migrate --month=2025-05 //jangan gunakan ini
php artisan transaction:migrate --date=2025-05-01 //backup harian gunakan ini

note: sesuaikan dengan bulan dan tahun yang inin di backup contoh diatas backup untuk bulan 05 2025

tambahkan env untuk database old data
DB_OLD_HOST=127.0.0.1
DB_OLD_PORT=3306
DB_OLD_DATABASE=old_global_bola
DB_OLD_USERNAME=root
DB_OLD_PASSWORD=

composer dump-autoload
