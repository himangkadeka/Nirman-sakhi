#!/bin/bash


php artisan migrate:refresh --path=database/migrations/2024_02_07_182751_create_main_worker_addresses_table.php
php artisan migrate:refresh --path=database/migrations/2024_02_07_185248_create_main_worker_banks_table.php
php artisan migrate:refresh --path=database/migrations/2024_02_07_190015_create_main_worker_basic_details.php
php artisan migrate:refresh --path=database/migrations/2024_02_07_191223_create_main_worker_documents_table.php
php artisan migrate:refresh --path=database/migrations/2024_02_07_192422_create_main_worker_employer_details_table.php
php artisan migrate:refresh --path=database/migrations/2024_02_07_193216_create_main_worker_forms_table.php
php artisan migrate:refresh --path=database/migrations/2024_02_07_194435_create_main_worker_schemes_table.php
