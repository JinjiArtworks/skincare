@extends('layouts.toko')

@push('styles')
  <link rel="stylesheet" href="https://www.unpkg.com/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="https://www.unpkg.com/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.css">
  <link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" />
@endpush

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
                <th>Kategori</th>
                <th>Etalase</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($barangs as $b)
                <tr class="listBarang">
                  <td> {{ $b->nama }}</td>
                  <td> {{ $b->harga }}</td>
                  <td> {{ $b->stok }}</td>
                  <td> {{ $b->deskripsi }}</td>
                  <td>{{ $b->kategori->nama }}</td>
                  <td>
                    @if ($b->etalase)
                      {{ $b->etalase->nama }}
                  </td>
                @else
                  Tidak Masuk Etalase
              @endif
              <td>{{ $b->status }}</td>

              <td>
                <button id="btnEditBarang" data-id="{{ $b->id }}"
                  class="btn btn-sm btn-secondary ms-1 text-white">Edit</button>
                <form action="{{ route('toko.barang.destroy', $b->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <input type="submit" value="Hapus" class="btn btn-sm btn-danger text-white"
                    onclick="if(!confirm('Apakah anda yakin?')) return false"; />
                </form>
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
    <div class="modal-dialog modal-dialog-scrollable">
      {{-- Loading --}}
      <div id="modalLoading" class="modal-content">
        <div class="modal-body">
          <div class="row h-100 align-items-center">
            <div class="col align-self-center">
              <div class="d-flex my-5 justify-content-center">
                <div class="spinner-border" role="status">
                  <span class="sr-only">Memuat...</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="modalBarangContent" class="modal-content"></div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://unpkg.com/select2/dist/js/select2.min.js"></script>
  <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
  <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
  <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
  <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
  <script>
    $(document).ready(function() {
      $.fn.filepond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);

      $(document).on('change', '#harga', function() {
        var harga = $(this).val();
        $('#nominalDiskon').prop('min', 1);

        if (harga) {
          $('#diskonWrapper').removeClass('d-none');
          $('#nominalDiskon').prop('max', harga);
        } else {
          $('#diskonWrapper').addClass('d-none');
          $('#nominalDiskon').prop('max', 100);
        }
      });

      $(document).on('change', '#isDiskon', function() {
        $('.diskon-col').toggleClass('d-none');
      });

      $(document).on('change', '#jenisDiskon', function() {
        var jenis = $(this).val();
        $('#nominalDiskon').prop('min', 1);

        if (jenis == 'persen') {
          $('#igPersen').removeClass('d-none');
          $('#igNominal').addClass('d-none');
          $('#nominalDiskon').prop('max', 100);
        } else {
          $('#igPersen').addClass('d-none');
          $('#igNominal').removeClass('d-none');
          $('#nominalDiskon').prop('max', $('#harga').val());
        }
      });

      $(document).on('change', '#nominalDiskon', function() {
        var jenis = $('#jenisDiskon').val();
        var harga = $('#harga').val();
        var nominal = $(this).val(); // 100
        var hargaDiskon;

        if (jenis == 'persen') {
          $(this).prop('max', 100);
          if (nominal > 100) {
            nominal = 100;
          } else if (nominal < 1) {
            nominal = 1;
          }

          $(this).val(nominal);

          hargaDiskon = harga - (harga * (nominal / 100));
        } else {
          $(this).prop('max', harga);
          if (nominal > harga) {
            nominal = harga;
          } else if (nominal < 1) {
            nominal = 1;
          }

          $(this).val(nominal);

          hargaDiskon = harga - nominal;
        }

        $('#hargaDiskon').val(hargaDiskon);
      });

      $('#modalBarang').on('hidden.bs.modal', function() {
        $('#modalBarangContent').addClass('d-none');
      });

      $('#modalBarang').on('show.bs.modal', function() {
        $('#modalBarangContent').addClass('d-none');
        $('#modalBarangContent').html('');
        $('#modalLoading').removeClass('d-none');
      });

      $('#btnTambahBarang').click(function() {
        $('#modalBarang').modal('show');

        $.get(`barang/create`, function(res) {
          $('#modalBarangContent').html(res);
          $('#modalLoading').addClass('d-none');
          $('#modalBarangContent').removeClass('d-none');

          $('input[name="fotos[]"]').filepond({
            storeAsFile: true,
            maxFiles: 5,
            acceptedFileTypes: ['image/*'],
          });

          $('#kandungans').select2({
            theme: 'bootstrap-5'
          });
        });
      });

      $('.listBarang #btnEditBarang').click(function() {
        var id = $(this).data('id');
        $('#modalBarang').modal('show');

        $.get(`barang/${id}/edit`, function(res) {
          $('#modalBarangContent').html(res);
          $('#modalLoading').addClass('d-none');
          $('#modalBarangContent').removeClass('d-none');

          $('input[name="fotos[]"]').filepond({
            storeAsFile: true,
            maxFiles: 5,
            acceptedFileTypes: ['image/*'],
          });

          $('#kandungans').select2({
            theme: 'bootstrap-5'
          });
        });
      });
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
            name: 'Kategori',
            orderable: true
          },
          {
            name: 'Etalase',
            orderable: true
          },
          {
            name: 'Status',
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
