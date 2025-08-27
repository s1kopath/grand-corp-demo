<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipment::with(['letterOfCredit.indent.customer']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('shipment_number', 'like', "%{$search}%")
                    ->orWhere('vessel_name', 'like', "%{$search}%")
                    ->orWhere('container_number', 'like', "%{$search}%")
                    ->orWhereHas('letterOfCredit.indent.customer', function ($customerQuery) use ($search) {
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
            $query->where('etd', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('etd', '<=', $request->date_to);
        }

        $shipments = $query->orderBy('etd', 'desc')->paginate(15);

        return view('shipments.index', compact('shipments'));
    }

    public function show(Shipment $shipment)
    {
        // Load related data for the shipment
        $shipment->load(['letterOfCredit.indent.customer', 'documents', 'certificates']);

        return view('shipments.show', compact('shipment'));
    }
}
