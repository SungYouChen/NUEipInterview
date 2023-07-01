<?php

namespace App\Models;

use App\Presenters\AccountInfoPresenter;
use Illuminate\Database\Eloquent\Model;
use TheHiveTeam\Presentable\HasPresentable;

class AccountInfo extends Model
{
    use HasPresentable;

    protected $presenter = AccountInfoPresenter::class;
    protected $table = 'account_info';
    protected $guarded = [];
}
