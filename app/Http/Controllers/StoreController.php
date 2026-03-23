<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*return view('stores.index');*/
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /*return view('stores.create');*/
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $store=new Store();
        $store->name=$request->input('name');
        $store->type=$request->input('type');
        $store->description=$request->input('description');
        $store->schedules=$request->input('schedules');
        $store->city=$request->input('city');
        $store->number=$request->input('number');
        $store->street=$request->input('street');
        $store->phone=$request->input('phone');
        $store->image=$request->input('image');
        $store->save();
        return redirect()->route('stores.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store)
    {
        /*return view('stores.show', compact('store'));*/
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        /*return view('stores.edit', compact('store'));*/
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store)
    {
        $store->name=$request->input('name');
        $store->type=$request->input('type');
        $store->description=$request->input('description');
        $store->schedules=$request->input('schedules');
        $store->city=$request->input('city');
        $store->number=$request->input('number');
        $store->street=$request->input('street');
        $store->phone=$request->input('phone');
        $store->image=$request->input('image');
        $store->save();
        return redirect()->route('stores.show', compact('store'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        $store->delete();
        /*return redirect()->route('stores.index');*/
    }
}
