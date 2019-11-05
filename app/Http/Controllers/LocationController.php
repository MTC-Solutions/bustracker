<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Driver;
use App\Trip;
use App\Bus;
use Auth;
use GeoIP;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
    }

    public function postLocation(Request $re)
    {

        $userEmail = "tumi@gmail.com";

        $driver = Driver::where("email", $userEmail)->first();

        $location = Location::where("bus_id", $driver->bus->id)->first();

        $lat = $re->lat;
        $lon = $re->lon;

        if($driver->bus){
            if ($driver->bus->trip) {
                if ($driver->bus->trip->started && !$driver->bus->trip->ended) {
                    if($location){
                        $location->lat = $lat;
                        $location->lon = $lon;
                        $location->update();
                        $locations = Location::all();
                        $locations = Location::all();
            
                        $trips = Trip::all();
                
                        $drivers = Driver::all();
                        
                        $buses = Bus::all();
            
                        $data = ["locations"=>$locations, "trips"=>$trips, "drivers"=>$drivers, "buses" => $buses];

                        return response()->json($data);
                    }
            
                    $locationInstance = new Location();
            
                    $locationInstance->lat = $lat;
                    $locationInstance->lon = $lon;
                    $locationInstance->bus_id = $driver->bus->id;
            
                    $locationInstance->save();
            
                    $locations = Location::all();
            
                    $trips = Trip::all();
            
                    $drivers = Driver::all();

                    $buses = Bus::all();
            
                    $data = ["locations"=>$locations, "trips"=>$trips, "drivers"=>$drivers, "buses" => $buses];
            
                    return response()->json($data);
                }
            }
        }

        $locations = Location::all();
            
        $trips = Trip::all();

        $drivers = Driver::all();

        $data = ["locations"=>$locations, "trips"=>$trips, "drivers"=>$drivers];

        return response()->json($data);
    }


    public function getLocation(){

        $locations = Location::all();
            
        $trips = Trip::all();

        $drivers = Driver::all();

        $buses = Bus::all();
            
        $data = ["locations"=>$locations, "trips"=>$trips, "drivers"=>$drivers, "buses" => $buses];

        return response()->json($data);
    }

    public function index(Request $re)
    {
        if(Auth::user()->hasRole("ROLE_DRIVER")){
            $driver = Driver::where("email", Auth::user()->email)->first();
            return view("location.location", ["driver"=>$driver]);
        }
        
        return view("location.location");
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
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
