<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    public function __construct(protected $service)
    {
        $this->middleware('auth:sanctum')->except(['index']);
    }

    public function index()
    {
        return $this->getAllResourcePayload($this->service->getAll(), true);
    }

    public function store(Request $request)
    {
        $this->authorize('admin');
        
        $validatedData = $this->validate($request, $this->service->getInsertRules());
        $resource = $this->service->add($validatedData);
        
        return $this->getAllResourcePayload($resource);
    }

    public function show(int $id)
    {
        return $this->getAllResourcePayload($this->service->getById($id));
    }

    public function update(Request $request, int $id)
    {
        $this->authorize('admin');
        
        $validatedData = $this->validate($request, $this->service->getUpdateRules());
        $resource = $this->service->update($validatedData, $id);
        
        return $this->getAllResourcePayload($resource);
    }

    public function destroy(int $id)
    {
        $this->service->remove($id);
        return response()->json(null, 204);
    }

    protected function getAllResourcePayload($data, bool $collection = false)
    {
        if ($collection) {
            return $this->service->getResource()::collection($data);
        }
        
        return new $this->service->getResource($data);
    }
}
