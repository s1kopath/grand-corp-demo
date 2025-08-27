<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $query = Quotation::with(['customer', 'items']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('quotation_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('company', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('quotation_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('quotation_date', '<=', $request->date_to);
        }

        $quotations = $query->orderBy('quotation_date', 'desc')->paginate(15);

        return view('quotations.index', compact('quotations'));
    }

    public function show(Quotation $quotation)
    {
        // Load related data for the quotation
        $quotation->load(['customer', 'items.product', 'items.principal']);

        return view('quotations.show', compact('quotation'));
    }

    public function goToIndent(Quotation $quotation)
    {
        // This is a demo method that navigates to the indent workflow
        // In a real application, this would create an indent from the quotation

        // Find the first indent for demo purposes
        $indent = $quotation->indents->first();

        if ($indent) {
            return redirect()->route('indents.show', $indent)
                ->with('success', 'Navigated to Indent from Quotation #' . $quotation->quotation_number);
        }

        // If no indent exists, redirect to indents index
        return redirect()->route('indents.index')
            ->with('info', 'No indent found for Quotation #' . $quotation->quotation_number . '. Please create one.');
    }
}
