<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Agenda;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::where('status','published')->orderBy('start_date','desc')->paginate(12);
        return view('frontend.agenda.index', compact('agendas'));
    }

    public function show(int $id)
    {
        $agenda = Agenda::where('status','published')->findOrFail($id);
        return view('frontend.agenda.show', compact('agenda'));
    }
}