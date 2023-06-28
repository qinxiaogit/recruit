<?php


namespace App\Repositories;


use App\Models\AuditLog;

class AuditLogRepository extends BaseRepository
{


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
        return AuditLog::class;
    }
}
