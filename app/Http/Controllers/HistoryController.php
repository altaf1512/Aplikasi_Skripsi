<?php

namespace App\Http\Controllers;

use App\Models\ConsultationHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = ConsultationHistory::where('user_id', auth()->id())->latest()->paginate(10);
        return view('consultation.history', compact('histories'));
    }
}
