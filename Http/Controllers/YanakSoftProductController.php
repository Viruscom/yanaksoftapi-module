<?php

    namespace Modules\Yanaksoftapi\Http\Controllers;

    use Illuminate\Routing\Controller;
    use Modules\YanakSoftApi\Entities\YanakProduct;
    use Modules\YanakSoftApi\Services\ApiService;
    use Modules\YanakSoftApi\Services\ConnectionService;

    class YanakSoftProductController extends Controller
    {
        public function updateProducts()
        {
            $service = new ApiService(new ConnectionService());
            $service->getToken();
            $allStocks = $service->getAllStocks();

            $allStocksIds = array_column($allStocks, 'stk_idnumb');

            foreach ($allStocks as $stock) {
                $transformedStock = $this->transformStockData($stock);

                YanakProduct::updateOrCreate(
                    ['stk_idnumb' => $stock['stk_idnumb']],
                    $transformedStock
                );
            }

            YanakProduct::whereNotIn('stk_idnumb', $allStocksIds)->delete();

            YanakProduct::updateCache();
        }

        private function transformStockData($stock)
        {
            $jsonFields = ['screen_gr_ids', 'package_stocks', 'additions', 'comments'];
            foreach ($jsonFields as $field) {
                if (isset($stock[$field]) && is_array($stock[$field])) {
                    $stock[$field] = json_encode($stock[$field]);
                }
            }

            return $stock;
        }
    }
