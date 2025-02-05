<?php

namespace App\Services;

use App\Models\BonusType;
use App\Models\Employee;
use App\Models\BonusHistory;

class BonusService
{
    public function createBonus(Employee $employee, BonusType $bonusType, $amount, $reason = null)
    {
        $bonusHistory = BonusHistory::create([
            'employee_id' => $employee->id,
            'bonus_type_id' => $bonusType->id,
            'amount' => $amount,
            'reason' => $reason,
            'status' => $bonusType->requires_approval ? 'pending' : 'approved'
        ]);

        if (!$bonusType->requires_approval) {
            $this->approveBonus($bonusHistory);
        }

        return $bonusHistory;
    }

    public function approveBonus(BonusHistory $bonus, $approver = null)
    {
        $bonus->update([
            'status' => 'approved',
            'approved_by' => $approver ?? auth()->id(),
            'approved_at' => now()
        ]);

        // If there's an active payslip, add the bonus
        $activePayslip = $bonus->employee->payslips()
            ->where('status', 'draft')
            ->latest()
            ->first();

        if ($activePayslip) {
            $activePayslip->update([
                'other_bonuses' => $activePayslip->other_bonuses + $bonus->amount,
                'bonus_description' => trim($activePayslip->bonus_description . "\n" . $bonus->reason)
            ]);
        }
    }
}