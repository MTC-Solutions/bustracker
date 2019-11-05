<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Trip;
use App\Driver;
use App\Bus;

use Auth;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $trips = Trip::all();

        return view("trips.index", ["trips"=>$trips]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasRole("ROLE_ADMIN")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }

        return view("trips.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->hasRole("ROLE_ADMIN")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }

        $this->validate($request, [
            "origin"=>"required",
            "destination"=>"required",
            "departureTime"=>"required"
        ]);

        $trip = new Trip();

        $trip->origin = $request->origin;
        $trip->destination = $request->destination;
        $trip->departureTime = $request->departureTime;

        $trip->save();

        return redirect()->route('trips')->with("success", "Trip added successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasRole("ROLE_ADMIN")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }

        $trip = Trip::where("id", $id)->first();

        if(!$trip){
            return redirect()->route('trips')->with("error", "Trip not found");
        }

        return view("trips.edit", ["trip"=>$trip]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!Auth::user()->hasRole("ROLE_ADMIN")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }

        $trip = Trip::where("id", $id)->first();

        if(!$trip){
            return redirect()->route('trips')->with("error", "Trip not found");
        }
        $this->validate($request, [
            "origin"=>"required",
            "destination"=>"required",
            "departureTime"=>"required"
        ]);

        $trip->origin = $request->origin;
        $trip->destination = $request->destination;
        $trip->departureTime = $request->departureTime;

        $trip->update();

        return redirect()->route('trips')->with("success", "Trip updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->hasRole("ROLE_ADMIN")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }
        $trip = Trip::where("id", $id)->first();

        if(!$trip){
            return redirect()->route('trips')->with("error", "Trip not found");
        }

        $trip->delete();

        return redirect()->route('trips')->with("success", "Trip deleted successfully.");
    }

    public function start($id)
    {
        if(!Auth::user()->hasRole("ROLE_DRIVER")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }
        $trip = Trip::where("id", $id)->first();

        if(!$trip){
            return redirect()->route('trips')->with("error", "Trip not found");
        }

        if(!$trip->bus){
            return redirect()->route('trips')->with("error", "A bus is required for a trip to start.");
        }

        $trip->started = true;
        $trip->update();

        return redirect()->route('trips')->with("success", "Trip deleted successfully.");
    }

    public function end($id)
    {

        if(!Auth::user()->hasRole("ROLE_DRIVER")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }
        $trip = Trip::where("id", $id)->first();

        if(!$trip){
            return redirect()->route('trips')->with("error", "Trip not found");
        }

        $trip->ended = true;
        $trip->update();

        return redirect()->route('trips')->with("success", "Trip deleted successfully.");
    }
}
