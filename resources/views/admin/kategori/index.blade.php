@extends('layout.panel')
@section('panel',true)

@section('content')

<div class="row mb-3">
    <div class="col-6">
        <h5 class="mb-0">Kategori</h5>
    </div>
    <div class="col-6 text-right">
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-sm btn-primary rounded-3">Tambah Baru</a>
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
        <th class="text-white">Ukuran</th>
        <th class="text-white rounded-r-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
        @if(count($data))
          @foreach($data as $val)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $val->nama }}</td>
              <td>{{ $val->ukuran == '1'? 'Dengan Ukuran' : '-' }}</td>
              <td>
                <a href="{{ route('admin.kategori.edit',$val->id) }}" class="btn btn-sm btn-info">Edit</a>
                <form action="{{ route('admin.kategori.destroy',$val->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')">
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