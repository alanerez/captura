<?php

namespace Modules\Lead\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\UuidForKey;

class Lead extends Model {
    use UuidForKey;

    public $fillable = [
        'lead_source_id',
        'gravity_form_title',
        'gravity_form_id',
        'data',
        'type',
    ];
}
