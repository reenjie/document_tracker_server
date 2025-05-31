<?php

namespace App\Http\Controllers\RBAC;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Http\Requests\Permissions\StoreRequest;
//use App\Http\Requests\Permissions\UpdateRequest;
class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        return response()->json(['message' => 'List of permissions', 'data' => $permissions]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $storeRequest)
    {
        $permission = Permission::create($storeRequest->all());
        return response()->json(['message' => 'Permission created successfully', 'data' => $permission], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return response()->json(['message' => 'Permission not found'], 404);
        }
        return response()->json(['message' => 'Permission details retrieved', 'data' => $permission]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $updateRequest, string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($updateRequest->all());
        return response()->json(['message' => 'Permission updated successfully', 'data' => $permission]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return response()->json(['message' => 'Permission deleted successfully']);
    }
}
