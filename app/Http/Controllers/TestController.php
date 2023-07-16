<?php

namespace App\Http\Controllers;

use App\Imports\GetCollectionImport;
use App\Services\TestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->TestService = new TestService();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('test.index');
    }

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
        $res         = $this->TestService->importTransferExport($collections);

        return response()->json($res);
    }
}
