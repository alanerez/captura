<?php

namespace Modules\GlobalSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\UuidForKey;

class Webhook extends Model {
    use UuidForKey;

    public $fillable = [
        'name',
        'url',
        'method',
        'format',
        'headers',
        'body',
        'form_id'
    ];
}
