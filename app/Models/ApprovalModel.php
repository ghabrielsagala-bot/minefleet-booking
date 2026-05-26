<?php

namespace App\Models;

use CodeIgniter\Model;

class ApprovalModel extends Model
{
    protected $table = 'booking_approvals';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'booking_id',
        'approver_id',
        'level',
        'status',
        'note',
        'approved_at'
    ];

    protected $useTimestamps = true;
}