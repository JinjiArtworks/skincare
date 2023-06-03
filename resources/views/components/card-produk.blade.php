@props(['produk'])

<div class="px-2">
  <div class="card text-decoration-none card-hover px-0">
    <img class="card-img-top w-100" src="{{ $produk->placeholder }}" />
    <div class="card-body">
      <a href="{{ route('user.kategori.show', $produk->kategori_id) }}"
        class="link-info text-decoration-none">{{ $produk->kategori->nama }}</a>
      <p class="fw-semibold fs-6">{{ $produk->nama }}</p>
      <h6>@rupiah($produk->harga)</h6>
      <a href="{{ route('user.produk.show', $produk->id) }}" class="stretched-link"></a>
    </div>
  </div>
</div>