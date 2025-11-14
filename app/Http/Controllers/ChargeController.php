<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Employee;
use App\Models\EmployeeCharge;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChargeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $employeeCharges = EmployeeCharge::with(['employee', 'charge', 'boss'])
            ->latest()
            ->paginate(10);

        $charges = Charge::all();

        $bossEmployees = Employee::whereHas('charges', function ($query) {
            $query->where('name', 'ilike', '%jefe%');
        })->get();

        return view('charges.index', compact('employeeCharges', 'charges', 'bossEmployees'));
    }

    public function create(): View
    {
        $charges = Charge::all();

        $bossEmployees = Employee::whereHas('charges', function ($query) {
            $query->where('name', 'ilike', '%jefe%');
        })->get();

        return view('charges.create', compact('charges', 'bossEmployees'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_identification' => 'required|string|exists:employee,identification',
            'charge_id' => 'required|exists:charge,id',
            'area' => 'required|string|max:100',
            'start_date' => 'required|date',
            'boss_id' => 'nullable|exists:employee,id'
        ]);

        $employee = Employee::where('identification', $validated['employee_identification'])->first();

        EmployeeCharge::create([
            'employee_id' => $employee->id,
            'charge_id' => $validated['charge_id'],
            'area' => $validated['area'],
            'start_date' => $validated['start_date'],
            'boss_id' => $validated['boss_id'],
            'active' => true
        ]);

        return redirect()->route('charges.index')
            ->with('success', 'Cargo asignado exitosamente.');
    }

    public function show(Charge $charge): View
    {
        $charge->load('employees');
        return view('charges.show', compact('charge'));
    }

    public function edit(Charge $charge): View
    {
        return view('charges.edit', compact('charge'));
    }

    public function update(Request $request, Charge $charge): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $charge->update($validated);

        return redirect()->route('charges.index')
            ->with('success', 'Cargo actualizado exitosamente.');
    }

    public function destroy(EmployeeCharge $employeeCharge): RedirectResponse
    {
        $employeeCharge->delete();

        return redirect()->route('charges.index')
            ->with('success', 'Asignación eliminada exitosamente.');
    }

    public function findEmployee($identification)
    {
        $employee = Employee::where('identification', $identification)->first();

        if ($employee) {
            return response()->json([
                'exists' => true,
                'employee' => [
                    'id' => $employee->id,
                    'name' => $employee->name . ' ' . $employee->lastname,
                    'full_name' => $employee->name . ' ' . $employee->lastname
                ]
            ]);
        }

        return response()->json(['exists' => false]);
    }

    public function destroyMultiple(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|uuid|exists:employee_charge,id'
        ]);

        try {
            EmployeeCharge::whereIn('id', $request->ids)->delete();

            return redirect()->route('charges.index')
                ->with('success', 'Asignaciones seleccionadas eliminadas exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('charges.index')
                ->with('error', 'Error al eliminar las asignaciones: ' . $e->getMessage());
        }
    }

    public function editAssignment(EmployeeCharge $employeeCharge): View
    {
        $employeeCharge->load(['employee', 'charge', 'boss']);

        $charges = Charge::all();
        $bossEmployees = Employee::whereHas('charges', function ($query) {
            $query->where('name', 'ilike', '%jefe%');
        })->get();

        return view('charges.edit', compact('employeeCharge', 'charges', 'bossEmployees'));
    }

    public function updateAssignment(Request $request, EmployeeCharge $employeeCharge): RedirectResponse
    {
        $validated = $request->validate([
            'area' => 'required|string|max:100',
            'charge_id' => 'required|exists:charge,id',
            'start_date' => 'required|date',
            'boss_id' => 'nullable|exists:employee,id'
        ]);

        $employeeCharge->update([
            'charge_id' => $validated['charge_id'],
            'area' => $validated['area'],
            'start_date' => $validated['start_date'],
            'boss_id' => $validated['boss_id'],
        ]);

        return redirect()->route('charges.index')
            ->with('success', 'Asignación actualizada exitosamente.');
    }
}
