<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\UuidForKey;

class UserSetting extends Model
{
    use UuidForKey;

    protected $table = 'user_settings';

    public $fillable = [
        'user_id',
        'key',
        'value',
    ];

    public function user()
    {
        return $this->hasOne('Modules\User\Entities\User', 'id', 'user_id');
    }
}
