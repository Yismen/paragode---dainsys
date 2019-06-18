<?php

namespace App\Repositories\HumanResources\Attrition;

use App\Employee;
use Carbon\Carbon;
use App\Termination;
use Illuminate\Support\Facades\DB;
use App\Repositories\HumanResources\HumanResourcesInterface;

/**
 * Monthly Attrition Class
 */
class MonthlyAttrition implements HumanResourcesInterface
{
    public function setup()
    {
        return $this;
    }

    public function count(int $months = 6)
    {
        $array_data = [];
        for ($interval = $months ; $interval !== 0; $interval--) {
            $date = (new Carbon())->subMonths($interval - 1);

            $prop = $date->format('Y-m');

            $array_data[$prop]['head_count'] = $this->getHeadCount($date)->count();
            $array_data[$prop]['terminations'] = $this->getTerminations($date)->count();
            $array_data[$prop]['hires'] = $this->getHires($date)->count();
        }

        return [$array_data];
    }

    public function list(int $months = 6)
    {
        $array_data = [];
        for ($interval = $months ; $interval !== 0; $interval--) {
            $date = (new Carbon())->subMonths($interval - 1);

            $prop = $date->format('Y-m');

            dd($prop);

            $array_data[$prop]['head_count'] = $this->getHeadCount($date)->get();
            $array_data[$prop]['terminations'] = $this->getTerminations($date)->get();
            $array_data[$prop]['hires'] = $this->getHires($date)->get();
        }

        return $array_data;
    }

    protected function getHeadCount($date)
    {
        // CACHE THIS SHIT FOR 10 MINUTES AT LEAST
        return Employee::where('hire_date', '<=', $date->endOfMonth())
            ->where(function ($query) use ($date) {
                $query->actives()
                ->orWhereHas('termination', function ($query) use ($date) {
                    $query->where('termination_date', '>=', $date->startOfMonth());
                });
            });
    }

    protected function getTerminations($from_date)
    {
        // CACHE THIS SHIT FOR 10 MINUTES AT LEAST
        return Termination::whereMonth('termination_date', $from_date->month);
    }

    protected function getHires($from_date)
    {
        // CACHE THIS SHIT FOR 10 MINUTES AT LEAST
        return Employee::whereMonth('hire_date', $from_date->month);
    }
}