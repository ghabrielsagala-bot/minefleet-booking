<?php

namespace App\Controllers;

use App\Models\ServiceRecordModel;
use App\Models\VehicleModel;

class ServiceController extends BaseController
{
    public function index()
    {
        $db = db_connect();

        $services = $db->table('service_records s')
            ->select('
                s.*,
                v.vehicle_name,
                v.plate_number
            ')
            ->join('vehicles v', 'v.id = s.vehicle_id')
            ->orderBy('s.service_date', 'DESC')
            ->get()
            ->getResultArray();

        return view('services/index', [
            'title' => 'Jadwal Service',
            'services' => $services
        ]);
    }

    public function create()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Hanya admin yang dapat menambahkan service.');
        }

        $serviceModel = new ServiceRecordModel();
        $vehicleModel = new VehicleModel();

        if (strtolower($this->request->getMethod()) === 'post') {
            $serviceModel->insert([
                'vehicle_id' => $this->request->getPost('vehicle_id'),
                'service_date' => $this->request->getPost('service_date'),
                'next_service_date' => $this->request->getPost('next_service_date'),
                'description' => $this->request->getPost('description'),
                'cost' => $this->request->getPost('cost')
            ]);

            return redirect()->to('/services')->with('success', 'Data service kendaraan berhasil ditambahkan.');
        }

        return view('services/create', [
            'title' => 'Tambah Service',
            'vehicles' => $vehicleModel->findAll()
        ]);
    }
}