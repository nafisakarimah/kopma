@extends('layout.panel')
@section('panel',true)

@section('content')

<div class="row mb-3">
    <div class="col-6">
        <h5 class="mb-0">Alamat Pengiriman</h5>
    </div>
    <div class="col-6 text-right">
        <a href="{{ route('user.alamat-pengiriman.create') }}" class="btn btn-sm btn-primary rounded-3">Tambah Baru</a>
    </div>
</div>

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

<div class="card card-body rounded-3">
<table class="table datatable">
    <thead class="bg-primary text-white">
      <tr>
        <th class="text-white rounded-l-3" width="30px">No</th>
        <th class="text-white">Nama</th>
        <th class="text-white">No Telp</th>
        <th class="text-white">ALamat</th>
        <th class="text-white">Utama</th>
        <th class="text-white rounded-r-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
        @if(count($data))
          @foreach($data as $val)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $val->nama }}</td>
              <td>{{ $val->no_telp }}</td>
              <td>{{ $val->alamat }}</td>
              <td>
                @if ($val->utama == '1')
                <span class="badge badge-primary">Utama</span>
                @else
                <a href="{{ route('user.alamat-pengiriman.utama',$val->id) }}" class="btn btn-sm btn-primary rounded-3">Jadikan Utama</a>
                @endif
              </td>
              <td>
                <a href="{{ route('user.alamat-pengiriman.edit',$val->id) }}" class="btn btn-sm btn-info">Edit</a>
                <form action="{{ route('user.alamat-pengiriman.destroy',$val->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                    @method('delete')
                    @csrf
                    <button class="btn btn-sm btn-danger">
                        <i class="fa fa-times"></i> hapus
                    </button>
                </form>
              </td>
            </tr>
          @endforeach
        @endif
    </tbody>
  </table>

</div>
@endsection