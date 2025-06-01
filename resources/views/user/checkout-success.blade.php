@extends('layout.index')
@section('theme-white',true)
@section('content')

<div class="container-fluid">
    <div class="container pb-30">
        <div class="bg-white p-30 mb-2 border-2 border-primary rounded-3 mb-5 text-dark">
            <div class="text-center">
                <h5 class="mb-4 fw-bold">YOUR ORDER HAS BEEN RECIEVED</h5>
                <p class="fw-bold mb-5">Thank you for your order. We will begin to confirm and process it right away.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 fw-bold">
                    <span class="mr-3">ORDER DATE: </span> <span>{{ date('d/m/Y H:i',strtotime($detail->created_at)) }}</span>
                </div>
                <div class="col-md-4 fw-bold">
                    <span class="mr-3">ORDER NUMBER: </span> <span>{{ $detail->no_po }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection