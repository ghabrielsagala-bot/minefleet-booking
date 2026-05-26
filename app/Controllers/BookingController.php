<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\VehicleModel;
use App\Models\DriverModel;
use App\Models\UserModel;
use App\Models\ApprovalModel;

class BookingController extends BaseController
{
    public function index()
    {
        $db = db_connect();

        $bookings = $db->table('vehicle_bookings b')
            ->select('
                b.*,
                v.plate_number,
                v.vehicle_name,
                d.name AS driver_name
            ')
            ->join('vehicles v', 'v.id = b.vehicle_id')
            ->join('drivers d', 'd.id = b.driver_id')
            ->orderBy('b.created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('bookings/index', [
            'title' => 'Pemesanan Kendaraan',
            'bookings' => $bookings
        ]);
    }

    public function create()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Hanya admin yang dapat membuat pemesanan.');
        }

        $vehicleModel = new VehicleModel();
        $driverModel = new DriverModel();
        $userModel = new UserModel();
        $bookingModel = new BookingModel();
        $approvalModel = new ApprovalModel();

        if (strtolower($this->request->getMethod()) === 'post') {
            $vehicleId = $this->request->getPost('vehicle_id');
            $startAt = $this->request->getPost('start_at');
            $endAt = $this->request->getPost('end_at');

            if ($endAt <= $startAt) {
                return redirect()->back()->with('error', 'Tanggal selesai harus lebih besar dari tanggal mulai.');
            }

            $conflict = $bookingModel
                ->where('vehicle_id', $vehicleId)
                ->whereIn('status', ['waiting_level_1', 'waiting_level_2', 'approved'])
                ->where('start_at <=', $endAt)
                ->where('end_at >=', $startAt)
                ->first();

            if ($conflict) {
                return redirect()->back()->with('error', 'Kendaraan sudah digunakan pada waktu tersebut.');
            }

            $db = db_connect();
            $db->transBegin();

            $bookingCode = 'BK-' . date('YmdHis');

            $bookingId = $bookingModel->insert([
                'booking_code'   => $bookingCode,
                'requester_name' => $this->request->getPost('requester_name'),
                'department'     => $this->request->getPost('department'),
                'destination'    => $this->request->getPost('destination'),
                'purpose'        => $this->request->getPost('purpose'),
                'start_at'       => $startAt,
                'end_at'         => $endAt,
                'vehicle_id'     => $vehicleId,
                'driver_id'      => $this->request->getPost('driver_id'),
                'created_by'     => session()->get('user_id'),
                'status'         => 'waiting_level_1'
            ]);

            $approvalModel->insertBatch([
                [
                    'booking_id'  => $bookingId,
                    'approver_id' => $this->request->getPost('approver_level_1'),
                    'level'       => 1,
                    'status'      => 'pending'
                ],
                [
                    'booking_id'  => $bookingId,
                    'approver_id' => $this->request->getPost('approver_level_2'),
                    'level'       => 2,
                    'status'      => 'pending'
                ]
            ]);

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Gagal menyimpan pemesanan.');
            }

            $db->transCommit();

            return redirect()->to('/bookings')->with('success', 'Pemesanan kendaraan berhasil dibuat.');
        }

        return view('bookings/create', [
            'title' => 'Buat Pemesanan',
            'vehicles' => $vehicleModel->where('status', 'available')->findAll(),
            'drivers' => $driverModel->where('status', 'available')->findAll(),
            'approverLevel1' => $userModel->where('role', 'approver')->where('approval_level', 1)->findAll(),
            'approverLevel2' => $userModel->where('role', 'approver')->where('approval_level', 2)->findAll()
        ]);
    }
}