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

class UserController extends Controller
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
        $types = DB::Table('types')->where('status',1)->get();
        $addresses = DB::Table('addresses')
                    ->where('id_users',Auth::user()->id)
                    ->where('status',1)
                    ->get();
        return view('user.index',[
            'provinces'=>$provinces,
            'cities'=>$cities,
            'districts'=>$districts,
            'villages'=>$villages,
            'addresses'=>$addresses,
            'types'=>$types,
        ]);
    }
    public function types_store(Request $req)
    {
        $types = DB::Table('types')->where('id',$req->get('id'))->first();
        return response()->json($types);
    }
    public function profile_account_address_store(Request $req)
    {
        $addre = DB::Table('addresses')
                ->join('indonesia_provinces','addresses.id_provinces','=','indonesia_provinces.id')
                ->join('indonesia_cities','addresses.id_cities','=','indonesia_cities.id')
                ->join('indonesia_districts','addresses.id_districts','=','indonesia_districts.id')
                ->join('indonesia_villages','addresses.id_villages','=','indonesia_villages.id')
                ->select(
                    'addresses.*',
                    'indonesia_provinces.name as province_name','indonesia_provinces.meta as province_meta',
                    'indonesia_cities.name as cities_name','indonesia_cities.meta as cities_meta',
                    'indonesia_districts.name as districts_name','indonesia_districts.meta as districts_meta',
                    'indonesia_villages.name as villages_name','indonesia_villages.meta as villages_meta',
                    )
                ->where('addresses.id',$req->get('id'))
                ->first();
        return response()->json($addre);
    }
    public function profile_account_address_kocak($id)
    {
        $addre = DB::Table('addresses')
                ->join('indonesia_provinces','addresses.id_provinces','=','indonesia_provinces.id')
                ->select('indonesia_provinces.name as province_name','indonesia_provinces.meta as province_meta')
                ->where('addresses.id',$id)
                ->first();
        return response()->json($addre);
    }
}
