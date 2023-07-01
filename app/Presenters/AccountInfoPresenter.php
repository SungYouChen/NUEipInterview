<?php

namespace App\Presenters;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use TheHiveTeam\Presentable\Presenter;

class AccountInfoPresenter extends Presenter
{
    /**
     * 將性別代碼轉換成文字
     *
     * @param  string  $gender  性別代碼
     * @return array|Application|Translator|\Illuminate\Foundation\Application|string|null
     */
    public function showGender(string $gender): \Illuminate\Foundation\Application|array|string|Translator|Application|null
    {
        $text = null;
        switch ($gender) {
            case "1":
                $text = __('gender_m');
                break;
            case "0":
                $text = __('gender_f');
                break;
        }
        return $text;
    }
}