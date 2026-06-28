<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AgeProofSeeder::class,
            BankSeeder::class,
            CategorySeeder::class,
            DesignationSeeder::class,
            DistrictSeeder::class,
            EducationSeeder::class,
            GenderSeeder::class,
            HouseSeeder::class,
            MaritalStatusSeeder::class,
            NatureOfWorkSeeder::class,
            OfficeSeeder::class,
            PostOfficeSeeder::class,
            PostOfficeTempSeeder::class,
            ProfessionSeeder::class,
            RationTypeSeeder::class,
            ResidenceSeeder::class,
            SchemeSeeder::class,
            SkillSeeder::class,
            StateSeeder::class,
            SubDistrictSeeder::class,
            TypeOfIssuerSeeder::class,
            TypeOfWorkSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            AmountSeeder::class,
            RelationSeeder::class,
            TypeOfEmpSeeder::class,
            BloodGroupSeeder::class,
            GalleryCategorySeeder::class,
            PfcListSeeder::class,
            KeyValueSeeder::class,
            ReasonsSeeder::class,
            BenefitSeeder::class,
            DocumentCategorySeeder::class,
            TypeOfBenefitsSeeder::class,
            BenefitFormFieldsSeeder::class
        ]);
    }
}
