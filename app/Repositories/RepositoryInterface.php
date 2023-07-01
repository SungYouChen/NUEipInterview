<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function all();

    public function getList($query);

    public function create(array $data);

    public function show($id);

    public function showByUuid($uuid);

    public function update(array $data, $uuid);

    public function delete($uuid);

}
