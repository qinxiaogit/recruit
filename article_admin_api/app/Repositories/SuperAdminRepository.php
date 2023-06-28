<?php

namespace App\Repositories;

use App\Models\SuperAdmin;
use App\Repositories\BaseRepository;

/**
 * Class SuperAdminRepository
 * @package App\Repositories
 * @version May 31, 2023, 10:41 am UTC
*/

class SuperAdminRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'username',
        'password'
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
        return SuperAdmin::class;
    }
}
