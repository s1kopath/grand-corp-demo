<?php

namespace App\Http\Controllers;

use App\Models\Indent;
use Illuminate\Http\Request;

class IndentController extends Controller
{
    public function index(Request $request)
    {
        $query = Indent::with(['customer', 'items']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('indent_number', 'like', "%{$search}%")
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
            $query->where('indent_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('indent_date', '<=', $request->date_to);
        }

        $indents = $query->orderBy('indent_date', 'desc')->paginate(15);

        return view('indents.index', compact('indents'));
    }

    public function show(Indent $indent)
    {
        // Load related data for the indent
        $indent->load(['customer', 'items.product', 'items.principal', 'letterOfCredits']);

        return view('indents.show', compact('indent'));
    }

    public function goToLc(Indent $indent)
    {
        // This is a demo method that navigates to the L/C workflow
        // In a real application, this would create an L/C from the indent

        // Find the first L/C for demo purposes
        $lc = $indent->letterOfCredits->first();

        if ($lc) {
            return redirect()->route('lcs.show', $lc)
                ->with('success', 'Navigated to L/C from Indent #' . $indent->indent_number);
        }

        // If no L/C exists, redirect to L/Cs index
        return redirect()->route('lcs.index')
            ->with('info', 'No L/C found for Indent #' . $indent->indent_number . '. Please create one.');
    }
}
