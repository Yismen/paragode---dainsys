<?php

namespace App\Utilities\PayrollPeriods;

use Carbon\Carbon;

class QuarterlyPayrollPeriod extends PayrollPeriodContract
{

    /**
     * Date from property setter
     *
     * @return Carbon
     */
    protected function setDateFrom()
    {
        return Carbon::parse($this->date)->startofQuarter();
    }

    /**
     * Date to property setter
     *
     * @return Carbon
     */
    protected function setDateTo()
    {
        return Carbon::parse($this->date)->endOfQuarter();
    }

    /**
     * Period property setter
     *
     * @return void
     */
    protected function setPeriod()
    {
        return  "P_" .
            $this->start->format("Ymd") .
            "_" .
            $this->end->format("Ymd");
    }
}
