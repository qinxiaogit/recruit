<?php

namespace App\Repositories;

use App\Models\JobCate;
use App\Repositories\BaseRepository;

/**
 * Class JobCateRepository
 * @package App\Repositories
 * @version June 2, 2023, 9:40 am UTC
*/

class JobCateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
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
        return JobCate::class;
    }
}
