<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return view("admin.clients.index");
    }
    public function clients_prv()
    {
        return view("admin.clients.client_prv");
    }
}
