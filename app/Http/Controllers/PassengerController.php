<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Passenger;
use Auth;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct() {
         $this->middleware("auth");
     }

    public function index()
    {
        if(!Auth::user()->hasRole("ROLE_ADMIN")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }
        $passengers = Passenger::all();

        return view("passengers.index", ["passengers"=>$passengers]);
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
        if(!Auth::user()->hasRole("ROLE_ADMIN")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }
        $passenger = Passenger::where("id", $id)->first();
        if(!$passenger){
            return redirect()->back()->with("error", "Passenger not found!");
        }
        return view("passengers.edit", ["passenger" => $passenger]);
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
        if(!Auth::user()->hasRole("ROLE_ADMIN") && !Auth::user()->hasRole("ROLE_PASSENGER")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }
        $passenger = Passenger::where("id", $id)->first();
        if ($passenger) {
            //REDIRECT USER
                    //VALIDATE INPUTS
            $this->validate($request, [
                "firstName" => "required|min:3",
                "lastName" => "required|min:3"
            ]);

            //PROFILE
            $passenger->firstName = $request->firstName;
            $passenger->lastName = $request->lastName;

            //PROFILE
            $passenger->update();
            
            //REDIRECT USER
            if (!Auth::user()->hasRole("ROLE_PASSENGER")) {
                return redirect()->route("passengers")->with("success", "Passenger updated successfully!");
            }
            return redirect()->route("profile")->with("success", "Profile updated successfully!");
        }
        return redirect()->back()->with("error", "Passenger not found!");
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
        
        $passenger = Passenger::where("id", $id)->first();

        if(!$passenger){
            return redirect()->route('passengers')->with("error", "Passenger not found");
        }

        $passenger->delete();

        return redirect()->route('passengers')->with("success", "Passenger deleted successfully.");
    }
}
