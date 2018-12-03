<?php

namespace App\Http\Controllers;

use App\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SupervisorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supervisors = Cache::rememberForever('supervisors', function() {
            return Supervisor::with(['department' => function ($query) {
                return $query->orderBy('department');
            }])
            ->orderBy('department_id')
            ->orderBy('name')
            ->paginate(25);
        });

        return view('supervisors.index', compact('supervisors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Supervisor $supervisor)
    {
        return view('supervisors.create', compact('supervisor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Supervisor $supervisor)
    {
         $this->validate($request, [
            'name' => 'required|min:5|unique:supervisors,name',
            'department_id' => 'required|exists:departments,id'
        ]);

         Cache::forget('supervisors');
         Cache::forget('employees');

        $supervisor = $supervisor->create($request->only(['name', 'department_id']));

        if ($request->ajax()) {
            return $supervisor;
        }

        return redirect()->route('admin.supervisors.index')
            ->withSuccess("Supervisor $supervisor->name create!!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  Supervisor $supervisor
     * @return \Illuminate\Http\Response
     */
    public function show(Supervisor $supervisor)
    {
        return view('supervisors.show', compact('supervisor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  Supervisor $supervisor
     * @return \Illuminate\Http\Response
     */
    public function edit(Supervisor $supervisor)
    {
        return view('supervisors.edit', compact('supervisor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  Supervisor $supervisor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supervisor $supervisor)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|min:5|unique:supervisors,name,'.$supervisor->id,
                'department_id' => 'required|exists:departments,id'
            ]
        );

         Cache::forget('supervisors');
         Cache::forget('employees');

        $supervisor->update($request->only(['name', 'department_id']));

        return redirect()->route('admin.supervisors.index')
            ->withSuccess("Supervisor $supervisor->name Updated!!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  Supervisor $supervisor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supervisor $supervisor)
    {

         Cache::forget('supervisors');
         Cache::forget('employees');
    }
}
