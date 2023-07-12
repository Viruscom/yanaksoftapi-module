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
            $apiCall = $this->connection->callGetToken();
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
}
