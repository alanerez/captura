<?php

namespace Modules\User\Entities;

use Modules\Core\Traits\UuidForKey;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use UuidForKey;

    public $fillable = [
        'name',
        'display_name',
        'description',
    ];
}
