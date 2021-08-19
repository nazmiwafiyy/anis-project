<div class="modal fade" id="rejectModalSu" tabindex="-1" role="dialog" aria-labelledby="rejectModalSuLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('application.reject.su',$application->id) }}" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="rejectModalSuLabel">Sebab Penolakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    {{-- <input type="hidden" name="id" value="{!! $application->id !!}" /> --}}
                    <textarea name="reject_reason" class="form-control" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>