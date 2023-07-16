<?php

namespace App\Services;

use App\Exports\ArrayToExcel;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class TestService
{
    /**
     * 匯入
     *
     * @param  object  $collections  excel 內容
     * @return array
     */
    public function importTransferExport(object $collections)
    {
        $res       = true;
        $error_msg = '';
        $file_name = '整理專案.xlsx';
        $column    = [
            '項目號碼',
            '項目種類',
            '資源',
            '工廠/作業類型',
            '採購組織',
            '數量',
            '單位',
            '總價(單價)',
            '說明',
            '成本要素',
            '專案定義',
            'WBS元素',
            '利潤中心',
        ];
        $array     = [];
        $collections[0]->shift();
        $collections = $collections[0]->sortBy('4');

        foreach ($collections as $collection) {
            if ($collection[0] > 0) { // 已採購未出貨
                $array[] = [
                    '編號', // 項目號碼
                    'M', // 項目種類
                    $collection[3], // 資源
                    '1101', // 工廠/作業類型
                    '', // 採購組織
                    $collection[0], // 數量
                    '', // 單位
                    '0', // 總價(單價)
                    '', // 說明
                    '', // 成本要素
                    $collection[4], // 專案定義
                    $collection[5], // WBS元素
                    $collection[6], // 利潤中心
                ];
            }

            if ($collection[1] > 0) { // 未採購
                $array[] = [
                    '編號', // 項目號碼
                    'M', // 項目種類
                    $collection[3], // 資源
                    '1101', // 工廠/作業類型
                    '', // 採購組織
                    $collection[1], // 數量
                    '', // 單位
                    $collection[2], // 總價(單價)
                    '', // 說明
                    '', // 成本要素
                    $collection[4], // 專案定義
                    $collection[5], // WBS元素
                    $collection[6], // 利潤中心
                ];
            }
        }

        // 整理編號
        $res_array = [];
        $wbs       = null;
        $key       = 0;
        foreach ($array as $each) {
            $each_wbs = $each[10];
            if ($wbs != $each_wbs) {
                $key = 1;
                $wbs = $each_wbs;
            } else {
                $key++;
            }
            $each[0]     = $key;
            $res_array[] = $each;
        }

        // 儲存成excel
        $file_path = 'public/' . $file_name;
        Excel::store(new ArrayToExcel($res_array, $column), $file_path);

        return [
            'res'       => $res,
            'error_msg' => $error_msg,
            'array'     => $res_array,
            'file_url'  => Storage::url($file_path)
        ];
    }
}