<?php

namespace App\Services;

class BranchService
{
    public static function current()
    {
        return auth()->user()?->branch;
    }
}