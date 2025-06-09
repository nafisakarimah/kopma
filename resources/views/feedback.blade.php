@extends('layout.index')
@section('theme-white',true)
@section('content')
<div class="container pb-5">
    <div class="row">
        <div class="col-md-9 mx-auto">
            <h6 class="fw-bold">Kata Mereka tentang Aciko</h6>
            <span    class="d-block mb-4">Yuk dengarkan :)</span>

            <div class="card border-0 bg-primary rounded-3 mb-5">
                <div class="card-body">
                    <div id="testimony" class="owl-carousel owl-theme">
                        @foreach ($data as $item)
                        <div class="px-4">
                            <div class="row">
                                <div class="col-6 px-0 mx-auto mb-n5 position-relative" style="z-index: 1">
                                    <div class="foto-profil">
                                        <img src="{{ asset($item->user->foto? 'uploads/' .$item->user->foto : 'assets/img/fotoguest.png') }}" alt="" width="100%">
                                    </div>
                                </div>
                                <div class="col-12 bg-body px-3 pt-5 pb-3 text-center rounded-3">
                                    <h3 class="mb-0 mt-1">{{ $item->user->nama }}</h3>
                                    <small><q class="mb-3 text-dark fw-bold"><i>{{ $item->masukan }}</i></q></small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="text-center mb-5">
                <h5>Ingin memberi feedback pada kami?</h5>
                <h6>bisa kirimkan lewat form ini ya! </h6>
            </div>
            {{-- @if(!$feedback) --}}
            <div class="row mb-5">
                <div class="col-md-8 mx-auto">
                    <h5>Apa Kata Kamu ?</h5>
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
                        <div class="form-group">
                            <textarea name="masukan" id="" rows="3" placeholder="tuliskan feedback...." class="form-control rounded-0 bg-secondary text-dark"></textarea>
                            @error('masukan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary rounded-pill">Send</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- @endif --}}
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
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
