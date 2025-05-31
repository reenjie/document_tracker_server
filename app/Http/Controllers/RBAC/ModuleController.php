<?php

namespace App\Http\Controllers\RBAC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Modules\StoreRequest;
use App\Http\Requests\Modules\UpdateRequest;
use App\Models\Modules;
use Illuminate\Validation\ValidationException;


class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $modules = Modules::orderBy("name", "desc")->get();
        return response()->json(['message' => 'List of modules', 'data' => $modules]);
    }
    public function store(StoreRequest $StoreRequest)
    {
        $module_Created = Modules::create($StoreRequest->all());
        if ($module_Created) {
            return response()->json(['message' => 'Module created successfully', 'data' => $module_Created], 201);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $module = Modules::find($id);
        if (!$module) {
            return response()->json(['message' => 'Module not found'], 404);
        }
        return response()->json(['message' => 'Module details retrieved', 'data' => $module]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $UpdateRequest, string $id)
    {
        $module = Modules::find($id);
        if (!$module) {
            return response()->json(['message' => 'Module not found.'], 404);
        }
        $module->update($UpdateRequest->all());
        return response()->json([
            'message' => 'Module updated successfully',
            'data' => $module
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $module = Modules::find($id);
        if (!$module) {
            return response()->json(['message' => 'Module not found.'], 404);
        }
        $module->delete();
        return response()->json([
            'message' => 'Module deleted successfully',
            'data' => $module
        ], 200);
    }
}
