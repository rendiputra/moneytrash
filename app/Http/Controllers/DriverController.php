<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use App\Models\User;
use App\Models\Address;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\Type;

class DriverController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $provinces = Province::pluck('name', 'id', 'meta');
        $cities = City::pluck('name', 'id', 'meta');
        $districts = District::pluck('name', 'id', 'meta');
        $villages = Village::pluck('name', 'id', 'meta');
        $types = DB::Table('types')->get();
        $addresses = DB::Table('addresses')
                    ->where('id_users',Auth::user()->id)
                    ->where('status',1)
                    ->get();
        return view('driver.index',[
            'provinces'=>$provinces,
            'cities'=>$cities,
            'districts'=>$districts,
            'villages'=>$villages,
            'addresses'=>$addresses,
            'types'=>$types,
        ]);
    }
}
