<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::create([
            'name' => 'PT. Indofood',
            'phone' => '021-12345678',
            'address' => 'Jl. Sudirman No. 1, Jakarta'
        ]);

        Supplier::create([
            'name' => 'PT. Unilever',
            'phone' => '021-87654321',
            'address' => 'Jl. Gatot Subroto No. 2, Jakarta'
        ]);

        Supplier::create([
            'name' => 'PT. Mayora',
            'phone' => '021-11223344',
            'address' => 'Jl. Thamrin No. 3, Jakarta'
        ]);
    }
}
