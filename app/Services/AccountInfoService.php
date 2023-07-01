<?php

namespace App\Services;

use App\Models\AccountInfo;
use App\Repositories\AccountInfoRepository;
use Batch;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AccountInfoService
{
    private AccountInfoRepository $AccountInfoRepository;

    public function __construct()
    {
        $this->AccountInfoRepository = new AccountInfoRepository();
    }

    /**
     * 匯入帳號，批次新增、更新
     *
     * @param  object  $collections  excel 內容
     * @return array
     */
    public function import(object $collections): array
    {
        $res         = true;
        $error_msg   = '';
        $collections = $collections[0];
        $batchInsert = [];
        $batchUpdate = [];
        $columns     = [
            'uuid',
            'account',
            'name',
            'gender',
            'birthday',
            'email',
            'note',
        ];

        // 撈取當前所有帳號的 uuid，用於判斷匯入的 uuid 是否存在
        $all_uuid = $this->AccountInfoRepository->getAllUuidToArray();

        // 檢查
        foreach ($collections as $key => $collection) {
            if ($key == 0) { // 檢查欄位是否名稱正確
                if ($collection[0] != "UUID" || $collection[1] != "帳號" || $collection[2] != "姓名" || $collection[3] != "性別" || $collection[4] != "生日" || $collection[5] != "信箱" || $collection[6] != "備註") {
                    $error_msg .= __('column_name_error');
                    break;
                }
            } else {
                $data = [
                    'uuid'     => $collection[0],
                    'account'  => $collection[1],
                    'name'     => $collection[2],
                    'gender'   => $collection[3],
                    'birthday' => $collection[4],
                    'email'    => $collection[5],
                    'note'     => $collection[6],
                ];

                // 檢查欄位必填、格式
                $validator = Validator::make($data, [
                    'account'  => 'required|regex:/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/',
                    'name'     => 'required',
                    'gender'   => 'required|in:男,女',
                    'birthday' => 'required|date',
                    'email'    => 'required|email',
                ]);

                if ($validator->fails()) { // 驗證錯誤
                    if ($error_msg == '') {
                        $error_msg .= __('column_error') . ($key + 1);
                    } else {
                        $error_msg .= ', ' . ($key + 1);
                    }
                } else {
                    $data['gender'] = $data['gender'] === '男' ? 1 : 0;
                    if (isset($collection[0]) && in_array($collection[0], $all_uuid)) { // 有 UUID 並已存在系統 (才可進入批次更新)
                        $batchUpdate[] = $data;
                    } elseif (!isset($collection[0])) {// 無 UUID 進入批次新增列表
                        $data['uuid']  = Str::uuid();
                        $batchInsert[] = $data;
                    }
                }
            }
        }


        if ($error_msg == '') { // 檢查無誤才做批次新增、更新
            if (count($batchInsert) > 0) { // 批次新增
                Batch::insert(new AccountInfo, $columns, $batchInsert);
            }
            if (count($batchUpdate) > 0) { // 批次更新
                Batch::update(new AccountInfo, $batchUpdate, 'uuid');
            }
        } else {
            $res = false;
        }

        return [
            'res'       => $res,
            'error_msg' => $error_msg,
        ];
    }
}