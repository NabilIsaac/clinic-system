<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewStateController extends Controller
{
    public function updateView(Request $request)
    {
        $view = $request->input('view');
        session(['currentView' => $view]);
        return response()->json(['success' => true]);
    }
}
