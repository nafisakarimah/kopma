@extends('layout.index')
@section('theme-white',true)
@section('content')

<div class="container-fluid">
    <div class="container pb-30">
        <h3 class="mb-4 border-left-9 pl-2 border-secondary py-2">FREQUENTLY ASKED QUESTIONS</h3>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="accordion" id="accordionExample">
                  @foreach ($data as $item)
                    <div class="card">
                      <div class="card-header bg-white border" id="faq-header-{{ $item->id }}">
                        <h2 class="mb-0">
                          <button class="btn btn-link btn-block text-left collapsed pl-3" type="button" data-toggle="collapse" data-target="#faq-content-{{ $item->id }}" aria-expanded="false" aria-controls="faq-content-{{ $item->id }}">
                            {{ $item->judul }}
                          </button>
                        </h2>
                      </div>
                      <div id="faq-content-{{ $item->id }}" class="collapse" aria-labelledby="faq-header-{{ $item->id }}" data-parent="#accordionExample">
                        <div class="card-body">
                          {{ $item->deskripsi }}
                        </div>
                      </div>
                    </div>
                  @endforeach
                  </div>
            </div>
        </div>
    </div>
</div>

@endsection