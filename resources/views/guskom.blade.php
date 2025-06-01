@extends('layout.index')
@section('theme-white',true)
@section('content')

<div class="container-fluid">
    <div class="container pb-30">
        <h3 class="mb-4 border-left-9 pl-2 border-secondary py-2">GUSGUS KOMUNITAS</h3>

        <div id="guskom" class="owl-carousel owl-theme">
            @foreach ($data as $item)
            <div class="d-flex flex-column align-items-center text-center px-4"
                style="width: 250px; margin: 0 auto; padding: 15px; border-radius: 10px; border: 1px solid #ddd; box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">

                <div style="width: 100px; height: 100px; overflow: hidden; border-radius: 10px; border: 1px solid #ccc;">
                    <a href="{{ url('uploads/'.$item->gambar) }}" target="_blank">
                        <img src="{{ url('uploads/'.$item->gambar) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                    </a>
                </div>

                <span class="d-block mt-3 fw-bold" style="color: #333; font-size: 16px;">{{ $item->nama }}</span>

                <a href="{{ route('guskom.show',$item->slug) }}"
                style="color: #007bff; text-decoration: none; font-weight: 500; margin-top: 8px;">
                Cek Selengkapnya »
                </a>
            </div>


            @endforeach
        </div>
    </div>
</div>

@endsection
@push('js')
    <script>
        $('#guskom').owlCarousel({
            loop:false,
            margin:10,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:4
                }
            }
        })
    </script>
    @endpush
