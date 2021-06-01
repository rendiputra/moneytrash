@extends('layouts.app')

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-7">
            <div class="card profile-widget">
                <div class="profile-widget-header">                     
                    <img alt="image" src="{{asset('assets/images/avatar-1.png')}}" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        @if(Auth::user()->role == 1)
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">0</div>
                                <div class="profile-widget-item-label">Sampah</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">{{number_format(Wallet::amount(Auth::user()->id),0)}}</div>
                                <div class="profile-widget-item-label">Saldo (Rp)</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">0</div>
                                <div class="profile-widget-item-label">Pertukaran</div>
                            </div>
                        @elseif(Auth::user()->role == 2)
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">0</div>
                                <div class="profile-widget-item-label">Pickup</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">{{number_format(Wallet::amount(Auth::user()->id),0)}}</div>
                                <div class="profile-widget-item-label">Saldo (Rp)</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">0</div>
                                <div class="profile-widget-item-label">Pertukaran</div>
                            </div>
                        @endif
                    </div>
                </div>
                <form method="POST">
                    <div class="pl-4">
                        <h2 class="section-title">Jual Sampah</h2>
                        <p class="section-lead">
                          Jual sampahmu dapatkan uangmu.
                        </p>
                    </div>
                    <div class="profile-widget-description">
                        @if (session('profile'))
                            <div class="alert alert-success" role="alert">
                                {{ session('profile') }}!
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="garbage" class="col-md-3 col-form-label">Jenis Sampah</label>
                            <div class="col-12 col-md-9">
                                <select name="garbage" id="garbage" class="form-control">
                                    <option value="" selected>== Jenis Sampah ==</option>
                                    @foreach($types as $type)
                                        <option value="{{$type->id}}">{{$type->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="qty" class="col-md-3 col-form-label">Qty</label>
                            <div class="col-4 col-md-3">
                                <input type="number" class="form-control" name="qty" id="qty" placeholder="Qty" min="1" value="1" required>
                            </div>
                            <div class="col-8 col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="hidden" id="realprice">
                                    <input type="text" id="price" class="form-control" id="price" value="0" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-12 col-md-3 col-form-label">Pilih Alamat</label>
                            <div class="col-12 col-md-9 col-md-9">
                                <select name="address" id="address" class="form-control">
                                    <option value="" disabled selected>== Nama Alamat ==</option>
                                    @foreach ($addresses as $ad)
                                        <option value="{{ $ad->id }}">{{ $ad->name }} - ({{$ad->phone}})</option>
                                    @endforeach
                                </select>
                                @if(count($addresses)<1)
                                    <span>Anda tidak memiliki alamat, <a href="{{ route('settings') }}#addresses" class="text-danger">Klik disini</a>. Untuk menambahkan alamat.</span>
                                @endif
                                <div id="txtaddress"></div>
                            </div>
                        </div>
                        <iframe id="map_canvas" frameborder="0" style="border:0; width: 100%; display: none;" height="250" allowfullscreen></iframe>
                        <div class="mt-4">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group mr-2" role="group">
                                    <button type="submit" name="submit" class="btn btn-primary">Jual Sampah</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="card card-hero">
                <div class="card-header">
                    @if(Auth::user()->role == 1)
                        <div class="card-icon">
                            <i class="fas fa-recycle"></i>
                        </div>
                        <h4>0</h4>
                        <div class="card-description">Sampah</div>
                        @else
                        <div class="card-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h4>14</h4>
                        <div class="card-description">Pickup</div>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="tickets-list">
                        {{-- <a href="#" class="ticket-item">
                            <div class="ticket-title">
                            <h4>My order hasn't arrived yet</h4>
                            </div>
                            <div class="ticket-info">
                            <div>Laila Tazkiah</div>
                            <div class="bullet"></div>
                            <div class="text-primary">1 min ago</div>
                            </div>
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function myMap() {
        var mapProp= {
            center:new google.maps.LatLng(51.508742,-0.120850),
            zoom:5,
        };
        var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
    }
    $('#garbage').on('change', function() {
        axios.post('{{ route('user.types.store') }}', {id: $(this).val()}).then(function (response) {
            var price = $('#price').val(response.data.price);
            var price = $('#realprice').val(response.data.price);
        });
    });
    $('#address').on('change', function() {
        axios.post('{{ route('user.profile_account.address.store') }}', {id: $(this).val()}).then(function (response) {
            var address = response.data.address + ', ' + response.data.villages_name + ', ' + response.data.districts_name + ', ' + response.data.cities_name + ', ' + response.data.province_name + ', ' + response.data.postal_code;
            $('#txtaddress').html(address);
            var meta = JSON.parse(response.data.villages_meta);
            var link = "https://www.google.com/maps/embed/v1/place?key=AIzaSyCkgBvgpMl5UnG7Gqi4hQhJ3NMROtgdySI&language=id&q="+response.data.villages_name+"&center="+meta.lat+","+meta.long+"";
            $('#map_canvas').attr('src', link);
            $('#map_canvas').css('display','block');
        });
    });
    $('#qty').on('change', function() {
        var price = $('#realprice').val();
        var qty = $('#qty').val();
        var count = price * qty;
        $('#price').val(count);
    });
</script>
@endsection