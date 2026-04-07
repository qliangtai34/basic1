<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Element;
use App\Models\Category;


class ElementController extends Controller
{
    public function index(Request $request)
{
    $query = Element::with('categories');

    if ($request->filled('keyword')) {
        $query->where('name', 'like', '%' . $request->keyword . '%');
    }

    if ($request->filled('c')) {
        $query->whereHas('categories', function ($q) use ($request) {
            $q->where('categories.id', $request->c);
        });
    }

    $elements = $query->get();
    $categories = Category::all();

    return view('index', compact('elements', 'categories'));
}
}