<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\DiscountModel;

class DiscountSeeder extends Seeder
{
    public function run()
    {
        $model = new DiscountModel();
        $baseDate = new \DateTime();

        for ($i = 0; $i < 10; $i++) {
            $tanggal = clone $baseDate;

            $model->save([
                'tanggal'    => $tanggal->format('Y-m-d'),
                'nominal'    => rand(50000, 150000),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $baseDate->modify('+1 day');
        }
    }
}