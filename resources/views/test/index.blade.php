@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Test
                    </div>
                    <div class="card-body overflow-auto">
                        <button type="button" class="btn btn-sm btn-warning"
                                id="showImportModal">整理</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('test.import_modal')

    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({ // Ajax 加上 CSRF
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#showImportModal').click(function () { // 點擊匯入按鈕，彈出新增視窗
                $('#import_file').val(null);
                $('#ImportModal').modal("show");
            });

            $('#import').click(function () { // 點擊匯入按鈕
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
                            url: "{{ route('test.import') }}",
                            type: "post",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function (res) {
                                window.location.href = res.file_url;
                            },
                            error: function (exception) {
                                laravel_validate(exception);
                            }
                        });
                    }
                });
            });

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
        });
    </script>
@endsection
