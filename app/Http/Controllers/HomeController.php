<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Passenger;
use App\User;
use App\Role;

use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function __construct() {
        $userInstance    = new User();
        $roleInstance = new Role();

        $email = "bustracker@gmail.com";
        $password = "password";
        $role = null;
        $roleName = "ROLE_ADMIN";

        if (!User::where("email", $email)->first()) {
            $role = null;

            if (!Role::where("name", $roleName)->first()) {
                $roleInstance->name = $roleName;
                $roleInstance->save();
                $role = $roleInstance;
            }else{
                $role = Role::where("name", $roleName)->first();
            }
            
            $user = new User();
    
            $user->email = $email;
            $user->password = Hash::make($password);
    
            $user->save();
    
            //Assign role
            $user->attachRole($role);

            if (Auth::check()) {
              Auth::logout();
            }
        }
    }

    public function index()
    {
        return view('welcome');
    }

    public function register(Request $request){
        $this->validate($request, [
            "firstName"=>"required|min:3",
            "lastName"=>"required|min:3",
            "email"=>"required|email",
            "password"=>"required|min:8|max:20|confirmed"
        ]);

        if (User::where("email", $request->email)->first()) {
            return redirect()->back()->withInput()->with("error", "User with $request->email already exist.");
        }

        $passenger = new Passenger();

        $passenger->firstName = $request->firstName;
        $passenger->lastName = $request->lastName;
        $passenger->email = $request->email;

        $roleInstance = new Role();

        $role = null;

        if (!Role::where("name", "ROLE_PASSENGER")->first()) {
            $roleInstance->name = "ROLE_PASSENGER";
            $roleInstance->save();
            $role = $roleInstance;
        }else{
            $role = Role::where("name", "ROLE_PASSENGER")->first();
        }
        
        $user = new User();

        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        //Assign role
        $user->attachRole($role);

        $passenger->user_id = $user->id;
        $passenger->save();

        //Login the user
        Auth::login($user);

        return redirect()->route('dashboard')->with("success", "Registered successfully, Welcome: $passenger->email");

    }
}
