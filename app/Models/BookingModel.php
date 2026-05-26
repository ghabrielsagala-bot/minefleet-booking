<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table = 'vehicle_bookings';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'booking_code',
        'requester_name',
        'department',
        'destination',
        'purpose',
        'start_at',
        'end_at',
        'vehicle_id',
        'driver_id',
        'created_by',
        'status'
    ];

    protected $useTimestamps = true;
}