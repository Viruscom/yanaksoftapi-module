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
}
