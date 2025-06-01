@extends('layout.index')
@section('theme-white',true)
@section('content')

<div class="container-fluid">
    <div class="container pb-30">
        <h3 class="mb-4 border-left-9 pl-2 border-secondary py-2">GUSGUS KOMUNITAS BADMINTON</h3>
        <div class="row">
            <div class="col-md-8">
                <div class="card text-white border-0 shadow-lg" style="background: linear-gradient(135deg, #647658, #277a20); border-radius: 12px; overflow: hidden;">
                    <div class="d-flex align-items-center p-3">
                        <div style="width: 200px; height: 200px; overflow: hidden; border-radius: 12px; border: 2px solid rgba(255, 255, 255, 0.3); box-shadow: 2px 4px 6px rgba(0, 0, 0, 0.1);">
                            <a href="{{ url('uploads/'.$data->gambar) }}" target="_blank">
                                <img src="{{ url('uploads/'.$data->gambar) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                            </a>
                        </div>
                        <div class="ps-3 flex-grow-1">
                            <div class="fw-bold fs-5" style="color: #fff;">{{ $data->judul }}</div>
                        </div>
                    </div>
                    <div class="px-4 py-3" style="background: rgba(255, 255, 255, 0.1); border-top: 1px solid rgba(255, 255, 255, 0.2);">
                        <p class="mb-0" style="font-size: 14px; line-height: 1.6; color: rgba(255, 255, 255, 0.9);">
                            {!! $data->deskripsi !!}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 text-right">
                <h3 class="mb-4 pr-4 border-right border-secondary py-2">GUSKOM Lainnya</h3>
                <div class="list-group">
                    @foreach ($lainnya as $item)
                    <a href="{{ route('guskom.show', $item->slug) }}" class="list-group-item list-group-item-action border-0 d-flex align-items-center">
                        <div style="width: 50px; height: 50px; overflow: hidden; border-radius: 8px; border: 1px solid #ddd; margin-right: 10px;">
                            <img src="{{ url('uploads/'.$item->gambar) }}" alt="{{ $item->nama }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <span class="text-dark">{{ $item->nama }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
