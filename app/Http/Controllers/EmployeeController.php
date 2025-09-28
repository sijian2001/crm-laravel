<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Store;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $store_id = $request->get('store_id');
        $position = $request->get('position');
        $status = $request->get('status');

        $employees = Employee::with('store')
            ->when($search, function ($query, $search) {
                return $query->search($search);
            })
            ->when($store_id, function ($query, $store_id) {
                return $query->byStore($store_id);
            })
            ->when($position, function ($query, $position) {
                return $query->byPosition($position);
            })
            ->when($status, function ($query, $status) {
                return $query->byStatus($status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stores = Store::orderBy('name')->get();

        $positions = [
            'manager' => '店長',
            'assistant_manager' => '副店長',
            'supervisor' => '主任',
            'senior_staff' => '主任スタッフ',
            'staff' => 'スタッフ',
            'trainee' => '研修生',
        ];

        $statuses = [
            'active' => '在職中',
            'inactive' => '休職中',
            'on_leave' => '休暇中',
            'terminated' => '退職済み',
        ];

        return view('employees.index', compact('employees', 'stores', 'positions', 'statuses', 'search', 'store_id', 'position', 'status'));
    }

    public function create()
    {
        $stores = Store::orderBy('name')->get();
        return view('employees.create', compact('stores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'first_name_kana' => 'required|string|max:255',
            'last_name_kana' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date|before:today',
            'hire_date' => 'required|date',
            'termination_date' => 'nullable|date|after:hire_date',
            'employment_type' => 'required|in:full_time,part_time,contract,temporary',
            'position' => 'required|in:manager,assistant_manager,supervisor,senior_staff,staff,trainee',
            'salary' => 'nullable|numeric|min:0',
            'hourly_wage' => 'nullable|numeric|min:0',
            'department' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,on_leave,terminated',
            'store_id' => 'required|exists:stores,id',
            'notes' => 'nullable|string',
        ]);

        Employee::create($request->all());

        return redirect()
            ->route('employees.index')
            ->with('success', '店員が正常に登録されました。');
    }

    public function show(Employee $employee)
    {
        $employee->load('store');
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $stores = Store::orderBy('name')->get();
        return view('employees.edit', compact('employee', 'stores'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'first_name_kana' => 'required|string|max:255',
            'last_name_kana' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date|before:today',
            'hire_date' => 'required|date',
            'termination_date' => 'nullable|date|after:hire_date',
            'employment_type' => 'required|in:full_time,part_time,contract,temporary',
            'position' => 'required|in:manager,assistant_manager,supervisor,senior_staff,staff,trainee',
            'salary' => 'nullable|numeric|min:0',
            'hourly_wage' => 'nullable|numeric|min:0',
            'department' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,on_leave,terminated',
            'store_id' => 'required|exists:stores,id',
            'notes' => 'nullable|string',
        ]);

        $employee->update($request->all());

        return redirect()
            ->route('employees.show', $employee)
            ->with('success', '店員情報が正常に更新されました。');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', '店員が正常に削除されました。');
    }
}
