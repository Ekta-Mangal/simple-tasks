<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Contructor
     */
    public function __construct() {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       //TODO: Implement list logic
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //TODO: Implement store logic
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //TODO: Implement show logic
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //TODO: Implement update logic
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //TODO: Implement delete logic
    }
}
