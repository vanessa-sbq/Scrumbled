<?php

namespace Database\Seeders;

use Eloquent;
use DB;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Eloquent::unguard();

        // Execute the schema creation SQL file
        DB::unprepared(file_get_contents('resources/sql/db_create_schema.sql'));
        $this->command->info('DB: Schema created');

        // Execute the database creation SQL file
        DB::unprepared(file_get_contents('resources/sql/db_create.sql'));
        $this->command->info('DB: Database created');

        // Execute the performance indexes SQL file
        DB::unprepared(file_get_contents('resources/sql/db_performance_indexes.sql'));
        $this->command->info('DB: Performance indexes created');

        // Execute the triggers SQL file
        DB::unprepared(file_get_contents('resources/sql/db_triggers.sql'));
        $this->command->info('DB: Triggers created');

        // Call the AuthenticatedUserSeeder
        $this->call(AuthenticatedUserSeeder::class);

        // Call the ProjectSeeder
        $this->call(ProjectSeeder::class);

        // Call the SprintSeeder
        $this->call(SprintSeeder::class);

        // Call the TaskSeeder
        $this->call(TaskSeeder::class);

        // Call the CommentSeeder
        $this->call(CommentSeeder::class);

        $this->command->info('DB: Database seeded!');
    }
}
