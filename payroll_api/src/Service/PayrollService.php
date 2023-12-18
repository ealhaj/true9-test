<?php

declare(strict_types=1);

namespace App\Service;

use Carbon\Carbon;

class PayrollService
{
    public const PAYMENT_DATE_SCHEDULE = 2;
    public const PAY_DATE_SCHEDULE = 4;

    public function calculatePaymentDate(Carbon $date): Carbon
    {
        $resultDate = $date->copy()->subDays(self::PAYMENT_DATE_SCHEDULE);

        if ($resultDate->isWeekend()) {
            $resultDate->previous(Carbon::FRIDAY);
        }

        return $resultDate;
    }

    public function calculatePayDate(Carbon $date): Carbon
    {
        return $date->copy()->addDays(self::PAY_DATE_SCHEDULE);
    }
}
