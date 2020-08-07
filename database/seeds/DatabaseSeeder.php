<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(file_get_contents('database/seeds/000-schema-mysql.sql'));
        $this->command->info('DB created');

        DB::unprepared(file_get_contents('database/seeds/001-data-category.sql'));
        $this->command->info('Categories imported');

        DB::insert("insert into `adz_user` (`email`, `password`, `created_at`, `role`, `name`) values (?,?,now(),?,?)",
            ['orlov@adz.me', Hash::make('asdasd'), 'admin', 'Yuri Orlov']);
        DB::insert("insert into `adz_user` (`email`, `password`, `created_at`, `role`, `name`) values (?,?,now(),?,?)",
            ['member@adz.me', Hash::make('qweqwe'), 'member', 'John Doe']);
        $this->command->info('Users imported');
    }

}
