<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('region', 'like', "%{$search}%");
            });
        }

        // Filter by region
        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $customers = $query->orderBy('name')->paginate(15);

        // Get unique regions for filter as a flat list of strings
        $regions = Customer::query()
            ->whereNotNull('region')
            ->where('region', '!=', '')
            ->distinct()
            ->orderBy('region')
            ->pluck('region')
            ->toArray();

        return view('crm.customers.index', compact('customers', 'regions'));
    }

    public function show(Customer $customer)
    {
        // Load related data for the customer
        $customer->load(['quotations', 'indents', 'debitNotes']);

        return view('crm.customers.show', compact('customer'));
    }
}
