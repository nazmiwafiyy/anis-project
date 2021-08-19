<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="approveForm" method="POST" action="{{ route('application.approve',$application->id) }}" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Maklumat Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    {{-- <input type="hidden" name="id" value="{!! $application->id !!}" /> --}}
                    <div class="form-group">
                    <label for="payment" class="col-form-label">Jumlah bayaran</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">RM</span>
                        </div>
                        <input name="payment" type="number" min="0" class="form-control" required>
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="payment_date" class="col-form-label">Tarikh bayaran</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input class="form-control" placeholder="Tarikh bayaran" name="payment_date" type="text" id="payment_date" required>
                        <span class="input-group-append">
                            <button type="button" class="btn btn-default clear-payment-date">Hapus</button>
                        </span>
                    </div>
                    </div>
                    <label for="">Bukti bayaran</label>
                    <div class="custom-file ">
                        <label for="payment_prove" class="custom-file-label">
                                Bukti bayaran
                        </label>
                        <input name="payment_prove" type="file" class="custom-file-input form-control-sm" multiple="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>