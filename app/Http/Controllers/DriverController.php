<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Driver;
use App\Profile;
use App\User;
use App\Role;
use App\Bus;
use App\Trip;

use App\Exports\DriversExport;
use Excel;

use Auth;
use PDF;

class DriverController extends Controller
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

    public function export(Request $request)
    {
        $driverCollection = collect();

        $drivers = Driver::all();

        $all = "ALL";
        //in between inclusive and exclusive 
        $inBetweenExclusive = "IN_BETWEEN_EXCLUSIVE";
        $inBetweenInclusive = "IN_BETWEEN_INCLUSIVE";

        //greater or less inclusive
        $greaterThanInclusive = "GREATER_THAN_INCLUSIVE";
        $lessThanInclusive = "LESS_THAN_INCLUSIVE";

        //greater or less exclusive
        $greaterThanExclusive = "GREATER_THAN_EXCLUSIVE";
        $lessThanExclusive = "LESS_THAN_INCLUSIVE";

        $title = "";

        if ($request->filterBy = "AGE") {
                if ($request->condition == $all) {
                    $title = "Bustracker drivers";
                    //all student marks need to be printed
                    $driverCollection = $drivers;       
                }
                //in between exclusive, sorted
                elseif($request->condition == $inBetweenExclusive){
                    $title = "Drivers age between $request->min and $request->max exclusively, Bustracker.";
                    foreach ($drivers as $driver) {
                            if($driver->age > $request->min && $driver->age < $request->max){
                                $driverCollection->push($driver);
                            }
                    }
                }
                //in between inclusive, sorted
                elseif($request->condition == $inBetweenInclusive){
                    $title = "Driver age between $request->min and $request->max inclusively, Bustracker";
                    foreach ($drivers as $driver) {
                            if($driver->age >= $request->min && $driver->age<= $request->max){
                                $driverCollection->push($driver);
                            }
                    }
                }
        
                //less than exclusive, sorted
                elseif($request->condition == $lessThanExclusive){
                    $title = "Drivers age less than $request->value exclusively, Bustracker";
                    foreach ($drivers as $driver) {
                            if($driver->age < $request->value){
                                $driverCollection->push($driver);
                            }
                    }
                }
                //less than inclusive, sorted
                elseif($request->condition == $lessThanInclusive){
                    $title = "Drivers age less than $request->value inclusively, Bustracker";
                    foreach ($drivers as $driver) {
                        if($driver->age){
                            if($driver->age <= $request->value){
                                $driverCollection->push($driver);
                            }
                        }
                    }
                }
        
                //greater than exclusive, sorted
                elseif($request->condition == $greaterThanInclusive){
                    $title = "Drivers age greater than  $request->value exclusively, Bustracker";
                    foreach ($drivers as $driver) {
                            if($driver->age > $request->value){
                                $drivers->push($driver);
                            }
                    }
                }
                //greater than exclusive
                elseif($request->condition == $greaterThanExclusive){
                    $title = "Drivers age greater than $request->value exclusively, Bustracker";
                    foreach ($drivers as $driver) {
                            if($driver->age >= $request->value){
                                $driverCollection->push($driver);
                            }
                    }
                }
        }else{

        }


        
                //PDF or Excel
                if ($request->type == "PDF") {
                    $data = ['drivers' => $driverCollection, "title"=>$title];
                    $pdf = PDF::loadView('drivers.report', $data);  
                    return $pdf->download('bustracker_report.pdf');
        
                }else{
                    return Excel::download(new DriversExport($title, $driverCollection), 'bustracker_report.xlsx');
                }
    }

    public function index()
    {
        if(!Auth::user()->hasRole("ROLE_ADMIN")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }
        $drivers = Driver::all();
        return view("drivers.index", ["drivers" => $drivers]);
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
        return view("drivers.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $now = time();

        if(!Auth::user()->hasRole("ROLE_ADMIN")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }

        //VALIDATE INPUTS
        $this->validate($request, [
            "firstName" => "required|min:3",
            "lastName" => "required|min:3",
            "age" => "required|min:2",
            "hireDate"=>"required",
            "email" => "required|email"
        ]);

        $hiredDate = strtotime($request->hireDate);

        if($hiredDate>$now){
            return redirect()->back()->withInput()->with("error", "Hired date cannot be greater than current date.");
        }
        
        //CREATE OBJECTS
        $profile = new Profile;
        $driver = new Driver;
        $user = new User;

        if (User::where("email", $request->email)->first()) {
            return redirect()->back()->withInput()->with("error", "User with $request->email already exist.");
        }

        //USER
        $user->email = $request->email;
        $user->password = Hash::make($request->email);
        $user->save();
        
        //PROFILE
        $driver->firstName = $request->firstName;
        $driver->lastName = $request->lastName;
        $driver->age = $request->age;
        $driver->hireDate = $request->hireDate;
        $driver->email = $request->email;
        $driver->user_id = $user->id;
        $driver->save();


        $roleInstance = new Role;

        $role = null;

        if (!Role::where("name", "ROLE_DRIVER")->first()) {
            $roleInstance->name = "ROLE_DRIVER";
            $roleInstance->save();
            $role = $roleInstance;
        }else{
            $role = Role::where("name", "ROLE_DRIVER")->first();
        }

        //ASSIGN ROLE
        $user->attachRole($role);

        //REDIRECT USER
        return redirect()->route("drivers")->with("success", "Driver added successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::user()->hasRole("ROLE_ADMIN")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }
        $driver = Driver::where("id", $id)->first();
        if(!$driver){
            return redirect()->back()->with("error", "Driver not found!");
        }
        return view("drivers.show", ["driver" => $driver]);
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
        $driver = Driver::where("id", $id)->first();
        if(!$driver){
            return redirect()->back()->with("error", "Driver not found!");
        }
        return view("drivers.edit", ["driver" => $driver]);
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
        $user = Auth::user();

        $now = time();

        if(!Auth::user()->hasRole("ROLE_ADMIN") && !Auth::user()->hasRole("ROLE_DRIVER")){
            return redirect()->route('dashboard')->with("error", "Access denied.");
        }
        $driver = Driver::where("id", $id)->first();
        if ($driver) {
            //REDIRECT USER
            //VALIDATE INPUTS
            if(!Auth::user()->hasRole("ROLE_DRIVER")){
                $this->validate($request, [
                    "firstName" => "required|min:3",
                    "age" => "required",
                    "lastName" => "required|min:3",
                    "hireDate" => "required"
                ]);
            }else{
                $this->validate($request, [
                    "firstName" => "required|min:3",
                    "age" => "required",
                    "lastName" => "required|min:3"
                ]);
            }

            $hiredDate = strtotime($request->hireDate);

            if($hiredDate>$now){
                return redirect()->back()->withInput()->with("Hired date cannot be greater than current date.");
            }

            //PROFILE
            $driver->firstName = $request->firstName;
            $driver->age = $request->age;
            $driver->lastName = $request->lastName;

            if(!Auth::user()->hasRole("ROLE_DRIVER")){
                $driver->hireDate = $request->hireDate;
            }

            //PROFILE
            $driver->update();
            //REDIRECT USER
            if(!Auth::user()->hasRole("ROLE_DRIVER")){
                return redirect()->route("drivers")->with("success", "Driver updated successfully!");
            }
            return redirect()->route("profile")->with("success", "Profile updated successfully!");
        }
        return redirect()->back()->with("error", "Driver not found!");
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
        $driver = Driver::where("id", $id)->first();
        if ($driver) {
            //REDIRECT USER
            $driver->delete();
            //REDIRECT USER
            return redirect()->route("drivers")->with("success", "Driver deleted successfully!");
        }
        return redirect()->back()->with("error", "Driver not found!");
    }

    public function assignBusPage($id)
    {
        $driver = Driver::where("id", $id)->first();
        $buses = Bus::where("driver_id", null)->get();
        return view("buses.assignBusPage", ["driver"=>$driver, "buses"=>$buses]);
    }

    public function assignBus(Request $request, $id)
    {
        $this->validate($request, [
            "bus"=>"required"
        ]);

        $bus = Bus::where("id", $request->bus)->first();

        //If bus not found alert the user
        if(!$bus){
            return redirect()->back()->with("error", "Bus not found!");
        }
        
        $driver = Driver::where("id", $id)->first();

        if(!$driver){
            return redirect()->back()->with("error", "Driver not found!");
        }

        $bus->driver_id = $id;
        $bus->update();

        return redirect()->route("drivers")->with("success", "Driver allocated bus successfully!");
    }

    public function unassignBus($id)
    {
        $bus= Bus::where("id", $id)->first();

        if(!$bus){
            return redirect()->back()->with("error", "Trip not found!");
        }

        $bus->driver_id = null;
        $bus->update();

        return redirect()->route('drivers')->with("success", "Trip unassigned successfully.");
    }
}
