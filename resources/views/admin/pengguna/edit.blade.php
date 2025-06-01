@extends('layout.panel')
@section('panel',true)

@section('content')

<h5>Pengguna</h5>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->has('error'))
    <div class="alert alert-danger">
        {{ $errors->first('error') }}
    </div>
@endif

<form action="" method="post">
  @csrf
  @method('put')
  <div class="row">
      <div class="col-md-6">
          <div class="form-group">
              <label for="">Nama</label>
              <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" value="{{ $data->nama }}" readonly> 
              @error('nama')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
          </div>
      </div>
      <div class="col-md-6 {{ $data->member == '1'? '' : 'd-none' }}">
          <div class="form-group">
              <label for="">Member Poin</label>
              <h6>{{ (int)$data->member_point }} Point</h6>
          </div>
      </div>
      <div class="col-md-6 {{ $data->member == '1'? '' : 'd-none' }}" id="input-nak">
          <div class="form-group">
              <label for="">NAK</label>
              <input type="text" name="nak" class="form-control" placeholder="Masukkan NAK" value="{{ $data->nak }}" readonly> 
              @error('nak')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
          </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
              <label for="">No Telepon</label>
              <input type="text" name="no_telp" class="form-control" placeholder="Masukkan No Telepon" value="{{ $data->no_telp }}" readonly> 
              @error('no_telp')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
          </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
              <label for="">Alamat</label>
              <textarea name="alamat" rows="2" class="form-control" placeholder="Masukkan alamat lengkap" readonly>{{ $data->alamat }}</textarea>
              @error('alamat')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
          </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
              <label for="">Email</label>
              <input type="email" name="email" class="form-control" placeholder="Masukkan Email" value="{{ $data->email }}" readonly> 
              @error('email')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
          </div>
      </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
          <label for="">Role</label>
          <select name="role" id="" class="form-control">
            <option value="customer" {{ $data->member == '0'? 'selected' : '' }}>Customer</option>
            <option value="member" {{ $data->member == '1'? 'selected' : '' }}>Member</option>
          </select>
          @error('role')
              <small class="text-danger">{{ $message }}</small>
          @enderror
      </div>
  </div>
  <div class="col-md-6">
      <div class="form-group">
          <label for="">Status</label>
          <select name="status" id="" class="form-control">
            <option value="0" {{ $data->status == '0'? 'selected' : '' }}>Nonaktif</option>
            <option value="1" {{ $data->status == '1'? 'selected' : '' }}>Diverifikasi</option>
            <option value="1" {{ $data->status == '2'? 'selected' : '' }}>Dibebukan</option>
          </select>
          @error('status')
              <small class="text-danger">{{ $message }}</small>
          @enderror
      </div>
  </div>
  </div>
  <div class="text-right">
    <button class="btn btn-primary">Simpan</button>
  </div>
</form>

@endsection