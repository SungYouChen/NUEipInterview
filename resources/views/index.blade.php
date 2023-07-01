@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{ __('account_list') }}
                        <div>
                            <button type="button" class="btn btn-sm btn-primary"
                                    id="showModal">{{ __('create') }}</button>
                            <button type="button" class="btn btn-sm btn-danger"
                                    id="deleteBatch">{{ __('delete_batch') }}</button>
                            <button type="button" class="btn btn-sm btn-warning"
                                    id="showImportModal">{{ __('import') }}</button>
                            <a href="{{ route('account.export') }}"
                               class="btn btn-sm btn-success">{{ __('export') }}</a>
                        </div>
                    </div>
                    <div class="card-body overflow-auto">
                        <table class="table table-bordered data-table w-100">
                            <thead>
                            <tr>
                                <th class="text-center"><input id="clickAll" type="checkbox"/></th>
                                <th style="display: none">id</th>
                                <th class="text-center">#</th>
                                <th>{{ __('account') }}</th>
                                <th>{{ __('name') }}</th>
                                <th>{{ __('gender') }}</th>
                                <th>{{ __('birthday') }}</th>
                                <th>{{ __('email') }}</th>
                                <th>{{ __('note') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('create_modal')
    @include('update_modal')
    @include('import_modal')

    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({ // Ajax 加上 CSRF
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const table = $('.data-table').DataTable({ // Datatable 具現化
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                order: [[1, "desc"]],
                processing: true,
                serverSide: true,
                language: {
                    url: "{{ asset('datatable/datatables_tw.json') }}"
                },
                ajax: {
                    url: "{{ route('account.getList') }}",
                    dataType: "json",
                    type: "post",
                },
                columns: [
                    {data: 'check', name: 'check', orderable: false, searchable: false, className: 'text-center'},
                    {data: 'id', name: 'id'},
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {data: 'account', name: 'account'},
                    {data: 'name', name: 'name'},
                    {data: 'gender', name: 'gender'},
                    {data: 'birthday', name: 'birthday'},
                    {data: 'email', name: 'email'},
                    {data: 'note', name: 'note'},
                ],
                columnDefs: [
                    {
                        targets: [1],
                        createdCell: function (td) {
                            $(td).css('display', 'none');
                        },
                    },
                    {
                        targets: [2, 3, 4, 5, 6, 7, 8],
                        createdCell: function (td, cellData, rowData) {
                            $(td).css('cursor', 'pointer');
                            $(td).click(function () { // 點擊呼叫 ajax 撈取資料，並顯示編輯 modal
                                const uuid = rowData.uuid;

                                if (uuid === undefined) {
                                    return false;
                                } else {
                                    $.ajax({
                                        type: "get",
                                        url: "{{ URL::to('account') }}" + '/' + uuid,
                                        dataType: "json",
                                        success: function (res) {
                                            $('#u_account').val(res.account);
                                            $('#u_name').val(res.name);
                                            $('#u_gender').val(res.gender);
                                            $('#u_birthday').val(res.birthday);
                                            $('#u_email').val(res.email);
                                            $('#u_note').val(res.note);
                                            $('#uuid').val(res.uuid);
                                            $('#AccountUpdateModal').modal('show');
                                        }
                                    });
                                }
                            });
                        },
                    },
                ],
            });

            $("#clickAll").click(function () { // 全選
                if ($("#clickAll").prop("checked")) {
                    $("input[name='someCheckbox[]']").prop("checked", true);
                } else {
                    $("input[name='someCheckbox[]']").prop("checked", false);
                }
            });

            $('#showModal').click(function () { // 點擊新增按鈕，彈出新增視窗
                clear_input();
                alert_hide();
                $('#AccountCreateModal').modal("show");
            });

            $('#createAccount').click(function () { // 點擊新增按鈕
                alert_hide();

                Swal.fire({
                    title: "{{ __('confirm_title') }}",
                    text: "{{ __('confirm_note') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{ __('confirm') }}",
                    cancelButtonText: "{{ __('cancel') }}",
                    reverseButtons: true
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: "{{ URL::to('account') }}",
                            type: "post",
                            data: {
                                account: $('#account').val(),
                                name: $('#name').val(),
                                gender: $('#gender').val(),
                                birthday: $('#birthday').val(),
                                email: $('#email').val(),
                                note: $('#note').val(),
                            },
                            success: function () {
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "{{ __('confirm_success') }}",
                                    confirmButtonText: "{{ __('confirm') }}",
                                });
                                $('#AccountCreateModal').modal('hide');
                                table.ajax.reload();
                            },
                            error: function (exception) {
                                laravel_validate(exception);
                            }
                        });
                    }
                });
            });

            $('#updateAccount').click(function () { // 點擊更新按鈕
                alert_hide();

                Swal.fire({
                    title: "{{ __('confirm_title') }}",
                    text: "{{ __('confirm_note') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{ __('confirm') }}",
                    cancelButtonText: "{{ __('cancel') }}",
                    reverseButtons: true
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: "{{ URL::to('account') }}" + '/' + $('#uuid').val(),
                            type: "PATCH",
                            data: {
                                u_account: $('#u_account').val(),
                                u_name: $('#u_name').val(),
                                u_gender: $('#u_gender').val(),
                                u_birthday: $('#u_birthday').val(),
                                u_email: $('#u_email').val(),
                                u_note: $('#u_note').val(),
                            },
                            success: function () {
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "{{ __('confirm_success') }}",
                                    confirmButtonText: "{{ __('confirm') }}",
                                });
                                $('#AccountUpdateModal').modal('hide');
                                table.ajax.reload();
                            },
                            error: function (exception) {
                                laravel_validate(exception);
                            }
                        });
                    }
                });
            });

            $('#deleteAccount').click(function () { // 點擊刪除按鈕
                Swal.fire({
                    title: "{{ __('delete_title') }}",
                    text: "{{ __('delete_note') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{ __('confirm') }}",
                    cancelButtonText: "{{ __('cancel') }}",
                    reverseButtons: true
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: "{{ URL::to('account') }}" + '/' + $('#uuid').val(),
                            type: "DELETE",
                            success: function () {
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "{{ __('confirm_success') }}",
                                    confirmButtonText: "{{ __('confirm') }}",
                                });
                                $('#AccountUpdateModal').modal('hide');
                                table.ajax.reload();
                            }
                        });
                    }
                });
            });

            $('#deleteBatch').click(function () {
                let checked_array = [];
                $("input[name='someCheckbox[]']:checked").each(function () {
                    checked_array.push($(this).val());
                });

                Swal.fire({
                    title: "{{ __('batch_delete_title') }}",
                    text: "{{ __('batch_delete_note') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{ __('confirm') }}",
                    cancelButtonText: "{{ __('cancel') }}",
                    reverseButtons: true
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('account.deleteBatch') }}",
                            type: "post",
                            data: {
                                batch_uuid: checked_array
                            },
                            success: function () {
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "{{ __('confirm_success') }}",
                                    confirmButtonText: "{{ __('confirm') }}",
                                });
                                table.ajax.reload();
                            }
                        });
                    }
                });
            });

            $('#showImportModal').click(function () { // 點擊匯入按鈕，彈出新增視窗
                $('#AccountImportModal').modal("show");
            });

            $('#importAccount').click(function () { // 點擊匯入按鈕
                alert_hide();

                let formData = new FormData();
                formData.append("import_file", document.getElementById('import_file').files[0]);

                Swal.fire({
                    title: "{{ __('confirm_title') }}",
                    text: "{{ __('confirm_note') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{ __('confirm') }}",
                    cancelButtonText: "{{ __('cancel') }}",
                    reverseButtons: true
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('account.import') }}",
                            type: "post",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function (res) {
                                if (res.res) { // 匯入成功
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "{{ __('confirm_success') }}",
                                        confirmButtonText: "{{ __('confirm') }}",
                                    });
                                    $('#AccountImportModal').modal('hide');
                                    table.ajax.reload();
                                } else {
                                    Swal.fire({
                                        position: "center",
                                        icon: "error",
                                        title: res.error_msg,
                                        confirmButtonText: "{{ __('confirm') }}",
                                    });
                                }
                            },
                            error: function (exception) {
                                laravel_validate(exception);
                            }
                        });
                    }
                });
            });

            function clear_input() { // 清除輸入框
                $("#AccountCreateModal input").each(function () {
                    $(this).val(null);
                });
                $("#AccountCreateModal select").each(function () {
                    $(this).val(null);
                });
                $("#AccountCreateModal textarea").each(function () {
                    $(this).val(null);
                });
            }

            function laravel_validate(exception) { // laravel 驗證錯誤顯示
                let exception_json;
                try {
                    exception_json = exception.responseJSON.errors;

                    for (let key in exception_json) {
                        $('#validate_' + key).html(exception_json[key]);
                        $('#validate_' + key).show();
                    }
                } catch (e) {
                    console.log(e);
                }
            }

            function alert_hide() { // 驗證 alert 隱藏
                $(".alert").each(function () {
                    $(this).hide();
                });
            }
        });
    </script>
@endsection
