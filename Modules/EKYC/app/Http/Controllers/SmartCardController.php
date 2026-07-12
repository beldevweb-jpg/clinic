<?php

namespace Modules\EKYC\Http\Controllers;

use Illuminate\Http\Request;
use Modules\EKYC\Services\SmartCardService;

class SmartCardController
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
