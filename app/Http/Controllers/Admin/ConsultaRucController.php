<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultaRuc;
use Illuminate\View\View;

class ConsultaRucController extends Controller
{
    public function index(): View
    {
        $consultas = ConsultaRuc::latest()->paginate(30);

        return view('admin.consultas-ruc.index', compact('consultas'));
    }
}
