<?php

namespace App\Controllers;

use App\Models\FuelLogModel;
use App\Models\VehicleModel;
use App\Models\BookingModel;

class FuelLogController extends BaseController
{
    public function index()
    {
        $db = db_connect();

        $fuelLogs = $db->table('fuel_logs f')
            ->select('
                f.*,
                v.vehicle_name,
                v.plate_number,
                b.booking_code
            ')
            ->join('vehicles v', 'v.id = f.vehicle_id')
            ->join('vehicle_bookings b', 'b.id = f.booking_id', 'left')
            ->orderBy('f.log_date', 'DESC')
            ->get()
            ->getResultArray();

        return view('fuel_logs/index', [
            'title' => 'Konsumsi BBM',
            'fuelLogs' => $fuelLogs
        ]);
    }

    public function create()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Hanya admin yang dapat menambahkan konsumsi BBM.');
        }

        $fuelLogModel = new FuelLogModel();
        $vehicleModel = new VehicleModel();
        $bookingModel = new BookingModel();

        if (strtolower($this->request->getMethod()) === 'post') {
            $fuelLogModel->insert([
                'vehicle_id' => $this->request->getPost('vehicle_id'),
                'booking_id' => $this->request->getPost('booking_id') ?: null,
                'fuel_liter' => $this->request->getPost('fuel_liter'),
                'cost' => $this->request->getPost('cost'),
                'log_date' => $this->request->getPost('log_date')
            ]);

            return redirect()->to('/fuel-logs')->with('success', 'Data konsumsi BBM berhasil ditambahkan.');
        }

        return view('fuel_logs/create', [
            'title' => 'Tambah Konsumsi BBM',
            'vehicles' => $vehicleModel->findAll(),
            'bookings' => $bookingModel->whereIn('status', ['approved', 'completed'])->findAll()
        ]);
    }
}