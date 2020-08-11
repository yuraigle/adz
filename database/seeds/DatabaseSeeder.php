<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /* @var \Faker\Generator */
    private static $faker;

    public function __construct()
    {
        self::$faker = Faker\Factory::create();
    }

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
        $this->fakeCategories();
        $this->command->info('Fake categories created');

        DB::insert("insert into `adz_user` (`email`, `password`, `created_at`, `role`, `name`)
                    values (?,?,now(),?,?)", ['orlov@adz.me', Hash::make('asdasd'), 'admin', 'Yuri Orlov']);
        $this->fakeUsers();
        $this->command->info('Fake users created');

    }

    private function makeSlug($name)
    {
        $slug = preg_replace('/[^a-z0-9]/', '-', strtolower($name));
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = preg_replace('/-$/', '', $slug);
        if (preg_match('/[^-]{3}/', $slug)) {
            $slug = preg_replace('/-[^-]{1,2}-/', '-', $slug);
            $slug = preg_replace('/^[^-]{1,2}-/', '', $slug);
            $slug = preg_replace('/-[^-]{1,2}$/', '', $slug);
        }

        return $slug;
    }

    private function makeFakeCategory($parentId)
    {
        $name = self::$faker->unique()->sentence(3);
        $name = preg_replace('/\.$/', '', $name);
        $slug = $this->makeSlug($name);
        $description = self::$faker->text(250);
        $keywords = join(',', self::$faker->words(7));

        DB::insert("insert into `adz_category` (`name`, `slug`, `description`, `keywords`, `parent_id`)
                    values (?,?,?,?,?)", [$name, $slug, $description, $keywords, $parentId]);
        $obj = DB::selectOne("select id from `adz_category` where `slug` = ?", [$slug]);
        return $obj->id;
    }

    private function fakeCategories()
    {
        $roots = DB::select("select id from `adz_category` where `parent_id` is null");
        foreach ($roots as $root) {
            for ($i1 = 0; $i1 < self::$faker->numberBetween(3, 7); $i1++) {
                $id1 = $this->makeFakeCategory($root->id);
                for ($i2 = 0; $i2 < self::$faker->numberBetween(2, 4); $i2++) {
                    $id2 = $this->makeFakeCategory($id1);
                    for ($i3 = 0; $i3 < self::$faker->randomElement([0,2,3]); $i3++) {
                        $id3 = $this->makeFakeCategory($id2);
                    }
                }
            }
        }
    }

    private function fakeUsers()
    {
        $pass1 = Hash::make('qweqwe'); // single pass for all generated members

        for ($i = 0; $i < 1000; $i++) {
            $email = self::$faker->unique()->email;
            $name = self::$faker->name;
            $created = self::$faker->dateTimeThisYear;

            DB::insert("insert into `adz_user` (`email`, `password`, `created_at`, `role`, `name`)
                        values (?,?,?,?,?)", [$email, $pass1, $created, 'member', $name]);
        }
    }

}
