<?php

namespace App\Http\Controllers;

use App\Models\DebitNote;
use Illuminate\Http\Request;

class DebitNoteController extends Controller
{
    public function index(Request $request)
    {
        $query = DebitNote::with(['customer', 'shipment']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('debit_note_number', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%")
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
            $query->where('issue_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('issue_date', '<=', $request->date_to);
        }

        $debitNotes = $query->orderBy('issue_date', 'desc')->paginate(15);

        return view('debit-notes.index', compact('debitNotes'));
    }

    public function show(DebitNote $debitNote)
    {
        // Load related data for the debit note
        $debitNote->load(['customer', 'shipment.letterOfCredit.indent', 'accountEntries']);

        return view('debit-notes.show', compact('debitNote'));
    }
}
