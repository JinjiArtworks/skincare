@extends('toko.app')
@section('content')
  <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between my-4">
      <h1 class="h3 mb-0 text-gray-800 d-none d-md-inline-block d-lg-inline-block d-xl-inline-block">Daftar Barang</h1>
      <button id="btnTambahBarang" class="d-sm-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i>
        <span class="ms-1 text-white">Tambah Barang</span>
      </button>
    </div>
    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table id="tableBarang" class="table table-striped">
            <thead>
              <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Deskripsi</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($barangs as $b)
                <tr class="listBarang">
                  <td> {{ $b->nama_barang }}</td>
                  <td> {{ $b->harga }}</td>
                  <td> {{ $b->stok }}</td>
                  <td> {{ $b->deskripsi }}</td>
                  <td>
                    <button>Edit</button>
                    <button>Delete</button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  <div id="modalBarang" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">

        {{-- Loading --}}
        <div id="modalLoading" class="row h-100 align-items-center">
          <div class="col align-self-center">
            <div class="d-flex my-5 justify-content-center">
              <div class="spinner-border" role="status">
                <span class="sr-only">Memuat...</span>
              </div>
            </div>
          </div>
        </div>

        {{-- Content --}}
        <div id="modalBarangContent"></div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <script>
    $(document).ready(function() {
      $('#btnTambahBarang').click(function() {
        $('#modalBarang').modal('show');
        $('#modalBarangContent').html('');
        $('#modalLoading').show();
        $.get(`barang/create`, function(res) {
          $('#modalLoading').hide();
          $('#modalBarangContent').html(res);
        });
      });
      // $('.listBarang #btnEditBarang').click(function() {
      //   const id = $(this).data('id');
      //   $('#modalBarang').modal('show');
      //   $('#modalBarangContent').html('');
      //   $('#modalLoading').show();
      //   $.get(`barang/${id}/edit`, function(res) {
      //     $('#modalLoading').hide();
      //     $('#modalBarangContent').html(res);
      //   });
      // });
      // $('#btnDeleteBarang').click(function(){
      //   $('#modalBarang').modal('show');
      //   $('#modalBarangContent').html('');
      //   $('#modalLoading').show();
      // });
      $('#tableBarang').DataTable({
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
        },
        columns: [{
            name: 'Nama Barang',
            orderable: true
          },
          {
            name: 'Harga',
            orderable: true
          },
          {
            name: 'Stok',
            orderable: true
          },
          {
            name: 'Deskripsi',
            orderable: true
          },
          {
            name: '',
            orderable: false
          }
        ]
      });
    });
  </script>
@endpush
