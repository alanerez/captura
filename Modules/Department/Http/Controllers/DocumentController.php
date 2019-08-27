<?php

namespace Modules\Department\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        return response()->download(storage_path("{$request->link}"));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request, $id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request, $id)
    {
        //
    }
}
