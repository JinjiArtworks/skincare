<div class="modal-header">
    <h5 class="modal-title">Tambah Saldo</h5>
</div>
<div class="modal-body" id="modalBody">
    <div class="form-group">
        <label class="control-label" for="nominal">Nominal</label>
        <input type="number" class="form-control" id="nominal" placeholder="Masukkan Nominal" name="nominal">
    </div>

    <div class="row row-cols-3">
        <div class="p-1">
            <button type="button" class="btn-nominal btn btn-primary mb-0 w-100" data-nominal="10000">
                Rp 10.000
            </button>
        </div>
        <div class="p-1">
            <button type="button" class="btn-nominal btn btn-primary mb-0 w-100" data-nominal="50000">
                Rp 50.000
            </button>
        </div>
        <div class="p-1">
            <button type="button" class="btn-nominal btn btn-primary mb-0 w-100" data-nominal="100000">
                Rp 100.000
            </button>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button id="pay-button" type="button" class="btn btn-primary btn-checkout w-25 pay-button">
        Bayar
    </button>
</div>
