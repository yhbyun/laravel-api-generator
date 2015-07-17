<?php namespace App\Libraries\Repositories;

use App\Exceptions\ResourceNotFoundException;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepo implements BaseRepoInterface
{
    /**
     * The model to execute queries on.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create a new repository instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $model The model to execute queries on
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get a new instance of the model.
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getNew(array $attributes = array())
    {
        return $this->model->newInstance($attributes);
    }

    /**
     * Make a new instance of the entity to query on
     *
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function make(array $with = array())
    {
        return $this->model->with($with);
    }

    /**
     * Retrieve all entities
     *
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(array $with = array())
    {
        $entity = $this->make($with);
        return $entity->get();
    }

    /**
     * Retrieves all entities including soft deleted
     *
     * @param array $with
     * @return mixed
     */
    public function allWithTrashed(array $with = array())
    {
        $entity = $this->make($with);

        return $entity->withTrashed()->get();
    }

    /**
     * Retrieves all entities paginated
     *
     * @param array $with
     * @param int $perPage
     * @return \Illuminate\Pagination\Paginator
     */
    public function allPaginated(array $with = array(), $perPage = 20)
    {
        $entity = $this->make($with);

        return $entity->paginate($perPage);
    }

    /**
     * Find a single entity
     *
     * composite primary key인 경우 $id는 array
     *  - MemberOption::scopeCompositeKey
     *
     * @param $id
     * @param array $with
     * @return Illuminate\Database\Eloquent\Model
     */
    public function find($id, array $with = array())
    {
        $entity = $this->make($with);

        if (is_array($id)) {
            $model = $entity->compositeKey($id)->first();
        } else {
            $model = $entity->find($id);
        }

        return $model;
    }

    public function findWithTrashed($id, array $with = array())
    {
        $entity = $this->make($with);

        if (is_array($id)) {
            $model = $entity->compositeKey($id)->withTrashed()->first();
        } else {
            $model = $entity->withTrashed()->find($id);
        }

        return $model;
    }

    /**
     * Search for many results by key and value
     *
     * @param string $key
     * @param mixed $value
     * @param array $with
     * @return Illuminate\Database\Query\Builders
     */
    public function getBy($key, $value, array $with = array())
    {
        return $this->make($with)->where($key, '=', $value)->get();
    }

    public function create(array $input)
    {
        return $this->model->create($input);
    }

    public function update($id, array $input)
    {
        $model = $this->model->find($id);

        if (!$model) {
            throw new ResourceNotFoundException;
        }

        return $model->update($input);
    }

    public function delete($id)
    {
        $model = $this->model->find($id);

        if (!$model) {
            throw new ResourceNotFoundException;
        }

        return $model->delete();
    }

    public function restore($id)
    {
        return $this->model->onlyTrashed()->find($id)->restore();
    }
}
