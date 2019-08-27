<?php

namespace App\Repositories;

use App\Models\CashRegister;
use App\Repositories\BaseRepository;

/**
 * Class CashRegisterRepository
 * @package App\Repositories
 * @version July 22, 2019, 4:25 am UTC
*/

class CashRegisterRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'cash',
        'transactions'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CashRegister::class;
    }
}
