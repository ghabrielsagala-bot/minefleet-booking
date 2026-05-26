<?php

namespace App\Models;

use CodeIgniter\Model;

class FuelLogModel extends Model
{
    protected $table = 'fuel_logs';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'vehicle_id',
        'booking_id',
        'fuel_liter',
        'cost',
        'log_date'
    ];
}