<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends BaseController
{
    public function index()
    {
        $start = $this->request->getGet('start') ?? date('Y-m-01');
        $end = $this->request->getGet('end') ?? date('Y-m-t');
        $status = $this->request->getGet('status') ?? '';

        $db = db_connect();

        $builder = $db->table('vehicle_bookings b')
            ->select('
                b.id,
                b.booking_code,
                b.requester_name,
                b.department,
                b.destination,
                b.purpose,
                b.start_at,
                b.end_at,
                b.status,
                v.plate_number,
                v.vehicle_name,
                d.name AS driver_name,
                COALESCE(SUM(f.fuel_liter), 0) AS total_fuel_liter,
                COALESCE(SUM(f.cost), 0) AS total_fuel_cost
            ')
            ->join('vehicles v', 'v.id = b.vehicle_id')
            ->join('drivers d', 'd.id = b.driver_id')
            ->join('fuel_logs f', 'f.booking_id = b.id', 'left')
            ->where('DATE(b.start_at) >=', $start)
            ->where('DATE(b.end_at) <=', $end)
            ->groupBy('b.id');

        if ($status !== '') {
            $builder->where('b.status', $status);
        }

        $bookings = $builder
            ->orderBy('b.start_at', 'ASC')
            ->get()
            ->getResultArray();

        return view('reports/index', [
            'title' => 'Laporan Pemesanan',
            'bookings' => $bookings,
            'start' => $start,
            'end' => $end,
            'status' => $status
        ]);
    }

    public function export()
    {
        $start = $this->request->getGet('start') ?? date('Y-m-01');
        $end = $this->request->getGet('end') ?? date('Y-m-t');
        $status = $this->request->getGet('status') ?? '';

        $db = db_connect();

        $builder = $db->table('vehicle_bookings b')
            ->select('
                b.id,
                b.booking_code,
                b.requester_name,
                b.department,
                b.destination,
                b.purpose,
                b.start_at,
                b.end_at,
                b.status,
                v.plate_number,
                v.vehicle_name,
                d.name AS driver_name,
                COALESCE(SUM(f.fuel_liter), 0) AS total_fuel_liter,
                COALESCE(SUM(f.cost), 0) AS total_fuel_cost
            ')
            ->join('vehicles v', 'v.id = b.vehicle_id')
            ->join('drivers d', 'd.id = b.driver_id')
            ->join('fuel_logs f', 'f.booking_id = b.id', 'left')
            ->where('DATE(b.start_at) >=', $start)
            ->where('DATE(b.end_at) <=', $end)
            ->groupBy('b.id');

        if ($status !== '') {
            $builder->where('b.status', $status);
        }

        $bookings = $builder
            ->orderBy('b.start_at', 'ASC')
            ->get()
            ->getResultArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Laporan Pemesanan');

        $headers = [
            'No',
            'Kode Booking',
            'Pemesan',
            'Departemen',
            'Tujuan',
            'Keperluan',
            'Kendaraan',
            'Plat Nomor',
            'Driver',
            'Mulai',
            'Selesai',
            'Total BBM (Liter)',
            'Biaya BBM',
            'Status'
        ];

        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        $no = 1;

        foreach ($bookings as $booking) {
            $sheet->fromArray([
                $no++,
                $booking['booking_code'],
                $booking['requester_name'],
                $booking['department'],
                $booking['destination'],
                $booking['purpose'],
                $booking['vehicle_name'],
                $booking['plate_number'],
                $booking['driver_name'],
                $booking['start_at'],
                $booking['end_at'],
                $booking['total_fuel_liter'],
                $booking['total_fuel_cost'],
                $booking['status']
            ], null, 'A' . $row);

            $row++;
        }

        foreach (range('A', 'N') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $filename = 'laporan-pemesanan-kendaraan-' . $start . '-to-' . $end . '.xlsx';

        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_clean();

        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($excelOutput);
    }
}