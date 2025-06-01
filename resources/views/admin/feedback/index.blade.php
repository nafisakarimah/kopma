@extends('layout.panel')
@section('panel',true)

@section('content')

<div class="row mb-3">
    <div class="col-6">
        <h5 class="mb-0">Feedback</h5>
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
        <th class="text-white">Masukan</th>
        <th class="text-white rounded-r-3" width="40px">Tampil</th>
      </tr>
    </thead>
    <tbody>
        @if(count($data))
          @foreach($data as $val)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $val->user->nama }}</td>
              <td>{{ $val->masukan }}</td>
              <td>
                @if ($val->tampil == '0')
                <a href="{{route('admin.feedback.update-tampil',$val->id)}}" class="btn btn-outline-primary d-flex align-items-center" title="Tampilkan">
                  <i class="fa fa-check mr-2"></i> Tampilkan
                </a>
                @else
                <a href="{{route('admin.feedback.update-tampil',$val->id)}}" class="btn btn-warning d-flex align-items-center" title="Sembunyikan">
                  <i class="fa fa-eye-slash mr-2"></i> Sembunyikan
                </a>
                @endif
              </td>
            </tr>
          @endforeach
        @endif
    </tbody>
  </table>
</div>
@endsection