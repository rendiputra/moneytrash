@extends('layouts.app')
@section('title','Daftar Akun')
@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="tab-pane fade @if (session('address')) show active @endif" id="addresses" role="tabpanel" aria-labelledby="address-tab">
                <div id="addreass" class="card">
                    <div class="card-header">
                        {{ __('Alamat') }}
                    </div>
                    <div class="card-body">
                        @if (session('address'))
                            <div class="alert alert-success" role="alert">
                                {{ session('address') }}!
                            </div>
                        @endif
                        <form method="POST">
                            @csrf
                            <input type="hidden" id="id_address" name="id_address" value="">
                            <div class="form-group row">
                                <label for="phone" class="col-md-3 col-form-label">No. Telepon</label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Nomor Telepon" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name_address" class="col-md-3 col-form-label">Nama Alamat</label>
                                <div class="col-md-9">
                                <input type="text" name="name_address" id="name_address" class="form-control" placeholder="Nama Alamat" aria-describedby="name_address" required>
                                <small id="name_address" class="text-muted">Contoh: Rumah, Kantor, dll.</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="province" class="col-md-3 col-form-label">Provinsi</label>
                                <div class="col-md-9">
                                    <select name="province" id="province" class="form-control" required>
                                        <option value="" disabled selected>== Pilih Provinsi ==</option>
                                        @foreach ($provinces as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="col-md-3 col-form-label">Kab./Kota</label>
                                <div class="col-md-9">
                                    <select name="city" id="city" class="form-control" required>
                                        <option value="" disabled selected>== Pilih Kabupaten/Kota ==</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="district" class="col-md-3 col-form-label">Kecamatan</label>
                                <div class="col-md-9">
                                    <select name="district" id="district" class="form-control" required>
                                        <option value="" disabled selected>== Pilih Kecamatan ==</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="village" class="col-md-3 col-form-label">Kelurahan</label>
                                <div class="col-md-9">
                                    <select name="village" id="village" class="form-control" required>
                                        <option value="" disabled selected>== Pilih Kelurahan ==</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-md-3 col-form-label">Alamat</label>
                                <div class="col-md-9">
                                    <textarea name="address" id="address" class="form-control" style="height: 64px !important;" placeholder="Alamat Lengkap" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="postalcode" class="col-md-3 col-form-label">Kode Pos</label>
                                <div class="col-md-9">
                                    <input type="number" name="postalcode" id="postalcode" placeholder="Kode Pos" class="form-control" required>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="btn-toolbar" role="toolbar">
                                    <div class="btn-group mr-2" role="group">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    <div class="btn-group mr-2" role="group">
                                        <button type="reset" id="reset" class="btn btn-warning">Reset</button>
                                    </div>
                                    <div class="btn-group mr-2" id="delete_address" style="display: none;" role="group">
                                        <button type="submit" name="delete_address" onclick="return deleted()" class="btn btn-danger">Hapus Alamat</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection