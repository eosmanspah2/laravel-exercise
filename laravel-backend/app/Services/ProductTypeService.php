<?php

namespace App\Services;

use App\Http\Requests\ProductTypeCreateRequest;
use App\Http\Requests\ProductTypeUpdateRequest;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductTypeService extends BaseService
{
    public function addFilter($searchObject, $query)
    {

        return $query;
    }

    public function includeRelation($searchObject, $query)
    {

        return $query;
    }

    protected function getModelClass()
    {
        return ProductType::class;
    }

    public function getInsertRequestClass()
    {
        return ProductTypeCreateRequest::class;
    }

    public function getUpdateRequestClass()
    {
        return ProductTypeUpdateRequest::class;
    }

    public function getPageable($searchObject)
    {
        $cacheKey = $this->generateCacheKey(request()->query());
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        $all = parent::getPageable($searchObject);
        Cache::put($cacheKey, $all, now()->addMinutes(1));

        return $all;
    }

    public function add(Request $request)
    {
        $this->clearCache();
        $request['state'] = 'DRAFT';
        return parent::add($request);
    }

    public function update(Request $request, int $id)
    {
        $this->clearCache();
        return parent::update($request, $id);
    }

    public function getById(int $id, $searchObject)
    {
        $this->clearCache();
        return parent::getById($id, $searchObject);
    }

    protected function generateCacheKey($parameters)
    {
        ksort($parameters);
        return 'product_types_' . http_build_query($parameters);
    }

    public function clearCache()
    {
        $keys = Cache::getStore()->getPrefix() . 'productType;*';
        Cache::forget($keys);
    }
}
