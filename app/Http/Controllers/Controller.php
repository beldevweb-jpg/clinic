<?php

namespace App\Http\Controllers;

abstract class Controller
{

    public function test()
    {
        $pdf = app(PDFGenerator::class)->generate();

        return response($pdf)
            ->header('Content-Type', 'application/pdf');
    }
}
