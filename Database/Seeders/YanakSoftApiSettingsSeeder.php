<?php

    namespace Modules\YanakSoftApi\Database\Seeders;

    use Illuminate\Database\Seeder;
    use Modules\YanakSoftApi\Entities\YanakSoftApiSetting;

    class YanakSoftApiSettingsSeeder extends Seeder
    {
        public function run(): void
        {
            $settings = YanakSoftApiSetting::first();
            if (is_null($settings)) {
                YanakSoftApiSetting::create([
                                                'bearer_token'             => null,
                                                'bearer_token_last_update' => null,
                                                'client_email'             => 'test1235@yanaksoft.com',
                                                'username'                 => 'admin',
                                            ]);
            }
        }
    }
