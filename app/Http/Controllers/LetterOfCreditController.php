<?php

namespace App\Http\Controllers;

use App\Models\LetterOfCredit;
use Illuminate\Http\Request;

class LetterOfCreditController extends Controller
{
    public function index(Request $request)
    {
        $query = LetterOfCredit::with(['indent.customer']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('lc_number', 'like', "%{$search}%")
                    ->orWhere('issuing_bank', 'like', "%{$search}%")
                    ->orWhereHas('indent.customer', function ($customerQuery) use ($search) {
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
            $query->where('issue_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('issue_date', '<=', $request->date_to);
        }

        $lcs = $query->orderBy('issue_date', 'desc')->paginate(15);

        return view('lcs.index', compact('lcs'));
    }

    public function show(LetterOfCredit $lc)
    {
        // Load related data for the L/C
        $lc->load(['indent.customer', 'shipments']);

        return view('lcs.show', compact('lc'));
    }

    public function goToShipment(LetterOfCredit $lc)
    {
        // This is a demo method that navigates to the shipment workflow
        // In a real application, this would create a shipment from the L/C

        // Find the first shipment for demo purposes
        $shipment = $lc->shipments->first();

        if ($shipment) {
            return redirect()->route('shipments.show', $shipment)
                ->with('success', 'Navigated to Shipment from L/C #' . $lc->lc_number);
        }

        // If no shipment exists, redirect to shipments index
        return redirect()->route('shipments.index')
            ->with('info', 'No shipment found for L/C #' . $lc->lc_number . '. Please create one.');
    }
}
