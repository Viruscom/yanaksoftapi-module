<?php

    namespace Modules\YanaksoftApi\Console;

    use Illuminate\Console\Command;

    class UpdateYanakProductsCommand extends Command
    {
        protected $signature   = 'yanaksoftapi:update-products';
        protected $description = 'Update Yanak Products';

        public function handle()
        {
            app('Modules\YanakSoftApi\Http\Controllers\YanakSoftProductController')->updateProducts();
            $this->info('Yanak products updated successfully.');
        }
    }
