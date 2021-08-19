<div class="modal fade" id="approveModalSu" tabindex="-1" role="dialog" aria-labelledby="approveModalSuLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="approveFormSu" method="POST" action="{{ route('application.approve.su',$application->id) }}" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="approveModalSuLabel">Maklumat Kelulusan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-form-label">Jenis Kelulusan</label>
                        @if ($currentLevel  < 1)
                            <div class="icheck-primary">
                                <input type="checkbox" name="level-1" id="level-1">
                                <label class="font-weight-normal" for="level-1">Kelulusan Ketua Jabatan</label>
                            </div>
                        @endif 
                        @if ($currentLevel < 2)
                            <div class="icheck-primary">
                                <input type="checkbox" name="level-2" id="level-2">
                                <label class="font-weight-normal" for="level-2">Kelulusan Biro Kebajikan dan Sosial</label>
                            </div>
                        @endif 
                        @if ($currentLevel < 3)
                            <div class="icheck-primary">
                                <input type="checkbox" name="level-3" id="level-3">
                                <label class="font-weight-normal" for="level-3">Kelulusan Setiausaha / Penolong Setiausha Kelab Sukan dan Kebajikan JKMM</label>
                            </div>
                        @endif 
                        @if ($currentLevel < 4)
                            <div class="icheck-primary">
                                <input type="checkbox" name="level-4" id="level-4">
                                <label class="font-weight-normal" for="level-4">Kelulusan Bendahari / Penolong Bendahari</label>
                            </div>
                        @endif 
                    </div>
                    <div id="payment">
                        <div class="form-group">
                            <label for="payment" class="col-form-label">Jumlah bayaran</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text">RM</span>
                                </div>
                                <input name="payment" type="number" min="0" class="form-control">
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
                                <input class="form-control" placeholder="Tarikh bayaran" name="payment_date" type="text" id="payment_date_su">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-default clear-payment-date-su">Hapus</button>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>