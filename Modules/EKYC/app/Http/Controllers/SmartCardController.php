<?php

namespace Modules\EKYC\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\EKYC\Services\SmartCardService;

class SmartCardController extends Controller
{
    public function __construct(
        protected SmartCardService $smartCard
    ) {}



    public function status()
    {
        return response()->json(
            $this->smartCard->status()
        );
    }



    public function read()
    {
        return response()->json(
            $this->smartCard->read()
        );
    }
}
