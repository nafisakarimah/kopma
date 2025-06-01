@extends('layout.panel')
@section('panel',true)

@section('content')

<h5>Member</h5>

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
        <th class="text-white" width="30px">No</th>
        <th class="text-white">Nama</th>
        <th class="text-white">Point</th>
        <th class="text-white">Email</th>
        <th class="text-white">No Telepon</th>
        <th class="text-white">Status</th>
        <th class="text-white">Aksi</th>
      </tr>
    </thead>
    <tbody>
        @if(count($data))
          @foreach($data as $val)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $val->nama }}</td>
              <td>{{ $val->member_poin }}</td>
              <td>{{ $val->email }}</td>
              <td>{{ $val->no_telp }}</td>
              <td>{!! $val->status == '1'? '<span class="badge badge-success">Terverifikasi</span>' : '<span class="badge badge-warning">Belum diverifikasi</span>' !!}</td>
              <td>
                @if ($val->status == '1')
                    <form action="{{ route('admin.member.suspen',$val->id) }}" method="POST">
                        @method('put')
                        @csrf
                        <button class="btn btn-sm btn-danger">
                          <i class="fa fa-ban"></i> Bekukan
                        </button>
                    </form>
                @elseif($val->status == '0')
                  <form action="{{ route('admin.member.verif',$val->id) }}" method="POST">
                    @method('put')
                    @csrf
                    <button class="btn btn-sm btn-success">
                      <i class="fa fa-check"></i> Verifikasi
                    </button>
                </form>
                @endif
              </td>
            </tr>
          @endforeach
        @endif
    </tbody>
  </table>

</div>
@endsection