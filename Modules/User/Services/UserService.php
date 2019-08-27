<?php

namespace Modules\User\Services;

use Modules\User\Interfaces\UserRepositoryInterface;
use Modules\User\Interfaces\UserSettingRepositoryInterface;

class UserService
{
    public function __construct(UserRepositoryInterface $user_repository, UserSettingRepositoryInterface $user_setting_repository)
    {
        $this->user_repository = $user_repository->model;
        $this->user_setting_repository = $user_setting_repository->model;
    }

    public function saveAllUserSettings($data, $user_id)
    {
        $fields = [
            'map_branch' => @$data['map_branch'],
            'kyc_company' => @$data['kyc_company'],
        ];
        foreach ($fields as $key => $value) {
            $this->saveUserSettings($key, $value, $user_id);
        }
    }

    public function saveUserSettings($key, $value, $user_id)
    {
        if (isset($value) && !empty($value)) {
            $data = [
                'user_id' => $user_id,
                'key' => $key,
                'value' => json_encode($value),
            ];
            if ($value != null) {
                return $user_setting = $this->user_setting_repository->firstOrCreate($data);
            } else {
                return;
            }
        }
    }
}
