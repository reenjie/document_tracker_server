<?php

namespace App\Http\Controllers\RBAC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Modules\StoreRequest;
use App\Models\Modules;
use Illuminate\Validation\ValidationException;


class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json(['message' => 'List of modules']);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
