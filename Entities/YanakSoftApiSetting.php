<?php

    namespace Modules\YanaksoftApi\Entities;

    use Illuminate\Database\Eloquent\Model;

    class YanakSoftApiSetting extends Model
    {
        protected $table    = "yanak_soft_api_settings";
        protected $fillable = ['bearer_token', 'bearer_token_last_update', 'client_email', 'username'];

        public function updateSettings($bearerTokenResult, $lastUpdateDateTime)
        {
            $this->update([
                              'bearer_token'             => $bearerTokenResult,
                              'bearer_token_last_update' => date('Y-m-d H:i:s', $lastUpdateDateTime)
                          ]);
        }
    }
