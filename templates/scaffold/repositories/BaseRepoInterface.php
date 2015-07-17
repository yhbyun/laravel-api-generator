<?php namespace App\Libraries\Repositories;

interface BaseRepoInterface
{
    public function all(array $with = array());

    public function allWithTrashed(array $with = array());

    public function allPaginated(array $with = array(), $perPage = 20);

    public function find($id, array $with = array());

    public function findWithTrashed($id, array $with = array());

    public function getBy($key, $value, array $with = array());

    public function create(array $input);

    public function update($id, array $input);

    public function delete($id);

    public function restore($id);
}
