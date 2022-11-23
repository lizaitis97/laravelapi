<?php

namespace Database\Seeders;
use App\Models\Blogpost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogpostSeeder extends Seeder {
    public function run(){
        Blogpost::factory()->count(20)->create();
    }
}
