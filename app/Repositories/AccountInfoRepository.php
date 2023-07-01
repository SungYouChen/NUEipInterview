<?php

namespace App\Repositories;

use App\Models\AccountInfo;
use Illuminate\Database\Eloquent\Builder;

class AccountInfoRepository implements RepositoryInterface
{
    use RepositoryTrait;

    public function __construct()
    {
        $this->model = new AccountInfo();
    }

    /**
     * 取出 query
     * @param $query
     * @return Builder
     */
    public function getList($query): Builder
    {
        return $this->model->query();
    }

    /**
     * 取出所有的 uuid toArray
     * @return mixed
     */
    public function getAllUuidToArray()
    {
        return $this->model->pluck('uuid')->toArray();
    }
}
