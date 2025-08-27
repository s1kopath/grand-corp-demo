<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('uom', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Load relationships and get counts
        $products = $query->with(['principals', 'quotationItems'])
            ->orderBy('name')
            ->paginate(15);

        // Get unique categories for filter
        $categories = Product::distinct()->pluck('category')->sort();

        return view('crm.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        // Load related data for the product
        $product->load(['principals', 'quotationItems']);

        return view('crm.products.show', compact('product'));
    }
}
