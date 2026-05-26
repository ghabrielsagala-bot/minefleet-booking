<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = db_connect();

        $summary = [
            'totalVehicles' => $db->table('vehicles')->countAllResults(),
            'totalDrivers' => $db->table('drivers')->countAllResults(),
            'approvedBookings' => $db->table('vehicle_bookings')->where('status', 'approved')->countAllResults(),
            'rejectedBookings' => $db->table('vehicle_bookings')->where('status', 'rejected')->countAllResults(),
            'totalFuel' => $db->table('fuel_logs')->selectSum('fuel_liter')->get()->getRow()->fuel_liter ?? 0,
            'totalService' => $db->table('service_records')->countAllResults(),
        ];
                
                

        $monthlyUsage = $db->query("
            SELECT DATE_FORMAT(start_at, '%Y-%m') AS month, COUNT(*) AS total
            FROM vehicle_bookings
            WHERE status IN ('approved', 'completed')
            GROUP BY DATE_FORMAT(start_at, '%Y-%m')
            ORDER BY month ASC
        ")->getResultArray();

        $topVehicles = $db->query("
            SELECT v.vehicle_name, v.plate_number, COUNT(b.id) AS total
            FROM vehicle_bookings b
            JOIN vehicles v ON v.id = b.vehicle_id
            WHERE b.status IN ('approved', 'completed')
            GROUP BY v.id
            ORDER BY total DESC
            LIMIT 5
        ")->getResultArray();

        return view('dashboard/index', [
            'title' => 'Dashboard',
            'summary' => $summary,
            'monthlyUsage' => $monthlyUsage,
            'topVehicles' => $topVehicles
        ]);
    }
}