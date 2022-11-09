<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Xoxoday\Disclaimer\Models\Xocode;

class CodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i < 200; $i++){
            Xocode::create([
                'code' => strtoupper(uniqid()),
                'used' => 'No',
                'creation_date' => date('Y-m-d h:i:s', time()),
            ]);
        }
        
    }
}
