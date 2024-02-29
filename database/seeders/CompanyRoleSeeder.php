<?php

namespace Database\Seeders;

use App\Enum\CompanyRoleEnum;
use App\Models\CompanyRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (CompanyRoleEnum::cases() as $key) {
            CompanyRole::query()->firstOrCreate([
                'role' => $key->value,
            ]);
        }
    }
}
