php artisan migrate --path="database/migrations/2024_09_27_114800_create_pfc_lists_table.php"
php artisan migrate --path="database\migrations\2024_09_26_100819_create_worker_ninety_days_certificates_table.php"
php artisan db:seed --class=PfcListSeeder
php artisan migrate --path=database/migrations/2024_09_29_094624_create_visitors_table.php
php artisan migrate:refresh --path=database/migrations/2024_09_16_104103_create_renew_worker_forms_table.php
php artisan migrate:refresh --path=database/migrations/2024_02_07_182159_create_worker_application_statuses_table.php

php artisan migrate:refresh --path=database/migrations/2024_02_07_193216_create_main_worker_forms_table.php


4th October

php artisan migrate:refresh --path=database\migrations\2024_02_07_082246_create_temporary_worker_addresses_table.php
php artisan migrate:refresh --path=database\migrations\2024_02_07_182751_create_main_worker_addresses_table.php

15th Oct
php artisan migrate:refresh --path=database\migrations\2024_04_17_153638_create_worker_id_cards_table.php

php artisan migrate:refresh --path=database\migrations\2024_06_03_062643_create_pfc_kiosk_details_table.php


21st Oct
php artisan migrate:refresh --path=database/migrations/2024_02_07_180201_create_temporary_worker_families_table.php
php artisan migrate:refresh --path=database/migrations/2024_02_07_072635_create_main_worker_families_table.php

2nd January 2025
php artisan migrate:refresh --path=database/migrations/2024_02_07_053427_create_main_worker_certificates_table.php
php artisan migrate:refresh --path=database/migrations/2024_02_07_073851_create_temporary_worker_certificates_table.php
 php artisan db:seed --class=TypeOfWorkSeeder



 <!-- Benefit -->

php artisan migrate --path=database\migrations\2025_08_10_162442_add_aadhaar_verification_to_main_worker_families_table.php
php artisan migrate --path=database\migrations\2025_08_11_080932_add_applicant_family_member_id_form_submissions_table
