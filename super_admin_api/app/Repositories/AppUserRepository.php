<?php

namespace App\Repositories;

use App\Models\AppUser;
use App\Repositories\BaseRepository;

/**
 * Class AppUserRepository
 * @package App\Repositories
 * @version June 2, 2023, 9:39 am UTC
*/

class AppUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nickname','created_at',"active_time",
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
        return AppUser::class;
    }
}
