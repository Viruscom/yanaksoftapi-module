<?php

    namespace Modules\YanakSoftApi\Http\Controllers;

    use Illuminate\Routing\Controller;
    use Modules\YanakSoftApi\Services\ApiService;
    use Modules\YanakSoftApi\Services\ConnectionService;

    class YanakSoftApiController extends Controller
    {
        public static function postOrder($order)
        {
            $service = new ApiService(new ConnectionService());
            $token   = $service->getToken();
            //4.1. Добавяне на стока в количчката //e-shop/api/cart_b
            //4.5 Създаване на количката

        }
        public function getToken()
        {
            $service = new ApiService(new ConnectionService());
            $token   = $service->getToken();

            dd($token);
        }
        public function getAllCategories()
        {
            $service       = new ApiService(new ConnectionService());
            $allCategories = $service->getAllCategories();

            dd($allCategories);
        }
        public function getAllStocks()
        {
            $service   = new ApiService(new ConnectionService());
            $allStocks = $service->getAllStocks();

            dd($allStocks);
        }
        public function getAllCustomers()
        {
            $service       = new ApiService(new ConnectionService());
            $allCategories = $service->getAllCustomers();

            dd($allCategories);
        }
        public function addStockToCart()
        {
            $data = [
                'sessionID'   => '284e6c82-ccb6-4fd3-ba98-ae4ca36fb5ba',
                'stockID'     => '2',
                'quantity'    => '5',
                'customerID'  => '0',
                'information' => '',
                'additions'   => '',
                'rootStockID' => '-1',
                'is_eshop'    => 'true',
                'price'       => '5.2524'
            ];

            $service = new ApiService(new ConnectionService());
            $stock   = $service->addStockToCart($data);
            dd($stock);
        }
        public function editStockFromCart()
        {
            $data = [
                'id'       => '60', //"kasbuf_id" от cart GET
                'quantity' => '5',
            ];

            $service = new ApiService(new ConnectionService());
            $stock   = $service->editStockFromCart($data);
            //TODO: da se zakachi
        }
        public function deleteStockFromCart()
        {
            $data = [
                'id' => '60', //"kasbuf_id" от cart GET
            ];

            $service = new ApiService(new ConnectionService());
            $stock   = $service->deleteStockFromCart($data);
            //TODO: da se zakachi
        }
        public function showStocksInCart()
        {
            $data = [
                'sessionID'  => '284e6c82-ccb6-4fd3-ba98-ae4ca36fb5ba', //"kasbuf_id" от cart GET
                'customerID' => '0'
            ];

            $service = new ApiService(new ConnectionService());
            $stock   = $service->showStocksInCart($data);

            dd($stock);
            //TODO: da se zakachi
        }
        public function makeOrderToYanakSoft()
        {
            $data = [
                'sessionID'         => '284e6c82-ccb6-4fd3-ba98-ae4ca36fb5ba', //"kasbuf_id" от cart GET
                'ip'                => '127.0.0.1', // ip от където се прави заявката
                'warehouseID'       => '0',
                'email'             => 'test_client_mail@mail.com',
                'customerID'        => '0',
                'total'             => '0', //Тотал на сметката
                'paymentMethod'     => '0', //Начин на плащане който се активира когато се изпълнява поръчка в допълнителен модул в основната програма, 0 в Брой, 1 по Банка, 2 с Карта ,3 Разнос
                'order_ex_doc_type' => '0', //Тип документ който се активира когато се изпълнява поръчка в допълнителен модул в основната програма, 20 Разписка , 21 Фактура
                'orderInfo'         => '',
                'FiscalDevice'      => '',
                'FiscalDeviceID'    => '',
                'IPAdress'          => '',// Попълва се ако клиента ползва СУПТО и се изисква УНП при създаването на документа
                'port'              => '',// Попълва се ако клиента ползва СУПТО и се изисква УНП при създаването на документа
            ];

            $service = new ApiService(new ConnectionService());
            $stock   = $service->makeOrderToYanakSoft($data);
            //TODO: da se zakachi
        }
    }
