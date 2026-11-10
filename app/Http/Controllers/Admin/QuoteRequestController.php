<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;

class QuoteRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $search = $request->search;

        $quotes = QuoteRequest::query()
            ->when($status && $status != 'all', function ($q) use ($status) {
                return $q->where('status', $status);
            })
            ->when($search, function ($q) use ($search) {
                return $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%")
                        ->orWhere('category', 'like', "%$search%")
                        ->orWhere('client_type', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $pageTitle = 'Quote Requests & Leads';
        $pendingCount = QuoteRequest::where('status', 'pending')->count();

        return view('admin.quote_requests.index', compact('quotes', 'pageTitle', 'pendingCount'));
    }

    public function detail($id)
    {
        $quote = QuoteRequest::findOrFail($id);
        $pageTitle = 'Quote Request #' . $quote->id . ' - ' . $quote->name;

        return view('admin.quote_requests.detail', compact('quote', 'pageTitle'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,completed,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $quote = QuoteRequest::findOrFail($id);
        $quote->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        $notify[] = ['success', 'Quote request updated successfully'];
        return back()->withNotify($notify);
    }

    public function destroy($id)
    {
        $quote = QuoteRequest::findOrFail($id);
        $quote->delete();

        $notify[] = ['success', 'Quote request deleted successfully'];
        return to_route('admin.quote_request.index')->withNotify($notify);
    }
}

