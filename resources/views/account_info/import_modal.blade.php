<div class="modal fade" id="AccountImportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">{{ __('import_account') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label class="col-md-2 col-sm-12 col-form-label text-md-end">{{ __('file') }}</label>
                    <div class="col-md-10 col-sm-12">
                        <input class="form-control" type="file" id="import_file"  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
                        <div class="alert alert-danger" id="validate_import_file" style="display:none;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
                <button type="button" class="btn btn-primary" id="importAccount">{{ __('submit') }}</button>
                <a href="{{asset('example/匯入帳號範例.xlsx')}}" class="btn btn-success">{{ __('example') }}</a>
            </div>
        </div>
    </div>
</div>