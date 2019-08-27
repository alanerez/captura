<?php

namespace Modules\Department\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\UuidForKey;

class Department extends Model
{
    use UuidForKey;

    public $fillable = [
        'name',
        'email',
        'incoming_host',
        'incoming_port',
        'incoming_encryption',
        'incoming_protocol',
        'incoming_validate_cert',
        'outgoing_host',
        'outgoing_port',
        'outgoing_encryption',
        'username',
        'password',
    ];
}
