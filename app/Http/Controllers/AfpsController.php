<?php

namespace App\Http\Controllers;

use App\Afps;
use App\Http\Requests;
use Illuminate\Http\Request;

class AfpsController extends Controller
{

    public function __construct() {
        $this->middleware('authorize:view_afps|edit_afps|create_afps', ['only'=>['index','show']]);
        $this->middleware('authorize:edit_afps', ['only'=>['edit','update']]);
        $this->middleware('authorize:create_afps', ['only'=>['create','store']]);
        $this->middleware('authorize:destroy_afps', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Afps $afps)
    {
        $afps = $afps->orderBy('name')->get();

        return view('afp.index', compact('afps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Afps $afp)
    {
        $this->validate($request, [
            'name' => 'required|min:3|unique:afps,name'
        ]);

        $afp = $afp->create($request->all());
        
        return redirect()->route('admin.afps.index')
            ->withSuccess("AFP $afp->name created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  Afps $afp
     * @return \Illuminate\Http\Response
     */
    public function show(Afps $afp)
    {
        return view('afp.show', compact('afp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  Afps $afp
     * @return \Illuminate\Http\Response
     */
    public function edit(Afps $afp)
    {
        return view('afp.edit', compact('afp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  Afps $afp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Afps $afp)
    {
        $this->validate($request, [
            'name' => 'required|min:3|unique:afps,name,'.$afp->id
        ]);

        $afp->update($request->only(['name']));
        
        return redirect()->route('admin.afps.index')
            ->withSuccess("AFP $afp->name Updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  Afps $afp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Afps $afp)
    {
        $afp->delete();

        return redirect()->route('admin.afps.index')
            ->withDanger("AFP $afp->name have been eliminated!");
    }
}
