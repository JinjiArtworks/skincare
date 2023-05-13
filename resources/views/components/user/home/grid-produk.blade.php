<div {{ $attributes }}>
  <h5 class="text-">{{ $title }}</h5>
  <div class="overflow-scroll">
    <div class="d-flex flex-row py-2 overflow-visible">
      @foreach ($produks as $produk)
        <div class="col-10 col-md-3">
          <x-shared.card-produk :produk="$produk" />
        </div>
      @endforeach
    </div>
  </div>
</div>
