<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

trait RepositoryTrait
{
    /**
     * 取得model全部資料
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * 新增一筆資料
     * @param array $data 新增的資料
     * @return Collection
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * 顯示單筆資料，使用 id
     * @param int $id 顯示資料的 id
     * @return Collection|false
     */
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * 顯示單筆資料，使用 uuid
     * @param string $uuid 顯示資料的 uuid
     * @return Collection
     */
    public function showByUuid($uuid)
    {
        return $this->model->where('uuid', $uuid)->first();
    }

    /**
     * 更新單筆資料，使用 uuid
     * @param array $data 更新的資料內容
     * @param string $uuid 更新資料的 uuid
     * @return Collection
     */
    public function update(array $data, $uuid)
    {
        $modal = self::showByUuid($uuid);
        return $modal->update($data);
    }

    /**
     * 刪除單筆資料
     * @param string $uuid 刪除資料的 uuid
     * @return int
     */
    public function delete($uuid)
    {
        $data = self::showByUuid($uuid);
        return $data->delete($uuid);
    }
}
