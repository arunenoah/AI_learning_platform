<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ClaudeCodeMaterialsController extends Controller
{
    public function index(): View
    {
        return view('claude-code-materials');
    }
}
