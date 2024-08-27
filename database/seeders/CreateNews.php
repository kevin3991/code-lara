<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class CreateNews extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        News::factory()->count(100)->create();
    }
}
