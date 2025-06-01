@extends('layout.panel')
@section('panel',true)

@section('content')

<div class="row mb-3">
    <div class="col-6">
        <h5 class="mb-0">Produk</h5>
    </div>
    <div class="col-6 text-right">
        <a href="{{ route('admin.produk.create') }}" class="btn btn-sm btn-primary rounded-3">Tambah Baru</a>
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
        <th class="text-white">Harga</th>
        <th class="text-white">Stok</th>
        <th class="text-white" width="200px">Deskripsi</th>
        <th class="text-white rounded-r-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
        @if(count($data))
          @foreach($data as $val)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $val->nama }}</td>
              <td>
                @if ($val->kategori->ukuran == '1')
                <ul>
                  @foreach ($val->ukuran as $item)
                    <li>{{ $item->ukuran }} : {{ $item->stok }}</li>
                  @endforeach
                </ul>
                @else
                - 
                @endif
              </td>
              <td>Rp. {{ number_format($val->harga,0,',','.') }}</td>
              <td>{{ $val->kategori->ukuran == '1'? '-' : $val->stok }}</td>
              <td>{{ strlen($val->deskripsi) > 50? substr($val->deskripsi,0,50).'...' : $val->deskripsi }}</td>
              <td>
                <a href="{{ route('admin.produk.edit',$val->id) }}" class="btn btn-sm btn-info">Edit</a>
                <form action="{{ route('admin.produk.destroy',$val->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')">
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