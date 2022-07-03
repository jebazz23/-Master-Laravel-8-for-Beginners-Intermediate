<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class AboutController extends Controller
{
    public Function __invoke()
    {
        return 'Single';
    }
}
