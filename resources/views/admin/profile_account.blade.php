@extends('layouts.app')
@section('title','Profil: '.$user->name)
@section('content')

<div class="section-body">
    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-5">
            <div class="card profile-widget">
                <div class="profile-widget-header">                     
                    <img alt="image" src="{{asset('assets/images/avatar-1.png')}}" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-value">187</div>
                            <div class="profile-widget-item-label">Sampah</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-value">6,8K</div>
                            <div class="profile-widget-item-label">Saldo (Rp)</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-value">0</div>
                            <div class="profile-widget-item-label">Pertukaran</div>
                        </div>
                    </div>
                </div>
                <form method="POST">
                    <div class="profile-widget-description">
                        @if (session('profile'))
                            <div class="alert alert-success" role="alert">
                                {{ session('profile') }}!
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">Nama</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nama Lengkap" value="{{ $user->name }}" required @if (!session('edit')) disabled @endif>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label">Email</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ $user->email }}" required  @if (!session('edit')) disabled @endif>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name_address2" class="col-3 col-md-3 col-form-label">Alamat</label>
                            <div class="col-10 col-md-7">
                                <select name="name_address2" id="name_address2" class="form-control">
                                    <option value="" disabled selected>== Nama Alamat ==</option>
                                    @foreach ($addresses as $ad)
                                        <option value="{{ $ad->id }}">{{ $ad->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <button class="form-control" type="button" data-toggle="collapse" data-target="#addres" aria-expanded="false" aria-controls="addres">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="collapse" id="addres">
                            @if(session('edit') && count($addresses)<1)
                            <div class="form-check form-check-inline mb-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="add_address" id="add_address" value="1"> Tambah Alamat
                                </label>
                            </div>
                            @endif
                            @csrf
                            <input type="hidden" id="id_address" name="id_address" value="">
                            <div class="form-group row">
                                <label for="phone" class="col-md-3 col-form-label">No. Telepon</label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Nomor Telepon" required disabled>
                                </div>
                            </div>
                            @if(session('edit'))
                                <div class="form-group row">
                                    <label for="name_address" class="col-md-3 col-form-label">Nama Alamat</label>
                                    <div class="col-md-9">
                                    <input type="text" name="name_address" id="name_address" class="form-control" placeholder="Nama Alamat" aria-describedby="name_address" required disabled>
                                    <small id="name_address" class="text-muted">Contoh: Rumah, Kantor, dll.</small>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label for="province" class="col-md-3 col-form-label">Provinsi</label>
                                <div class="col-md-9">
                                    <select name="province" id="province" class="form-control" required disabled>
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
                                    <select name="city" id="city" class="form-control" required disabled>
                                        <option value="" disabled selected>== Pilih Kabupaten/Kota ==</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="district" class="col-md-3 col-form-label">Kecamatan</label>
                                <div class="col-md-9">
                                    <select name="district" id="district" class="form-control" required disabled>
                                        <option value="" disabled selected>== Pilih Kecamatan ==</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="village" class="col-md-3 col-form-label">Kelurahan</label>
                                <div class="col-md-9">
                                    <select name="village" id="village" class="form-control" required disabled>
                                        <option value="" disabled selected>== Pilih Kelurahan ==</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-md-3 col-form-label">Alamat</label>
                                <div class="col-md-9">
                                    <textarea name="address" id="address" class="form-control" style="height: 64px !important;" placeholder="Alamat Lengkap" required disabled></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="postalcode" class="col-md-3 col-form-label">Kode Pos</label>
                                <div class="col-md-9">
                                    <input type="number" name="postalcode" id="postalcode" placeholder="Kode Pos" class="form-control" required disabled>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group mr-2" role="group">
                                    <button type="submit" @if(session('edit')) name="edited" @else name="edit" @endif class="btn btn-primary">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
            <form method="post" class="needs-validation" novalidate="">
                <div class="card-header">
                <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <div class="row">                               
                    <div class="form-group col-md-6 col-12">
                        <label>First Name</label>
                        <input type="text" class="form-control" value="Ujang" required="">
                        <div class="invalid-feedback">
                        Please fill in the first name
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label>Last Name</label>
                        <input type="text" class="form-control" value="Maman" required="">
                        <div class="invalid-feedback">
                        Please fill in the last name
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-7 col-12">
                        <label>Email</label>
                        <input type="email" class="form-control" value="ujang@maman.com" required="">
                        <div class="invalid-feedback">
                        Please fill in the email
                        </div>
                    </div>
                    <div class="form-group col-md-5 col-12">
                        <label>Phone</label>
                        <input type="tel" class="form-control" value="">
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-12">
                        <label>Bio</label>
                        <textarea class="form-control summernote-simple">Ujang maman is a superhero name in <b>Indonesia</b>, especially in my family. He is not a fictional character but an original hero in my family, a hero for his children and for his wife. So, I use the name as a user in this template. Not a tribute, I'm just bored with <b>'John Doe'</b>.</textarea>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group mb-0 col-12">
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" id="newsletter">
                        <label class="custom-control-label" for="newsletter">Subscribe to newsletter</label>
                        <div class="text-muted form-text">
                            You will get new information about products, offers and promotions
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                <button class="btn btn-primary">Save Changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    
    $(function () {
        $('#name_address2').on('change', function () {
            $('#addres').addClass('show');
            axios.post('{{ route('admin.profile_account.address.store',$user->id) }}', {id: $(this).val()}).then(function (response) {
                $('#id_address').val(response.data.id);
                $('#phone').val(response.data.phone);
                $('#name_address').val(response.data.name);
                
                axios.post('{{ route('province.store') }}', {id: response.data.id_provinces}).then(function (response2) {
                    $('#province').empty();
                    $("#province").append('<option value="" disabled>== Pilih Provinsi ==</option>');
                    $.each(response2.data, function (id, name) {
                        $('#province').append(new Option(name, id));
                    });
                    $('#province option[value='+response.data.id_provinces+']').attr('selected','selected');
                });
                
                axios.post('{{ route('city.store') }}', {id: response.data.id_provinces}).then(function (response3) {
                    $('#city').empty();
                    $("#city").append('<option value="" disabled>== Pilih Kabupaten/Kota ==</option>');
                    $.each(response3.data, function (id, name) {
                        $('#city').append(new Option(name, id));
                    });
                    $('#city option[value='+response.data.id_cities+']').attr('selected','selected');
                });
                axios.post('{{ route('district.store') }}', {id: response.data.id_cities}).then(function (response4) {
                    $('#district').empty();
                    $("#district").append('<option value="" disabled>== Pilih Kecamatan ==</option>');
                    $.each(response4.data, function (id, name) {
                        $('#district').append(new Option(name, id));
                    });
                    $('#district option[value='+response.data.id_districts+']').attr('selected','selected');
                });
                axios.post('{{ route('village.store') }}', {id: response.data.id_districts}).then(function (response5) {
                    $('#village').empty();
                    $("#village").append('<option value="" disabled>== Pilih Kelurahan ==</option>');
                    $.each(response5.data, function (id, name) {
                        $('#village').append(new Option(name, id));
                    });
                    $('#village option[value='+response.data.id_villages+']').attr('selected','selected');
                });
                @if(session('edit'))
                $('#phone').prop("disabled", false);
                $('#name_address').prop("disabled", false);
                $('#province').prop("disabled", false);
                $('#city').prop("disabled", false);
                $('#district').prop("disabled", false);
                $('#village').prop("disabled", false);
                $('#address').prop("disabled", false);
                $('#postalcode').prop("disabled", false);
                @endif
                $('#address').val(response.data.address);
                $('#postalcode').val(response.data.postal_code);
            });
        });
        $('input[id="add_address"]').click(function(){
            if($(this).is(":checked")){
                $('#phone').prop("disabled", false);
                $('#name_address').prop("disabled", false);
                $('#province').prop("disabled", false);
                $('#city').prop("disabled", false);
                $('#district').prop("disabled", false);
                $('#village').prop("disabled", false);
                $('#address').prop("disabled", false);
                $('#postalcode').prop("disabled", false);
            }
            else if($(this).is(":not(:checked)")){
                $('#phone').prop("disabled", true);
                $('#name_address').prop("disabled", true);
                $('#province').prop("disabled", true);
                $('#city').prop("disabled", true);
                $('#district').prop("disabled", true);
                $('#village').prop("disabled", true);
                $('#address').prop("disabled", true);
                $('#postalcode').prop("disabled", true);
            }
        });
        $('#province').on('change', function () {
            axios.post('{{ route('city.store') }}', {id: $(this).val()}).then(function (response) {
                $('#city').empty();
                $('#district').empty();
                $('#village').empty();
                $("#city").append('<option value="" disabled selected>== Pilih Kabupaten/Kota ==</option>');
                $("#district").append('<option value="" disabled selected>== Pilih Kecamatan ==</option>');
                $("#village").append('<option value="" disabled selected>== Pilih Kelurahan ==</option>');
                $.each(response.data, function (id, name) {
                    $('#city').append(new Option(name, id));
                });
            });
        });
        $('#city').on('change', function () {
            axios.post('{{ route('district.store') }}', {id: $(this).val()}).then(function (response) {
                $('#district').empty();
                $('#village').empty();
                $("#district").append('<option value="" disabled selected>== Pilih Kecamatan ==</option>');
                $("#village").append('<option value="" disabled selected>== Pilih Kelurahan ==</option>');
                $.each(response.data, function (id, name) {
                    $('#district').append(new Option(name, id));
                });
            });
        });
        $('#district').on('change', function () {
            axios.post('{{ route('village.store') }}', {id: $(this).val()}).then(function (response) {
                $('#village').empty();
                $("#village").append('<option value="" disabled selected>== Pilih Kelurahan ==</option>');
                $.each(response.data, function (id, name) {
                    $('#village').append(new Option(name, id));
                });
            });
        });
    });
    
</script>
@endsection