<?php

namespace Modules\YanakSoftApi\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\YanakSoftApi\Services\ApiService;
use Modules\YanakSoftApi\Services\ConnectionService;

class YanakSoftApiController extends Controller
{
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

        $service       = new ApiService(new ConnectionService());
        $allCategories = $service->addStockToCart($data);
    }
}
