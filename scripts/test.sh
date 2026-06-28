#!/bin/bash

php artisan db:seed --class=PfcListSeeder
php artisan migrate --path=database/migrations/2024_09_29_094624_create_visitors_table.php
php artisan migrate:refresh --path=database/migrations/2024_09_16_104103_create_renew_worker_forms_table.php
php artisan migrate:refresh --path=database/migrations/2024_02_07_182159_create_worker_application_statuses_table.php

php artisan migrate:refresh --path=database/migrations/2024_02_07_193216_create_main_worker_forms_table.php
