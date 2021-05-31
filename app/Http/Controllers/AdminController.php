<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use App\Models\User;
use App\Models\Address;
use Auth;
use Hash;
use DB;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->role==1)
        {
            return redirect()->route('admin.index');
        }
        else if(Auth::user()->role==2)
        {
            return redirect()->route('driver.index');
        }
        return view('home');
    }

    public function create_account()
    {
        
        $provinces = Province::pluck('name', 'id');

        return view('admin.create_account', [
            'provinces' => $provinces,
        ]);
    }
    public function create_account_store(Request $req)
    {
        // dd($req);
        $create_user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'role' => $req->role,
        ]);
        if($create_user)
        {
            $create_wallet = Wallet::create([
                'id_users' => $create_user->id,
            ]);
            if($req->addressed == TRUE)
            {
                $create_address = Address::create([
                    'id_users' => $create_user->id,
                    'phone' => $req->phone,
                    'id_provinces' => $req->province,
                    'id_cities' => $req->city,
                    'id_districts' => $req->district,
                    'id_villages' => $req->village,
                    'name' => $req->name_address,
                    'address' => $req->address,
                    'postal_code' => $req->postalcode,
                ]);
                if($create_address)
                {
                    return back()->with('success', 'Berhasil menambahkan akun dan alamat');
                }
            }
            return back()->with('success', 'Berhasil menambahkan akun');
        }
    }
    public function list_account()
    {
        $account = User::all();
        $addresses = DB::Table('addresses')->where('status',1)->get();
        $provinces = Province::pluck('name', 'id');
        return view('admin.list_account',[
            'account'=>$account,
            'addresses'=>$addresses,
            'provinces'=>$provinces,
            ]);
    }
    public function profile_account($id)
    {
        $user = DB::Table('users')
                ->where('id',$id)
                ->first();
        $addresses = DB::Table('addresses')
                    ->where('id_users',$id)
                    ->where('status',1)
                    ->get();
        $provinces = Province::pluck('name', 'id');
        return view('admin.profile_account',[
            'user'=>$user,
            'addresses'=>$addresses,
            'provinces'=>$provinces,
        ]);
    }
    public function profile_account_store(Request $req,$id)
    {
        if(isset($_POST['edit']))
        {
            return back()->with('edit','edit');
        }
        if(isset($_POST['edited']))
        {
            $profile = DB::Table('users')->where('id',$id)->update([
                'name' => $req->name,
                'email' => $req->email,
            ]);
            if($req->add_address == TRUE)
            {
                $create_address = Address::create([
                    'id_users' => $id,
                    'phone' => $req->phone,
                    'id_provinces' => $req->province,
                    'id_cities' => $req->city,
                    'id_districts' => $req->district,
                    'id_villages' => $req->village,
                    'name' => $req->name_address,
                    'address' => $req->address,
                    'postal_code' => $req->postalcode,
                ]);
                if($create_address)
                {
                    return back()->with('profile', 'Berhasil menambahkan alamat');
                }
            }
            if(!empty($req->name_address2))
            {
                $update_address = DB::Table('addresses')->where('id',$req->name_address2)->where('id_users',$id)->update([
                    'phone' => $req->phone,
                    'id_provinces' => $req->province,
                    'id_cities' => $req->city,
                    'id_districts' => $req->district,
                    'id_villages' => $req->village,
                    'name' => $req->name_address,
                    'address' => $req->address,
                    'postal_code' => $req->postalcode,
                ]);
                if($update_address)
                {
                    return back()->with('profile','Berhasil melakukan perubahan');
                }
            }
            if($profile)
            {
                return back()->with('profile','Berhasil melakukan perubahan');
            }
            
            return back();
        }

    }
    public function profile_account_address_store(Request $req)
    {
        $addre = DB::Table('addresses')->where('id',$req->get('id'))->first();
        return response()->json($addre);
    }

}
