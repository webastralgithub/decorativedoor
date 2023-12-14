<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UtilisateursController extends Controller
{
    public function index()
    {
        return view("admin.utilisateurs.index");
    }
}
