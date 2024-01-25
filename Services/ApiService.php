<?php

    namespace Modules\YanakSoftApi\Services;

    use Carbon\Carbon;
    use Modules\YanakSoftApi\Entities\YanakSoftApiSetting;

    class ApiService
    {
        protected $connection;

        public function __construct(ConnectionService $connection)
        {
            $this->connection = $connection;
        }

        public function getToken()
        {
            $yanakSoftApiSettings = YanakSoftApiSetting::first();
            if (is_null($yanakSoftApiSettings)) {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_MISSING_SETTINGS]);
            }
            $now             = Carbon::now()->timestamp;
            $lastTokenUpdate = Carbon::parse($yanakSoftApiSettings->bearer_token_last_update)->addHour(11)->timestamp;

            if ($now > $lastTokenUpdate || is_null($yanakSoftApiSettings->bearer_token)) {
                $apiCall = $this->connection->callGetToken($yanakSoftApiSettings);
                $result  = json_decode($apiCall, true);
                if ($result['success'] === true) {
                    $yanakSoftApiSettings->updateSettings($result['token'], $now);

                    return $result['token'];
                } else {
                    $yanakSoftApiSettings->updateSettings(null, $now);

                    return null;
                }
            }

            return $yanakSoftApiSettings->bearer_token;
        }

        public function getAllStocks()
        {
            $yanakSoftApiSettings = YanakSoftApiSetting::first();
            if (is_null($yanakSoftApiSettings)) {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_MISSING_SETTINGS]);
            }

            $apiCall = $this->connection->callGetAllStocks($yanakSoftApiSettings->bearer_token);
            $result  = json_decode($apiCall, true);

            if ($result['error'] != '') {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_GET_ALL_STOCKS]);
            }

            return $result['items'];
        }

        public function getAllCategories()
        {
            $yanakSoftApiSettings = YanakSoftApiSetting::first();
            if (is_null($yanakSoftApiSettings)) {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_MISSING_SETTINGS]);
            }

            $apiCall = $this->connection->callGetAllCategories($yanakSoftApiSettings->bearer_token);
            $result  = json_decode($apiCall, true);

            if ($result['error']['message'] != '') {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_GET_ALL_CATEGORIES]);
            }

            return $result['items'];
        }


        public function getAllCustomers()
        {
            $yanakSoftApiSettings = YanakSoftApiSetting::first();
            if (is_null($yanakSoftApiSettings)) {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_MISSING_SETTINGS]);
            }

            $apiCall = $this->connection->callGetAllCustomers($yanakSoftApiSettings->bearer_token);
            $result  = json_decode($apiCall, true);

            if ($result['error'] != '') {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_GET_ALL_CUSTOMERS]);
            }

            return $result['list_selbuy'];
        }

        public function addStockToCart($data)
        {
            $yanakSoftApiSettings = YanakSoftApiSetting::first();
            if (is_null($yanakSoftApiSettings)) {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_MISSING_SETTINGS]);
            }

            $apiCall  = $this->connection->callAddStockToCart($yanakSoftApiSettings->bearer_token, $data);
            $response = json_decode($apiCall, true);
            if (is_null($response) || !isset($response['success'])) {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_INVALID_RESPONSE]);
            }

            if (!$response['success']) {
                if (isset($response['error']['code'])) {
                    return json_encode(['error' => $response['error']['code']]);
                } else {
                    return json_encode(['error' => ConnectionService::$ERROR_CODE_INVALID_RESPONSE]);
                }
            }

            if (!isset($response['item'])) {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_INVALID_RESPONSE]);
            }

            return json_encode(['success' => $response]);
        }
        public function addCustomStockToCart($data)
        {
            $yanakSoftApiSettings = YanakSoftApiSetting::first();
            if (is_null($yanakSoftApiSettings)) {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_MISSING_SETTINGS]);
            }

            $apiCall  = $this->connection->callAddCustomStockToCart($yanakSoftApiSettings->bearer_token, $data);
            $response = json_decode($apiCall, true);
            if (is_null($response) || !isset($response['success'])) {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_INVALID_RESPONSE]);
            }

            if (!$response['success']) {
                if (isset($response['error']['code'])) {
                    return json_encode(['error' => $response['error']['code']]);
                } else {
                    return json_encode(['error' => ConnectionService::$ERROR_CODE_INVALID_RESPONSE]);
                }
            }

//            if (!isset($response['item'])) {
//                return json_encode(['error' => ConnectionService::$ERROR_CODE_INVALID_RESPONSE]);
//            }

            return json_encode(['success' => $response]);
        }

        public function showStocksInCart(array $data)
        {
            $yanakSoftApiSettings = YanakSoftApiSetting::first();
            if (is_null($yanakSoftApiSettings)) {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_MISSING_SETTINGS]);
            }

            $apiCall  = $this->connection->callShowStocksInCart($yanakSoftApiSettings->bearer_token, $data);
            $response = json_decode($apiCall);
            if (!isset($response->success)) {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_INVALID_RESPONSE]);
            }

            if (!$response->success) {
                if (isset($response->error) && !empty($response->error)) {
                    return json_encode(['error' => $response->error]);
                } else {
                    return json_encode(['error' => ConnectionService::$ERROR_CODE_INVALID_RESPONSE]);
                }
            }

            if (!isset($response->items)) {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_INVALID_RESPONSE]);
            }

            $cart = [
                'items' => $response->items
            ];

            if (isset($response->total)) {
                $cart['total'] = $response->total;
            }

            if (isset($response->quantity)) {
                $cart['quantity'] = $response->quantity;
            }

            if (isset($response->basicTotal)) {
                $cart['basic_total'] = $response->basicTotal;
            }

            return json_encode(['cart' => $cart]);
        }

        public function createOrder($sessionID, $userIp, $warehouseID, $userEmail, $total, $paymentMethod): bool
        {
            $yanakSoftApiSettings = YanakSoftApiSetting::first();
            if (is_null($yanakSoftApiSettings)) {
                return json_encode(['error' => ConnectionService::$ERROR_CODE_MISSING_SETTINGS]);
            }

            try {
                $data     = [
                    "sessionID"         => $sessionID,
                    "ip"                => $userIp,
                    "warehouseID"       => $warehouseID,
                    "email"             => $userEmail,
                    "customerID"        => "0",
                    "total"             => $total,
                    "paymentMethod"     => $paymentMethod,
                    "is_eshop"          => "true",
                    "order_ex_doc_type" => 0,
                    "orderInfo"         => "",
                    "FiscalDevice"      => "1",
                    "FiscalDeviceID"    => "1",
                    "IPAdress"          => "",
                    "port"              => ""
                ];
                $apiCall  = $this->connection->callMakeOrderToYanakSoft($yanakSoftApiSettings->bearer_token, json_encode($data));
                $response = json_decode($apiCall);
                if (!is_object($response) || !isset($response->success) || !$response->success) {
                    return false;
                }

                return true;
            } catch (\Exception $e) {
                return false;
            }
        }

        public function sendItemToCart($sessionId, $stockId, $quantity, $additions, $price): ?array
        {
            $data = [
                'sessionID'   => $sessionId,
                'stockID'     => $stockId,
                'quantity'    => $quantity,
                'customerID'  => '0',
                'information' => '',
                'additions'   => count($additions) > 0 ? $additions : [],
                'rootStockID' => '-1',
                'is_eshop'    => 'true',
                'price'       => $price
            ];

            if (empty($data['stockID'])) {
                return null;
            }
            $response = json_decode($this->addStockToCart($data));
            if (is_null($response) || isset($response->error)) {
                return null;
            }

            return ['stock_id' => $data['stockID'], 'quantity' => $data['quantity'], 'price' => $data['price']];
        }

        public function sendCustomItemToCart($sessionId, $value, $information, $quantity): ?array
        {
            $data = [
                'sessionId'   => $sessionId,
                'value'       => $value,
                'information' => $information,
                'customerID'  => '0',
                'quantity'    => $quantity
            ];

            $response = json_decode($this->addCustomStockToCart($data));
            if (is_null($response) || isset($response->error)) {
                return null;
            }

            return [];
        }
    }
