<?php

namespace App\Http\Controllers;

use App\Exports\AccountInfoExport;
use App\Imports\GetCollectionImport;
use App\Repositories\AccountInfoRepository;
use App\Services\AccountInfoService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\Facades\DataTables;

class AccountInfoController extends Controller
{
    protected AccountInfoRepository $AccountInfoRepository;
    private AccountInfoService $AccountInfoService;

    public function __construct()
    {
        $this->AccountInfoRepository = new AccountInfoRepository();
        $this->AccountInfoService    = new AccountInfoService();
    }

    /**
     * 帳號列表
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('index');
    }

    /**
     * 新建帳號
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // 驗證欄位
        $request->validate([
            'account'  => 'required|regex:/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/',
            'name'     => 'required',
            'gender'   => 'required',
            'birthday' => 'required|date',
            'email'    => 'required|email',
        ], [
            '*.required'    => __('validate_required'),
            'account.regex' => __('validate_account_regex'),
            '*.date'        => __('validate_date'),
            '*.email'       => __('validate_email'),
        ]);

        $data = [
            'account'  => Str::lower($request->account),
            'name'     => $request->name,
            'gender'   => $request->gender,
            'birthday' => $request->birthday,
            'email'    => $request->email,
            'note'     => $request->note,
            'uuid'     => Str::uuid(),
        ];

        $res = $this->AccountInfoRepository->create($data);

        return response()->json($res);
    }

    /**
     * 檢視帳號
     *
     * @param  string  $uuid  帳號唯一識別碼
     * @return JsonResponse
     */
    public function show(string $uuid): JsonResponse
    {
        $res = $this->AccountInfoRepository->showByUuid($uuid);

        return response()->json($res);
    }

    /**
     * 修改帳號
     *
     * @param  Request  $request
     * @param  string  $uuid  帳號唯一識別碼
     * @return JsonResponse
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        // 驗證欄位
        $request->validate([
            'u_account'  => 'required|regex:/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/',
            'u_name'     => 'required',
            'u_gender'   => 'required',
            'u_birthday' => 'required|date',
            'u_email'    => 'required|email',
        ], [
            '*.required'    => __('validate_required'),
            'account.regex' => __('validate_account_regex'),
            '*.date'        => __('validate_date'),
            '*.email'       => __('validate_email'),
        ]);

        $data = [
            'account'  => Str::lower($request->u_account),
            'name'     => $request->u_name,
            'gender'   => $request->u_gender,
            'birthday' => $request->u_birthday,
            'email'    => $request->u_email,
            'note'     => $request->u_note,
        ];

        $res = $this->AccountInfoRepository->update($data, $uuid);

        return response()->json($res);
    }

    /**
     * 刪除帳號
     *
     * @param  string  $uuid  帳號唯一識別碼
     * @return JsonResponse
     */
    public function destroy(string $uuid): JsonResponse
    {
        $res = $this->AccountInfoRepository->delete($uuid);

        return response()->json($res);
    }

    /**
     * 取得 Datatables 列表
     *
     * @param  Request  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function getList(Request $request): JsonResponse
    {
        $data = $this->AccountInfoRepository->getList($request->all());

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('check', function ($each) {
                return "<input type='checkbox' value='$each->uuid' name='someCheckbox[]'/>";
            })
            ->editColumn('gender', function ($each) {
                return $each->present()->showGender($each->gender);
            })
            ->editColumn('birthday', function ($each) {
                return date(__('date_format'), strtotime($each->birthday));
            })
            ->rawColumns(['check'])
            ->make(true);
    }

    /**
     * 批次刪除
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function deleteBatch(Request $request): JsonResponse
    {
        $res = true;

        if ($request->batch_uuid) {
            foreach ($request->batch_uuid as $uuid) {
                $res = $this->AccountInfoRepository->delete($uuid);
            }
        }

        return response()->json($res);
    }

    /**
     * 匯入帳號
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function import(Request $request): JsonResponse
    {
        // 驗證欄位
        $request->validate([
            'import_file' => 'required|mimes:xlsx',
        ], [
            '*.required' => __('validate_required'),
            '*.mimes'    => __('validate_mimes_xlsx'),
        ]);

        // 取出 Excel 內容為 collection
        $collections = (new GetCollectionImport())->toCollection($request->file('import_file'));
        $res         = $this->AccountInfoService->import($collections);

        return response()->json($res);
    }

    /**
     * 匯出帳號
     *
     * @param  Request  $request
     * @return BinaryFileResponse
     */
    public function export(Request $request): BinaryFileResponse
    {
        return Excel::download(new AccountInfoExport(), date('Ymd') . __('account_export') . '.xlsx');
    }
}
