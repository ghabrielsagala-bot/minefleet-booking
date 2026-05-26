<?php

namespace App\Controllers;

class UsageHistoryController extends BaseController
{
    public function index()
    {
        $db = db_connect();

        $histories = $db->table('vehicle_bookings b')
            ->select('
                b.*,
                v.vehicle_name,
                v.plate_number,
                d.name AS driver_name,
                u.name AS created_by_name
            ')
            ->join('vehicles v', 'v.id = b.vehicle_id')
            ->join('drivers d', 'd.id = b.driver_id')
            ->join('users u', 'u.id = b.created_by')
            ->whereIn('b.status', ['approved', 'completed'])
            ->orderBy('b.start_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('usage_history/index', [
            'title' => 'Riwayat Pemakaian',
            'histories' => $histories
        ]);
    }
}