<?php

namespace App\Http\Controllers;

use App\Traits\ProductTraits;
use App\Traits\SlugTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class MainController extends Controller
{
    use ProductTraits,SlugTraits;
}
