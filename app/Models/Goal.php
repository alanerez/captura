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
class Goal extends Model
{
    public $table = 'cash_registers';



    public $fillable = [
        'monthly_income',
        'transactions',
        'monthly_debt',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'monthly_income' => 'string',
        'transactions' => 'string',
        'monthly_debt' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'monthly_income' => 'numeric|min:1',
        'transactions' => 'numeric|min:1',
        'monthly_debt' => 'numeric|min:1',
    ];
}
