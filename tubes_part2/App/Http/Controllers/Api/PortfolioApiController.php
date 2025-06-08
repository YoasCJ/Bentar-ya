<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfolio;

class PortfolioApiController extends Controller
{
    public function index()
    {
        return response()->json(Portfolio::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'link' => 'nullable|string',
            'file_path' => 'nullable|string'
        ]);

        $portfolio = Portfolio::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'file_path' => $request->file_path,
        ]);

        return response()->json($portfolio, 201);
    }

    public function show($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return response()->json($portfolio);
    }
}