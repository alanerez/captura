<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CashRegister
 * @package App\Models
 * @version July 22, 2019, 4:24 am UTC
 *
 * @property string name
 * @property string cash
 * @property string transactions
 */
class Purls extends Model
{
    public $table = 'purls';



    public $fillable = [
        'customerid',
        'firstname',
        'lastname',
        'address',
        'city',
        'state',
        'zip',
        'altphone',
        'calldate',
        'email',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'customerid' => 'string',
        'firstname' => 'string',
        'lastname' => 'string',
        'address' => 'string',
        'city' => 'string',
        'state' => 'string',
        'zip' => 'string',
        'altphone' => 'string',
        'calldate' => 'string',
        'email' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        //
    ];
}
