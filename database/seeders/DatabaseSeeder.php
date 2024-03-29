<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(RunInProductionSeeder::class);
        // $this->call(GradesTableSeeder::class);
        // $this->call(DormsTableSeeder::class);
        // $this->call(ClassTypesTableSeeder::class);
        // $this->call(UserTypesTableSeeder::class);
        // $this->call(MyClassesTableSeeder::class);
        // $this->call(NationalitiesTableSeeder::class);
        // $this->call(StatesTableSeeder::class);
        // $this->call(LgasTableSeeder::class);
        // $this->call(SettingsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        // $this->call(SubjectsTableSeeder::class);
        // $this->call(SectionsTableSeeder::class);
        // $this->call(StudentRecordsTableSeeder::class);
        $this->call(SkillsTableSeeder::class);
    }
}
