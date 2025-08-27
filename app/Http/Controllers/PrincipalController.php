<?php

namespace App\Http\Controllers;

use App\Models\Principal;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    public function index(Request $request)
    {
        $query = Principal::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }

        // Filter by country
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $principals = $query->orderBy('name')->paginate(15);
        
        // Get unique countries for filter
        $countries = Principal::distinct()->pluck('country')->sort();
        
        return view('crm.principals.index', compact('principals', 'countries'));
    }

    public function show(Principal $principal)
    {
        // Load related data for the principal
        $principal->load(['products', 'quotations', 'indents']);
        
        return view('crm.principals.show', compact('principal'));
    }
}
