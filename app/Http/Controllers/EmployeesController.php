<?php

namespace App\Http\Controllers;

use Excel;
use App\Login;
use App\Employee;
use Carbon\Carbon;
use App\Department;
use App\ImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\Datatables;

class EmployeesController extends Controller
{
    protected $provider;
    private $request;
    private $carbon;

    public function __construct(Request $request, Carbon $carbon)
    {
        $this->request = $request;
        $this->carbon = $carbon;

        $this->middleware('authorize:view-employees|edit-employees|create-employees', ['only' => ['index', 'show']]);
        $this->middleware('authorize:edit-employees', ['only' => ['edit', 'update']]);
        $this->middleware('authorize:create-employees', ['only' => ['create', 'store']]);
        $this->middleware('authorize:destroy-employees', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @Get("/employees")
     * @return Response
     */
    public function index()
    {
        if (!request()->ajax()) {
            return view('employees.index');
        }
        return $this->getDatatables();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Employee $employee)
    {
        $employee
            ->append([
                'genders_list',
                'maritals_list',
                'sites_list',
                'projects_list',
                'positions_list',
                'departments_list',
                'payment_types_list',
                'payment_frequencies_list'
            ]);

        return view('employees.create', compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Employee $employee, Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'hire_date' => 'required|date',
            'personal_id' => 'required_if:passport,|nullable|digits:11|unique:employees,personal_id|size:11',
            'passport' => 'required_if:personal_id,|nullable|unique:employees,passport|size:10',
            'date_of_birth' => 'required|date',
            'cellphone_number' => 'required|digits:10|unique:employees,cellphone_number',
            'secondary_phone' => 'nullable|digits:10',
            'position_id' => 'required|exists:positions,id',
            'gender_id' => 'required|exists:genders,id',
            'site_id' => 'required|exists:sites,id',
            'project_id' => 'required|exists:projects,id',
            'marital_id' => 'required|exists:maritals,id',
            'has_kids' => 'required|boolean',
        ]);

        $employee = $employee->create($request->all());


        if ($request->ajax()) {
            return $employee;
        }

        return \Redirect::route('admin.employees.edit', $employee->id)
            ->withSuccess("Succesfully added employee [$employee->first_name $employee->last_name];");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Employee $employee, Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'hire_date' => 'required|date',
            'personal_id' => 'required_if:passport,|nullable|digits:11|unique:employees,personal_id,' . $employee->id,
            'passport' => 'required_if:personal_id,|nullable|size:10|unique:employees,passport,' . $employee->id,
            'date_of_birth' => 'required|date',
            'cellphone_number' => 'required|digits:10|unique:employees,cellphone_number,' . $employee->id,
            'secondary_phone' => 'nullable|digits:10',
            'gender_id' => 'required|exists:genders,id',
            'site_id' => 'required|exists:sites,id',
            'project_id' => 'required|exists:projects,id',
            'marital_id' => 'required|exists:maritals,id',
            'has_kids' => 'required|boolean',
            'position_id' => 'required|exists:positions,id',
        ]);

        $employee->update($request->all());

        if ($request->ajax()) {
            return $employee;
        }

        return redirect()->route('admin.employees.edit', $employee->id)
            ->withSuccess("Succesfully updated employee [$request->first_name $request->last_name]");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Employee $employee)
    {
        return $employee;
    }

    protected function getDatatables()
    {
        return datatables()->eloquent(
            Employee::query()->with('position.department', 'position.payment_type', 'project')
        )
        // ->editColumn('id', function ($query) {
        //     return route('admin.employees.show', $query->id);
        //     // return '<a href="' . route('admin.employees.show', $query->id) . '" class="">' . $query->id . '</a>';
        // })
        ->editColumn('hire_date', function ($query) {
            return $query->hire_date->format('d/M/Y');
        })
        ->editColumn('status', function ($query) {
            return $query->active ? 'Active' : 'Inactive';
        })
        ->addColumn('edit', function ($query) {
            return route('admin.employees.edit', $query->id);
            // return '<a href="' . route('admin.employees.edit', $query->id) . '" class=""><i class="fa fa-edit"></i> Edit</a>';
        })
        ->toJson(true);
    }
}
