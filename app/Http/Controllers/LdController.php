<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ld;

class LdController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        LD::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect('/');
    }
}
