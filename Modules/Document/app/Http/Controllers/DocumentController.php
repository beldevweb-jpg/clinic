<?php

namespace Modules\Document\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Document\Models\pt33;
use Modules\Document\Models\pt28;


class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function pt33()
    {
        $pt33 = pt33::get();
        return view('document::document.pt33');
    }

    public function pt28()
    {
        return view('document::document.pt28');
    }

    public function index()
    {
        return view('document::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('document::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    // public function show($id)
    // {
    //     return view('document::show');
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('document::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
