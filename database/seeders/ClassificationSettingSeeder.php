<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClassificationSetting;

class ClassificationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClassificationSetting::truncate();
        
        ClassificationSetting::create([
            'price_general' => 50000,
            'price_preferential' => 30000,
            'max_items' => 50,
            'max_attachment_size_mb' => 10,
            'required_fields' => json_encode(['commercial_name']),
        ]);
    }
}
