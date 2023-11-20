<?php

    namespace Modules\Yanaksoftapi\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;
    use Modules\YanakSoftApi\Entities\YanakSoftApiSetting;

    class YanakSettingsController extends Controller
    {
        public function index()
        {
            $settings = YanakSoftApiSetting::first();
            self::ensureSettings($settings);

            return view('yanaksoftapi::admin.index', compact('settings'));
        }
        private function ensureSettings($settings)
        {
            if (is_null($settings)) {
                YanakSoftApiSetting::create(self::getDefaultData());
            }
        }
        private static function getDefaultData()
        {
            return [
                'client_email' => 'test1235@yanaksoft.com',
                'username'     => 'admin'
            ];
        }
        public function update(Request $request)
        {
            $settings = YanakSoftApiSetting::first();
            self::ensureSettings($settings);

            $defaultData = self::getDefaultData();
            $settings->update([
                                  'client_email' => empty($request->client_email) ? $defaultData['client_email'] : $request->client_email,
                                  'username'     => empty($request->username) ? $defaultData['username'] : $request->username
                              ]);

            return back()->with('success-message', trans('admin.common.successful_edit'));
        }
    }
