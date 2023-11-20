<?php

    namespace Modules\YanakSoftApi\Services;

    use GuzzleHttp\Client;

    class ConnectionService
    {
        public static int $ERROR_CODE_MISSING_SETTINGS   = 10;
        public static int $ERROR_CODE_GET_ALL_STOCKS     = 20;
        public static int $ERROR_CODE_GET_ALL_CATEGORIES = 30;
        public static int $ERROR_CODE_GET_ALL_CUSTOMERS  = 40;
        protected string  $bearerToken;
        protected string  $MAIN_URL                      = "https://api.eyanak.com:5555/";
        protected string  $getTokenApiUrl                = "e-shop/api/login";
        protected string  $getStocksLiteUrl              = "e-shop/api/getstockslite";
        protected string  $getAllCategoriesUrl           = "e-shop/api/groups";
        protected string  $getAllCustomersUrl            = "e-shop/api/customer";
        protected string  $addToCartApiUrl               = "e-shop/api/cart_b";
        protected string  $editStockFromCartApiUrl       = "e-shop/api/cart";
        protected string  $deleteStockFromCartApiUrl     = "e-shop/api/cart";
        protected string  $showStocksInCartApiUrl        = "e-shop/api/cart";
        public function callGetAllStocks($token): string
        {
            $attributes = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ],
                'json'    => [
                    'includepricelist' => 'false'
                ],
                'verify'  => false
            ];

            $response = $this->client()->post($this->MAIN_URL . $this->getStocksLiteUrl, $attributes);

            return $response->getBody()->getContents();
        }
        private function client(): Client
        {
            return new Client();
        }
        public function callGetToken(): string
        {
            $attributes = [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json'    => [
                    'username' => 'admin',
                    'email'    => 'test1235@yanaksoft.com',
                ],
                'verify'  => false
            ];

            $response = $this->client()->post($this->MAIN_URL . $this->getTokenApiUrl, $attributes);

            return $response->getBody()->getContents();
        }

        public function callGetAllCategories($token): string
        {
            $attributes = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ],
                'verify'  => false
            ];

            $response = $this->client()->get($this->MAIN_URL . $this->getAllCategoriesUrl, $attributes);

            return $response->getBody()->getContents();
        }

        public function callGetAllCustomers($token): string
        {
            $attributes = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ],
                'json'    => [],
                'verify'  => false
            ];

            $response = $this->client()->get($this->MAIN_URL . $this->getAllCustomersUrl, $attributes);

            return $response->getBody()->getContents();
        }

        public function callAddStockToCart($data): string
        {
            $attributes = [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
                'verify'  => false
            ];

            $response = $this->client()->post($this->MAIN_URL . $this->addToCartApiUrl, $attributes);

            return $response->getBody()->getContents();
        }

        public function callShowStocksInCart($token, $data): string
        {
            $attributes = [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ],
                'json'    => $data,
                'verify'  => false
            ];

            $response = $this->client()->get($this->MAIN_URL . $this->showStocksInCartApiUrl, $attributes);

            return $response->getBody()->getContents();
        }

        public function callMakeOrderToYanakSoft($token, $data)
        {
            $attributes = [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ],
                'json'    => $data,
                'verify'  => false
            ];

            $response = $this->client()->post($this->MAIN_URL . $this->showStocksInCartApiUrl, $attributes);

            return $response->getBody()->getContents();
        }
        public function callEditStockFromCart($token, $data): string
        {
            $attributes = [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ],
                'json'    => $data,
                'verify'  => false
            ];

            $response = $this->client()->put($this->MAIN_URL . $this->editStockFromCartApiUrl, $attributes);

            return $response->getBody()->getContents();
        }

        public function callDeleteStockFromCart($token, $data): string
        {
            $attributes = [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ],
                'json'    => $data,
                'verify'  => false
            ];

            $response = $this->client()->delete($this->MAIN_URL . $this->deleteStockFromCartApiUrl, $attributes);

            return $response->getBody()->getContents();
        }
    }
