<?php


namespace App\Repositories;


use App\Models\StoreAccount;

class StoreAccountRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'username',
        'password'
    ];
    /**
     * Get searchable fields array
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        return StoreAccount::class;
    }
}
