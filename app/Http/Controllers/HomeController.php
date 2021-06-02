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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings()
    {
        $user = User::where('id',Auth::user()->id);
        $provinces = Province::pluck('name', 'id');
        $address = DB::Table('addresses')->where(['id_users' => Auth::user()->id, 'status' => 1,])->get();
        return view('settings',[
            'user' => $user,
            'provinces' => $provinces,
            'address' => $address,
        ]);
    }
    public function settings_store(Request $req)
    {
        if(isset($_POST['change_profile']))
        {
            $profile = DB::Table('users')->where('id',Auth::user()->id)->update([
                'name' => $req->name,
                'email' => $req->email,
            ]);
            if($profile)
            {
                return back()->with('profile','Berhasil melakukan perubahan');
            }
        }
        if(isset($_POST['change_password']))
        {
            $value = $req->password_old;
            $validator = $req->validate([
                'password_old' => [
                    'required', function ($attribute, $value, $fail) {
                        if (!Hash::check($value, Auth::user()->password)) {
                            $fail('Old Password didn\'t match');
                        }
                    },
                ],
                'password' => 'required|string|min:8|confirmed',
            ]);
            $password = DB::Table('users')->where('id',Auth::user()->id)->update([
                'password' => Hash::make($req->password),
            ]);
            if($password)
            {
                return back()->with('password', 'Berhasil merubah password');
            }
        }
        if(isset($_POST['submit']))
        {
            if($req->id_address == NULL)
            {
                $create_address = Address::create([
                    'id_users' => Auth::user()->id,
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
                    return back()->with('address', 'Berhasil menambahkan alamat');
                }
            }
            else
            {
                $update_address = DB::Table('addresses')->where([
                    'id' => $req->id_address, 
                    'id_users' => Auth::user()->id,
                    ])->update([
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
                    return back()->with('address', 'Berhasil merubah alamat');
                }
            }
        }
        if(isset($_POST['delete_address']))
        {
            if($req->id_address != NULL)
            {
                $delete_address = DB::Table('addresses')->where([
                    'id' => $req->id_address, 
                    'id_users' => Auth::user()->id,
                    ])->update([
                        'status' => 0,
                    ]);
                if($delete_address)
                {
                    return back()->with('address', 'Berhasil menghapus alamat');
                }
            }
            return back();
        }
    }
}
