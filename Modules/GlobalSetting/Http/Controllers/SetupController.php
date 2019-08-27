<?php

namespace Modules\GlobalSetting\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface;

class SetupController extends Controller
{
    protected $global_setting_repository;

    public function __construct(
        GlobalSettingRepositoryInterface $global_setting_repository
    ) {
        $this->global_setting_repository = $global_setting_repository->model;
    }

    public function smtp(Request $request)
    {
        $key = '_setup:smtp';

        $smtp = $this->global_setting_repository->where('key', $key)->first();

        if (!empty($smtp)) {
            $smtp->value = @json_decode($smtp->value);
            if ($smtp->value != null) {
                foreach ($smtp->value as $key => $value) {
                    $smtp->{$key} = $value;
                }
            }
            unset($smtp->value);
            unset($smtp->key);
        } else {
            $smtp = null;
        }
        return view('setup::smtp', compact('smtp'));
    }

    public function saveSetup(Request $request)
    {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $global_setting = $this->global_setting_repository->find($data['id']);
            $data['key'] = '_setup:smtp';
            $data['value'] = json_encode($data['value']);
            if (!empty($global_setting)) {
                $global_setting->key = $data['key'];
                $global_setting->value = $data['value'];
                $global_setting->update();
            } else {
                $global_setting = $this->global_setting_repository->create($data);
            }
            DB::commit();
            $status = 'success';
            $message = 'Settings has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->back()->with($status, $message);
    }
}
