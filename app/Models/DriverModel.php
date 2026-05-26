<?php

namespace App\Models;

use CodeIgniter\Model;

class DriverModel extends Model
{
    protected $table = 'drivers';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'phone',
        'license_number',
        'status'
    ];

    protected $useTimestamps = true;
}