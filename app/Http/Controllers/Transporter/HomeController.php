<?php

namespace App\Http\Controllers\Transporter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'feature']);
    }

    public function index()
    {
        return view('transporter.home.index');
    }
}
