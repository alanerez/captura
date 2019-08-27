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
class CashRegister extends Model
{
    public $table = 'cash_registers';
    


    public $fillable = [
        'name',
        'cash',
        'transactions'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'cash' => 'string',
        'transactions' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
}
