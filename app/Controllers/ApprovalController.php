<?php

namespace App\Controllers;

use App\Models\ApprovalModel;
use App\Models\BookingModel;

class ApprovalController extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'approver') {
            return redirect()->to('/dashboard')->with('error', 'Hanya approver yang dapat mengakses halaman approval.');
        }

        $db = db_connect();
        $level = session()->get('approval_level');

        $approvals = $db->table('booking_approvals a')
            ->select('
                a.id AS approval_id,
                a.level,
                a.status AS approval_status,
                b.id AS booking_id,
                b.booking_code,
                b.requester_name,
                b.department,
                b.destination,
                b.purpose,
                b.start_at,
                b.end_at,
                b.status AS booking_status,
                v.plate_number,
                v.vehicle_name,
                d.name AS driver_name
            ')
            ->join('vehicle_bookings b', 'b.id = a.booking_id')
            ->join('vehicles v', 'v.id = b.vehicle_id')
            ->join('drivers d', 'd.id = b.driver_id')
            ->where('a.approver_id', session()->get('user_id'))
            ->where('a.status', 'pending')
            ->where('a.level', $level)
            ->where('b.status', 'waiting_level_' . $level)
            ->orderBy('b.created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('approvals/index', [
            'title' => 'Approval Pemesanan',
            'approvals' => $approvals
        ]);
    }

    public function approve($approvalId)
    {
        return $this->processApproval($approvalId, 'approved');
    }

    public function reject($approvalId)
    {
        return $this->processApproval($approvalId, 'rejected');
    }

    private function processApproval($approvalId, $decision)
    {
        $approvalModel = new ApprovalModel();
        $bookingModel = new BookingModel();

        $approval = $approvalModel->find($approvalId);

        if (! $approval) {
            return redirect()->back()->with('error', 'Data approval tidak ditemukan.');
        }

        if ((int) $approval['approver_id'] !== (int) session()->get('user_id')) {
            return redirect()->back()->with('error', 'Anda tidak berhak memproses approval ini.');
        }

        $db = db_connect();
        $db->transBegin();

        $approvalModel->update($approvalId, [
            'status'      => $decision,
            'note'        => $this->request->getPost('note'),
            'approved_at' => date('Y-m-d H:i:s')
        ]);

        if ($decision === 'rejected') {
            $bookingModel->update($approval['booking_id'], [
                'status' => 'rejected'
            ]);
        } else {
            $maxLevel = $approvalModel
                ->selectMax('level')
                ->where('booking_id', $approval['booking_id'])
                ->first();

            if ((int) $approval['level'] < (int) $maxLevel['level']) {
                $nextLevel = (int) $approval['level'] + 1;

                $bookingModel->update($approval['booking_id'], [
                    'status' => 'waiting_level_' . $nextLevel
                ]);
            } else {
                $bookingModel->update($approval['booking_id'], [
                    'status' => 'approved'
                ]);
            }
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Gagal memproses approval.');
        }

        $db->transCommit();

        return redirect()->to('/approvals')->with('success', 'Approval berhasil diproses.');
    }
}