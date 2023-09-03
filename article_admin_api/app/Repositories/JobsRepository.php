<?php

namespace App\Repositories;

use App\Models\Jobs;
use App\Repositories\BaseRepository;

/**
 * Class JobsRepository
 * @package App\Repositories
 * @version June 2, 2023, 8:53 am UTC
*/

class JobsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'status'
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
        return Jobs::class;
    }
}
