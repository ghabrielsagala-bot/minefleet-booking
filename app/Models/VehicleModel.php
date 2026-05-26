<?php

namespace App\Models;

use CodeIgniter\Model;

class VehicleModel extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'plate_number',
        'vehicle_name',
        'vehicle_type',
        'ownership',
        'brand',
        'capacity',
        'fuel_type',
        'status'
    ];

    protected $useTimestamps = true;
}