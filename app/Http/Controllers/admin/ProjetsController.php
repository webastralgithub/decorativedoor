<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjetsController extends Controller
{
    public function index()
    {
        return view("admin.projets.index");
    }
    public function projets_prv()
    {
        return view("admin.projets.projet_prv");
    }
}
