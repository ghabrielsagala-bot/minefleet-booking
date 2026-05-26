<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceRecordModel extends Model
{
    protected $table = 'service_records';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'vehicle_id',
        'service_date',
        'next_service_date',
        'description',
        'cost'
    ];
}