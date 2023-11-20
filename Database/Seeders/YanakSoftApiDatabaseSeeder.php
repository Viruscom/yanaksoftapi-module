<?php

    namespace Modules\Yanaksoftapi\Database\Seeders;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Seeder;

    class YanakSoftApiDatabaseSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            Model::unguard();

            $this->call(YanakSoftApiSettingsSeeder::class);
        }
    }
