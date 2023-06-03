@php
  $idEtalase = request()->query()['etalase'] ?? 'semua';
@endphp

@extends('layouts.app')
@section('title', 'Toko • Skincare')
@section('content')
  <div class="grid mt-md-0" style="margin-top: 22%">
    <div class="row row-cols-1 row-cols-lg-2">
      <div class="col-12 col-md-5 col-lg-3 sticky-md-top align-self-md-start" style="top: 10%">
        <div class="bg-white p-4 rounded-4 shadow-sm">
          <div class="section-profil">
            <p class="fw-bold mb-0">{{ $toko->nama }}</p>
          </div>
          <hr class="form-divider">
          <div class="section-menu">
            <p class="fw-bold mt-2 mb-0">Etalase</p>
            <hr class="form-divider">
            <div class="list-group">
              <a href="{{ route('user.toko.index', ['toko' => $toko->id]) }}"
                class="list-group-item list-group-item-action {{ $idEtalase == 'semua' ? 'active' : '' }}">
                Semua
              </a>
              @foreach ($etalases as $etalase)
                <a href="{{ route('user.toko.index', ['toko' => $toko->id, 'etalase' => $etalase->id]) }}"
                  class="list-group-item list-group-item-action {{ $etalase->id == $idEtalase ? 'active' : '' }}">
                  {{ $etalase->nama }}
                </a>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-7 col-lg-9">
        <div class="bg-white p-4 rounded-4 shadow-sm">
          @if (count($barangs))
            <div class="row row-cols-md-4 row-cols-2">
              @foreach ($barangs as $produk)
                <x-card-produk :produk="$produk" />
              @endforeach
            </div>
          @else
            <div class="empty-state text-center" data-height="400" style="height: 400px;">
              <div class="empty-state-icon">
                <i class="fas fa-question"></i>
              </div>
              <h2>Belum ada produk @if ($etalase)
                  pada etalase {{ $etalase->nama }}
                @else
                  di toko ini
                @endif
              </h2>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
