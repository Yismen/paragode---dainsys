<?php

namespace App\Http\Controllers;

use App\Performance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Imports\PerformancesImport;
use Maatwebsite\Excel\Facades\Excel;

class PerformanceController extends Controller
{
    /**
     * Protect the controller agaist unauthorized users
     */
    public function __construct()
    {
        $this->middleware('authorize:view-performances', ['only' => ['index', 'show']]);
        $this->middleware('authorize:edit-performances', ['only' => ['edit', 'update']]);
        $this->middleware('authorize:create-performances', ['only' => ['create', 'store']]);
        $this->middleware('authorize:destroy-performances', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('admin.performances.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dates = Performance::orderBy('date', 'DESC')
            ->groupBy(['date', 'id'])
            ->with('campaign')
            ->take(5)
            ->get();

        return view('performances.create', compact('dates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'excel_file' => 'required',
           'excel_file.*' => 'file|mimes:xls,xlsx',
        ]);

        foreach($request->file('excel_file') as $key => $file) {

            if(! Str::contains($file->getClientOriginalName(), '_performance_daily_data_')) {
                return redirect()->back()
                    ->withErrors(['excel_file' => "Wrong file selected. Please make sure you pick a file which the correct naming convention _performance_daily_data_..."]);
            }

            Excel::import(new PerformancesImport, $request->file('excel_file')[$key] );
        }

        return redirect()->route('admin.performances.create')
            ->withSuccess('Data Imported!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function show(Performance $performance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function edit(Performance $performance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Performance $performance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Performance $performance)
    {
        //
    }
}
