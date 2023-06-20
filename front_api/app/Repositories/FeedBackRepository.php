<?php

namespace App\Repositories;

use App\Models\FeedBack;
use App\Repositories\BaseRepository;

/**
 * Class FeedBackRepository
 * @package App\Repositories
 * @version June 2, 2023, 9:40 am UTC
*/

class FeedBackRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'status','feed_type'
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
        return FeedBack::class;
    }
}
