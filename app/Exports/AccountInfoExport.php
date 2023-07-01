<?php

namespace App\Exports;

use App\Presenters\AccountInfoPresenter;
use App\Repositories\AccountInfoRepository;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AccountInfoExport implements WithHeadings, ShouldAutoSize
{
    private AccountInfoRepository $AccountInfoRepository;
    private AccountInfoPresenter $AccountInfoPresenter;

    public function __construct()
    {
        $this->AccountInfoRepository = new AccountInfoRepository();
        $this->AccountInfoPresenter = new AccountInfoPresenter();
    }

    public function headings(): array
    {
        $column = ['UUID', '帳號', '姓名', '性別', '生日', '信箱', '備註'];
        $data   = $this->AccountInfoRepository->all()->map(function ($each) {
            return [
                $each->uuid,
                $each->account,
                $each->name,
                $this->AccountInfoPresenter->showGender($each->gender),
                $each->birthday,
                $each->email,
                $each->note,
            ];
        })->toArray();
        array_unshift($data, $column);
        return $data;
    }
}
