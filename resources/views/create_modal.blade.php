<div class="modal fade" id="AccountCreateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">{{ __('create_account') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-md-3">
                    <label class="col-md-2 col-sm-12 col-form-label text-md-end">{{ __('account') }}</label>
                    <div class="col-md-10 col-sm-12"><input class="form-control" type="text" id="account"
                                                            placeholder="{{ __('p_account') }}"/>
                        <div class="alert alert-danger" id="validate_account" style="display:none;"></div>
                    </div>

                </div>
                <div class="row mb-md-3">
                    <label class="col-md-2 col-sm-12 col-form-label text-md-end">{{ __('name') }}</label>
                    <div class="col-md-10 col-sm-12"><input class="form-control" type="text" id="name"
                                                            placeholder="{{ __('p_name') }}"/>
                        <div class="alert alert-danger" id="validate_name" style="display:none;"></div>
                    </div>
                </div>
                <div class="row mb-md-3">
                    <label class="col-md-2 col-sm-12 col-form-label text-md-end">{{ __('gender') }}</label>
                    <div class="col-md-10 col-sm-12"><select class="form-select" id="gender">
                            <option value="" disabled selected>{{ __('p_gender') }}</option>
                            <option value="1">{{ __('gender_m') }}</option>
                            <option value="0">{{ __('gender_f') }}</option>
                        </select>
                        <div class="alert alert-danger" id="validate_gender" style="display:none;"></div>
                    </div>
                </div>
                <div class="row mb-md-3">
                    <label class="col-md-2 col-sm-12 col-form-label text-md-end">{{ __('birthday') }}</label>
                    <div class="col-md-10 col-sm-12"><input class="form-control" type="date" id="birthday"/>
                        <div class="alert alert-danger" id="validate_birthday" style="display:none;"></div>
                    </div>
                </div>
                <div class="row mb-md-3">
                    <label class="col-md-2 col-sm-12 col-form-label text-md-end">{{ __('email') }}</label>
                    <div class="col-md-10 col-sm-12"><input class="form-control" type="text" id="email"
                                                            placeholder="{{ __('p_email') }}"/>
                        <div class="alert alert-danger" id="validate_email" style="display:none;"></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 col-sm-12 col-form-label text-md-end">{{ __('note') }}</label>
                    <div class="col-md-10 col-sm-12"><textarea class="form-control" type="text"
                                                               id="note"
                                                               placeholder="{{ __('p_note') }}"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
                <button type="button" class="btn btn-primary" id="createAccount">{{ __('submit') }}</button>
            </div>
        </div>
    </div>
</div>