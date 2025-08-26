<?php

namespace App\Http\Controllers;

use App\Models\DataBankRecord;
use Illuminate\Http\Request;

class DataBankController extends Controller
{
    public function index(Request $request)
    {
        $query = DataBankRecord::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                    ->orWhere('principal_name', 'like', "%{$search}%")
                    ->orWhere('region', 'like', "%{$search}%")
                    ->orWhereJsonContains('aliases', $search);
            });
        }

        // Filters
        if ($request->filled('category')) {
            $query->where('product_name', 'like', "%{$request->category}%");
        }

        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }

        if ($request->filled('price_min')) {
            $query->where('price_usd', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price_usd', '<=', $request->price_max);
        }

        if ($request->filled('reliability')) {
            $query->where('reliability_score', '>=', $request->reliability);
        }

        $records = $query->where('active', true)
            ->orderBy('reliability_score', 'desc')
            ->orderBy('year', 'desc')
            ->paginate(20);

        // Get unique regions for filter
        $regions = DataBankRecord::distinct()->pluck('region')->sort();

        return view('data-bank.index', compact('records', 'regions'));
    }
}
