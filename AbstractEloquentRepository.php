<?php
/**
 * Part of the Laradic packages.
 * MIT License and copyright information bundled with this package in the LICENSE file.
 *
 * @author      Robin Radic
 * @license     MIT
 * @copyright   2011-2015, Robin Radic
 * @link        http://radic.mit-license.org
 */
namespace Laradic\Support;

use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractEloquentRepository
 *
 * @package     Laradic\Support
 * @property \Illuminate\Database\Eloquent\Model $model
 */
abstract class AbstractEloquentRepository
{

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    /**
     * Instantiates the class
     *
     * @param string $model
     */
    public function __construct($model = null)
    {
        if(!is_null($model))
        {
            $this->model = $model;
        }
    }

    /**
     * createModel
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function createModel()
    {
        if(!isset($this->model)){
            throw new Exception("Could not create model, the model class is not set");
        } elseif($this->model instanceof Model)
        {
            return $this->model;
        }
        $class = '\\'.ltrim($this->model, '\\');

        return new $class;
    }

    /**
     * Return all users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        $this->createModel()->getConnection()->all();
    }

    /**
     * Make a new instance of the entity to query on
     *
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function make(array $with = array())
    {
        return $this->createModel()->with($with);
    }

    /**
     * Find an entity by id
     *
     * @param int   $id
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getById($id, array $with = array())
    {
        $query = $this->make($with);

        return $query->find($id);
    }

    /**
     * Find a single entity by key value
     *
     * @param string $key
     * @param string $value
     * @param array  $with
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getFirstBy($key, $value, array $with = array())
    {
        return $this->make($with)->where($key, '=', $value)->first();
    }

    /**
     * Find many entities by key value
     *
     * @param string $key
     * @param string $value
     * @param array  $with
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getManyBy($key, $value, array $with = array())
    {
        return $this->make($with)->where($key, '=', $value)->get();
    }


    /**
     * Get Results by Page
     *
     * @param int   $page
     * @param int   $limit
     * @param array $with
     * @return \StdClass Object with $items and $totalItems for pagination
     */
    public function getByPage($page = 1, $limit = 10, $with = array())
    {
        $result             = new \StdClass;
        $result->page       = $page;
        $result->limit      = $limit;
        $result->totalItems = 0;
        $result->items      = array();

        $query = $this->make($with);

        $model = $query->skip($limit * ($page - 1))
            ->take($limit)
            ->get();

        $result->totalItems = $this->createModel()->count();
        $result->items      = $model->all();

        return $result;
    }

    /**
     * Return all results that have a required relationship
     *
     * @param string $relation
     * @param array  $with
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function has($relation, array $with = array())
    {
        $entity = $this->make($with);

        return $entity->has($relation)->all();
    }


    /**
     * Get the value of model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Sets the value of model
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }
}
