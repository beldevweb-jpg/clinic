<?php

namespace Modules\PDF\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pdf::index');
    }

    public function exportPdf(Request $request)
    {
        $data = $request->all();

        $pdf = Pdf::loadView(
            'pdf::pt33',
            compact('data')
        );

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('PT33.pdf');
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pdf::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('pdf::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('pdf::edit');
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
