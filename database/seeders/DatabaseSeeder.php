<?php

namespace Database\Seeders;

use App\Model\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        \App\Models\User::create([ 
            'name'  =>  'Admin Amikom' , 
            'email'  =>  'admin@amikom.ac.id' , 
            'password'  => bcrypt( 'password' ), 
            'role'  =>  'admin' ,
        ]);

        $category = \App\Models\Category::Create([
            'name'=>'Seminar IT',
            'slug'=>'seminar-it'
        ]);

        $category2 = \App\Models\Category::firstOrCreate([ 
            'name'  =>  'Entertaiment' , 
            'slug'  =>  'entertaiment' , 
        ]); 
        $category3 = \App\Models\Category::firstOrCreate([ 
            'name'  =>  'Creative Tect & UI/UX' , 
            'slug'  =>  'creative tect & ui/ux' , 
        ]); 
        $category4 = \App\Models\Category::firstOrCreate([ 
            'name'  =>  'Programing & Development' , 
            'slug'  =>  'programing & development' , 
        ]); 
        $category5 = \App\Models\Category::firstOrCreate([ 
            'name'  =>  'Data & Analytics' , 
            'slug'  =>  'data & analytics' , 
        ]); 

        \App\Models\Event::create([ 
            'category_id'  => $category2->id, 
            'title'  =>  'Jazz Night 2025' , 
            'description'  =>  'Nikmati  malam  yang  indah  dengan  alunan  musik  jazz 
            yang merdu.' , 
            'date'  =>  '2026-05-10 19:00:00' , 
            'location'  =>  'Amikom Baru' , 
            'price'  =>  50000 , 
            'stock'  =>  100 , 
            'poster_path'  =>  'posters/event-1.png' , 
        ]);

        \App\Models\Event::create([ 
            'category_id'  => $category->id, 
            'title'  =>  'Hackaton - Unleash Your Inner Developer' , 
            'description'  =>  'Ayo  asah  skill  coding  kamu  dan  ciptakan  solusi 
            inovatif untuk tantangan masa depan!' , 
            'date'  =>  '2026-05-05 10:00:00' ,
            'location'  =>  'Inkubator Amikom' , 
            'price'  =>  50000 , 
            'stock'  =>  100 , 
            'poster_path'  =>  'posters/event-2.png' , 
        ]); 

        \App\Models\Event::create([ 
            'category_id'  => $category->id, 
            'title'  =>  'AI & FUTURE TECH SUMMIT 2026' , 
            'description'  =>  'Jelajahi  tren  terkini  dalam  kecerdasan  buatan  dan 
            teknologi masa depan bersama para ahli di bidangnya.' , 
            'date'  =>  '2026-05-01 13:00:00' , 
            'location'  =>  'Cinema Unit 6' , 
            'price'  =>  50000 , 
            'stock'  =>  100 , 
            'poster_path'  =>  'posters/event-3.png' , 
        ]);
        \App\Models\Event::create([ 
            'category_id'  => $category3->id, 
            'title'  =>  'UI/UX Masterclass' , 
            'description'  =>  'Workshop intensif tentang desain antarmuka dan pengalaman pengguna, cocok untuk mahasiswa yang tertarik pada front-end dan desain sistem informasi.' , 
            'date'  =>  '2026-05-01 13:00:00' , 
            'location'  =>  'Cinema Unit 6' , 
            'price'  =>  50000 , 
            'stock'  =>  100 , 
            'poster_path'  =>  'posters/event-4.png' , 
        ]);
        \App\Models\Event::create([ 
            'category_id'  => $category4->id, 
            'title'  =>  'Code Sprint Challenge' , 
            'description'  =>  'Kompetisi membangun aplikasi web/mobile dalam waktu terbatas, fokus pada problem solving dan teamwork.' , 
            'date'  =>  '2026-05-01 13:00:00' , 
            'location'  =>  'Cinema Unit 6' , 
            'price'  =>  50000 , 
            'stock'  =>  100 , 
            'poster_path'  =>  'posters/event-5.png' , 
        ]);
        \App\Models\Event::create([ 
            'category_id'  => $category5->id, 
            'title'  =>  'Data Visualization Hackathon' , 
            'description'  =>  'Tantangan membuat dashboard interaktif dengan tools seperti Tableau atau Power BI.' , 
            'date'  =>  '2026-05-01 13:00:00' , 
            'location'  =>  'Cinema Unit 6' , 
            'price'  =>  50000 , 
            'stock'  =>  100 , 
            'poster_path'  =>  'posters/event-6.png' , 
        ]);

    }
}
