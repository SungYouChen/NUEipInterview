<div class="modal fade" id="AccountUpdateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">{{ __('update_account') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-md-3">
                    <label class="col-md-2 col-sm-12 col-form-label text-md-end">{{ __('account') }}</label>
                    <div class="col-md-10 col-sm-12"><input class="form-control" type="text" id="u_account"
                                                                 placeholder="{{ __('p_account') }}"/>
                        <div class="alert alert-danger" id="validate_u_account" style="display:none;"></div>
                    </div>
                </div>
                <div class="row mb-md-3">
                    <label class="col-md-2 col-sm-12 col-form-label text-md-end">{{ __('name') }}</label>
                    <div class="col-md-10 col-sm-12"><input class="form-control" type="text" id="u_name"
                                                                 placeholder="{{ __('p_name') }}"/>
                        <div class="alert alert-danger" id="validate_u_name" style="display:none;"></div>
                    </div>
                </div>
                <div class="row mb-md-3">
                    <label class="col-md-2 col-sm-12 col-form-label text-md-end">{{ __('gender') }}</label>
                    <div class="col-md-10 col-sm-12"><select class="form-select" id="u_gender">
                            <option value="" disabled selected>{{ __('p_gender') }}</option>
                            <option value="1">{{ __('gender_m') }}</option>
                            <option value="0">{{ __('gender_f') }}</option>
                        </select>
                        <div class="alert alert-danger" id="validate_u_gender" style="display:none;"></div>
                    </div>
                </div>
                <div class="row mb-md-3">
                    <label class="col-md-2 col-sm-12 col-form-label text-md-end">{{ __('birthday') }}</label>
                    <div class="col-md-10 col-sm-12"><input class="form-control" type="date" id="u_birthday"/>
                        <div class="alert alert-danger" id="validate_u_birthday" style="display:none;"></div>
                    </div>
                </div>
                <div class="row mb-md-3">
                    <label class="col-md-2 col-sm-12 col-form-label text-md-end">{{ __('email') }}</label>
                    <div class="col-md-10 col-sm-12"><input class="form-control" type="text" id="u_email"
                                                                 placeholder="{{ __('p_email') }}"/>
                        <div class="alert alert-danger" id="validate_u_email" style="display:none;"></div>
                    </div>
                </div>
                <div class="row mb-md-3">
                    <label class="col-md-2 col-sm-12 col-form-label text-md-end">{{ __('note') }}</label>
                    <div class="col-md-10 col-sm-12"><textarea class="form-control" type="text"
                                                                    id="u_note"
                                                                    placeholder="{{ __('p_note') }}"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
                <button type="button" class="btn btn-primary" id="updateAccount">{{ __('submit') }}</button>
                <button type="button" class="btn btn-danger" id="deleteAccount">{{ __('delete') }}</button>
            </div>
        </div>
    </div>
    <input class="hiding" type="text" id="uuid"/>
</div>
