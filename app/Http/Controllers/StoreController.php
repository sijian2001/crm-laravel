<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $stores = Store::query()
            ->when($search, function ($query, $search) {
                return $query->search($search);
            })
            ->when($status, function ($query, $status) {
                return $query->byStatus($status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $statuses = [
            'open' => '営業中',
            'closed' => '休業中',
            'preparing' => '準備中',
        ];

        return view('stores.index', compact('stores', 'search', 'status', 'statuses'));
    }

    public function create()
    {
        return view('stores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'opening_hours' => 'nullable|string',
            'closed_days' => 'nullable|string|max:255',
            'status' => 'required|in:open,closed,preparing',
            'manager_name' => 'nullable|string|max:255',
            'opening_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        Store::create($request->all());

        return redirect()
            ->route('stores.index')
            ->with('success', '店舗が正常に登録されました。');
    }

    public function show(Store $store)
    {
        return view('stores.show', compact('store'));
    }

    public function edit(Store $store)
    {
        return view('stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'opening_hours' => 'nullable|string',
            'closed_days' => 'nullable|string|max:255',
            'status' => 'required|in:open,closed,preparing',
            'manager_name' => 'nullable|string|max:255',
            'opening_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $store->update($request->all());

        return redirect()
            ->route('stores.show', $store)
            ->with('success', '店舗情報が正常に更新されました。');
    }

    public function destroy(Store $store)
    {
        $store->delete();

        return redirect()
            ->route('stores.index')
            ->with('success', '店舗が正常に削除されました。');
    }
}
