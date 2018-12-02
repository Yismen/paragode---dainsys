<?php

namespace App\Http\Controllers;

use App\LoginName;
use Illuminate\Http\Request;
use App\Employee;
use Maatwebsite\Excel\Facades\Excel;

class LoginNamesController extends Controller
{
    public function __construct()
    {
        $this->middleware('authorize:view_logins|edit_logins|create_logins', ['only' => ['index', 'show']]);
        $this->middleware('authorize:edit_logins', ['only' => ['edit', 'update']]);
        $this->middleware('authorize:create_logins', ['only' => ['create', 'store']]);
        $this->middleware('authorize:destroy_logins', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // $logins = Login::with('employee')
        //     ->orderBy('employee_id')->orderBy('login')
        //     ->paginate(100);

        $employees = Employee::select('id', 'first_name', 'second_first_name', 'last_name', 'second_last_name')
            ->orderBy('first_name')->with('logins')->has('logins')->paginate(20);

        return view('logins.index', compact('logins', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Login $login)
    {
        return view('logins.create', compact('login'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Login $login, Request $request)
    {
        $this->validate($request, [
            'login' => 'required|unique:logins',
            'employee_id' => 'required|exists:employees,id',
        ]);

        $login->create($request->all());

        return redirect()->route('admin.logins.index')
            ->withSuccess("Login $login->login has been created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Login $login)
    {
        return view('logins.show', compact('login'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Login $login)
    {
        return view('logins.edit', compact('login'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Login $login, Request $request)
    {
        $this->validate($request, [
            'login' => 'required|unique:logins,login,' . $login->id,
            'employee_id' => 'required|exists:employees,id',
        ]);

        $login->update($request->all());

        return redirect()->route('admin.logins.index')
            ->withSuccess("Login $login->login has been updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Login $login)
    {
        $login->delete();

        return redirect()->route('admin.logins.index')
            ->withDanger("Login $login->login has been removed.");
    }

    public function toExcel(Request $request)
    {
        $employees = Employee::select('id', 'first_name', 'second_first_name', 'last_name', 'second_last_name')
            ->orderBy('first_name')->with('logins')->get();

        Excel::create('Logins', function ($excel) use ($employees) {
            $excel->sheet('Logins', function ($sheet) use ($employees) {
                $sheet->loadView('logins.partials.results-to-excel', compact('employees'));
            });
        })->download();
    }
}