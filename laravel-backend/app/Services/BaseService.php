<?php

namespace App\Services;

use App\Http\Requests\SearchObjects\BaseSearchObject;
use App\Services\Contracts\BaseServiceInterface;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

abstract class BaseService implements BaseServiceInterface
{
    abstract protected function getModelClass();
    abstract function getInsertRequestClass();
    abstract function getUpdateRequestClass();


    public function getPageable($searchObject)
    {
        $query = $this->getModelClass()->query();

        $query = $this->includeRelation($searchObject, $query);
        $query = $this->addFilter($searchObject, $query);

        return $query->paginate($searchObject->size);
    }


    public function getById(int $id, $searchObject)
    {
        $query = $this->getModelClass()->query();
        $query = $this->includeRelation($searchObject, $query);
        $result = $query->find($id);

        if (!$result) {
            throw new Exception("Error!");
        }

        return $result;
    }

    public function add(Request $request)
    {
        $this->validateRequest($request, $this->getInsertRequestClass());
        return $this->getModelInstance()->create($request->all());
    }

    public function update(Request $request, int $id)
    {
        $this->validateRequest($request, $this->getUpdateRequestClass());
        $model = $this->getModelInstance()->find($id);

        if (!$model) {
            throw new Exception("Error!");
        }

        $model->update($request->all());

        return $model;
    }

    public function remove(int $id)
    {
        $model = $this->getModelInstance()->find($id);

        if (!$model) {
            throw new Exception("Error!");
        }

        $model->delete();

        return $model;
    }

    public function addFilter($searchObject, Builder $query)
    {
        return $query;
    }

    public function getSearchObject($params)
    {
        return new BaseSearchObject($params);
    }

    public function includeRelation($searchObject, Builder $query)
    {
        return $query;
    }

    protected function getModelInstance(): Model
    {
        $modelClass = $this->getModelClass();

        return new $modelClass;
    }

    public function validateRequest(Request $request, $formRequest)
    {
        $formRequestInstance = new $formRequest();
        $rules = $formRequestInstance->rules();
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new Exception("Error");
        }
        return $validator->validated();
    }
}
