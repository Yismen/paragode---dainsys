<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Http\Resources\EmployeesResource;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = $this->query()
            ->get();

        return EmployeesResource::collection($employees);
    }

    /**
     * Limit to actives or where inactivation date is less than 30 days.
     *
     * @return \Illuminate\Http\Response
     */
    public function recents()
    {
        $employees = $this->query()
            ->recents()
            ->get();

        return EmployeesResource::collection($employees);
    }


    /**
     * Limit to actives or where inactivation date is less than 30 days.
     *
     * @return \Illuminate\Http\Response
     */
    public function actives()
    {
        $employees = $this->query()
            ->actives()
            ->get();

        return EmployeesResource::collection($employees);
    }

    private function query()
    {
        return employee::with([
            'afp',
            'ars',
            'gender',
            'marital',
            'nationality',
            'project', 
            'position.department', 
            'site', 
            'supervisor',
        ])
        ->sorted();
    }
}
