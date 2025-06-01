@extends('layout.index')
@section('content')

    <!-- Carousel Start -->
    <div class="container mb-3 hero row align-items-center mx-auto">
        <div class="col-md-8 p-0 order-2 order-md-1 text-center text-md-left">
            <h1 class="fw-bold">
                <q><i>Mari berdinamika dengan <span class="text-tertiary">mewujudkan digitalisasi</span> koperasi mahasiswa yang <span class="text-tertiary">maju</span> dan unggul</i></q>
            </h1>
            <span class="d-block mb-3">Berproses bersama Kopmania lainnya disini</span>
            <a href="" class="btn fw-bold btn-secondary">JOIN NOW</a>
        </div>
        <div class="col-md-4 order-1 order-md-2 mb-3 mb-md-0">
            <img src="{{ asset('assets/img/maskot 1.png') }}" alt="" width="100%">
        </div>
    </div>

    <div class="container pt-5 pb-30">
        <div class="pc-4">
            <h1 class="fw-bold text-primary">Divisi Usaha</h1>
            <small class="d-block mb-4">yuk kepoin produknya disini</small>
            
            @if(count($kategori))
                <nav>
                    <div class="nav nav-tabs mb-4 border-0" id="nav-tab" role="tablist">
                        @foreach ($kategori as $index => $item)
                            <button class="btn btn-outline-primary mr-3 {{ $index == 0? 'active' : '' }} rounded-3 border-2" id="nav-{{ $item->slug }}-tab" data-toggle="tab" data-target="#nav-{{ $item->slug }}" type="button" role="tab" aria-controls="nav-{{ $item->slug }}" aria-selected="true">{{ $item->nama }}</button>
                        @endforeach
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    @foreach ($kategori as $index => $item)
                    <div class="tab-pane fade {{ $index == 0? 'show active' : '' }}" id="nav-{{ $item->slug }}" role="tabpanel" aria-labelledby="nav-{{ $item->slug }}-tab">
                        <div class="row mb-4">
                            @foreach ($item->produk as $produk)
                                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                                    <a href="{{ route('produk.detail',$produk->slug) }}" class="product-item bg-secondary mb-4 d-block rounded-3 text-decoration-none overflow-hidden" style="min-height: 420px">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" src="{{ asset($produk->gambar) }}" alt="">
                                        </div>
                                        <div class="p-4 text-center">
                                            <h6 class="h6 text-decoration-none text-truncate ">{{ $produk->nama }}</h6>
                                            <h5 class="">Rp. {{ number_format($produk->harga,0,',','.') }}</h5>
                                            <p class="">{{ $produk->deskripsi }}</p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center">
                            <a href="{{ route('kategori.detail',$item->slug) }}" class="btn btn-sm btn-primary">Muat Produk Lainnya</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="container pb-30">
        <h1 class="fw-bold text-primary">Gugus dan Komunitas</h1>
        <small class="d-block mb-4">Kamu juga bisa produktif bersama kopmania lain lho</small>

        <div id="guskom" class="owl-carousel owl-theme">
            @foreach ($guskom as $item)
            <div style="width: 250px;" class="px-4 text-center">
                <img src="{{ asset($item->gambar) }}" alt="" width="100%">
                <span class="d-block mt-3">{{ $item->nama }}</span>
                <a href="{{ route('guskom.show',$item->slug) }}">Cek Selengkapnya >></a>
            </div>
            @endforeach
        </div>

    </div>
    
    <div class="bg-secondary">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-4 position-relative">
                    <img src="{{ asset('assets/img/maskot mirror 1.png') }}" alt="" width="80%" class="position-absolute">
                </div>
                <div class="col-md-8 ml-auto">
                    <h3 class="text-white text-center mb-4">Benefits</h3>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="btn rounded-3 bg-white text-dark w-100 py-2">Mengembangkan skill</div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="btn rounded-3 bg-white text-dark w-100 py-2">Menambah Pengalaman dan Relasi</div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="btn rounded-3 bg-white text-dark w-100 py-2">Melatih Kedisiplinan</div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="btn rounded-3 bg-white text-dark w-100 py-2">Melatih memanajemen waktu</div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="btn rounded-3 bg-white text-dark w-100 py-2">Melatih memanajemen keuangan</div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="btn rounded-3 bg-white text-dark w-100 py-2">Menambah Wawasan dalam dunia kerja</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5 my-5">
        <h1 class="fw-bold text-primary text-center mb-4 mt-5">Apa Kata Mereka ?</h1>
        <div id="testimony" class="owl-carousel owl-theme">
            @foreach ($feedback as $item)
            <div class="col-md-12 p-5" style="background-color: #FEFFDE">
                <p class="mb-3">{{ $item->masukan }}</p>
                <div class="row">
                    <div class="col-2 px-0">
                        <img src="{{ asset($item->user->foto? $item->user->foto : 'assets/img/fotoguest.png') }}" alt="" width="100%">
                    </div>
                    <div class="col-8">
                        <h6 class="mb-0">{{ $item->user->nama }}</h6>
                        <small>{{ $item->user->member == '1'? 'Member Aciko' : 'Customer' }}</small>
                    </div>
                </div>
            </div>
            @endforeach
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
        $('#testimony').owlCarousel({
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
                    items:3
                }
            }
        })
    </script>
@endpush