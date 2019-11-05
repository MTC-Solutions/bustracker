<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bus;
use App\Driver;
use App\Trip;

use Auth;


class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buses = Bus::all();
        return view("buses.index", ["buses"=>$buses]);
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
        return view("buses.create");
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
            "numberPlate"=>"required",
            "numberOfSeats"=>"required",
            "model"=>"required",
            "busMaker"=>"required"
        ]);

        $bus = new Bus();

        $bus->numberPlate = $request->numberPlate;
        $bus->numberOfSeats = $request->numberOfSeats;
        $bus->model = $request->model;
        $bus->busMaker = $request->busMaker;

        $bus->save();

        return redirect()->route('buses')->with("success", "Bus added successfully!");
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

        $bus = Bus::where("id", $id)->first();

        if (!$bus) {
            return redirect()->route('buses')->with("error", "Bus not found!");
        }
        
        return view("buses.edit", ["bus"=>$bus]);
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

        $this->validate($request, [
            "numberPlate"=>"required",
            "numberOfSeats"=>"required",
            "model"=>"required",
            "busMaker"=>"required"
        ]);

        $bus = Bus::where("id", $id)->first();

        if (!$bus) {
            return redirect()->route('buses')->with("error", "Bus deleted successfully!");
        }

        $bus->numberPlate = $request->numberPlate;
        $bus->numberOfSeats = $request->numberOfSeats;
        $bus->model = $request->model;
        $bus->busMaker = $request->busMaker;

        $bus->update();

        return redirect()->route('buses')->with("success", "Bus updated successfully!");
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

        $bus = Bus::where("id", $id)->first();

        if (!$bus) {
            return redirect()->route('buses')->with("error", "Bus not found");
        }

        $bus->delete();
        return redirect()->route('buses')->with("success", "Bus deleted successfully!");
    }

    public function assignTripPage($id)
    {
        if(!Auth::user()->hasRole("ROLE_ADMIN")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }

        $bus = Bus::where("id", $id)->first();
        if (!$bus) {
            return redirect()->route('buses')->with("error", "Bus not found");
        }

        $trips = Trip::where("bus_id", null)->get();

        return view("trips.assignTripPage", ["bus"=>$bus, "trips"=>$trips]);
    }

    public function assignTrip(Request $request, $id)
    {
        if(!Auth::user()->hasRole("ROLE_ADMIN")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }

        $this->validate($request, [
            "trip"=>"required"
        ]);

        //TRIP
        $trip = Trip::where("id", $request->trip)->first();
        if (!$trip) {
            return redirect()->route('buses')->with("error", "Bus not found");
        }
        $trip->bus_id = $id;

        //BUS
        $bus = Bus::where("id", $id)->first();
        if (!$bus->driver) {
            $trip->save();
            return redirect()->route('buses')->with("info", "Bus assigned trip successfully, but the bus doesn't have a driver.");
        }

        //ADDING TRIP TO THE DRIVER
        $trip->driver_id = $bus->driver->id;
        $trip->save();

        return redirect()->route('buses')->with("success", "Bus assigned successfully.");
    }
}
