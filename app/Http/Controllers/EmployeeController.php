<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Charge;
use App\Models\Country;
use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $employees = Employee::with(['birthplace.country', 'charges', 'boss'])
            ->latest()
            ->paginate(10);

        $countries = Country::all();

        return view('employees.index', compact('employees', 'countries'));
    }

    public function create(): View
    {
        $countries = Country::all();
        $charges = Charge::all();
        $employees = Employee::all();

        return view('employees.create', compact('countries', 'charges', 'employees'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'identification' => 'required|string|max:20|unique:employee,identification',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'country_id' => 'required|exists:country,id',
            'birthplace_id' => 'required|exists:city,id',
        ]);

        $employee = Employee::create([
            'name' => $validated['name'],
            'lastname' => $validated['lastname'],
            'identification' => $validated['identification'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'birthplace_id' => $validated['birthplace_id'],
            'country_id' => $validated['country_id'],
        ]);

        $employee->charges()->attach($request->charges, [
            'start_date' => now(),
            'active' => true
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Empleado creado exitosamente.');
    }

    public function show(Employee $employee): View
    {
        $employee->load(['birthplace.country', 'charges', 'boss', 'collaborators']);

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee): View
    {
        $countries = Country::all();
        $charges = Charge::all();
        $employees = Employee::where('id', '!=', $employee->id)->get();
        $cities = City::where('country_id', $employee->birthplace->country_id)->get();

        return view('employees.edit', compact('employee', 'countries', 'charges', 'employees', 'cities'));
    }

    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'identification' => 'required|string|max:20|unique:employee,identification,' . $employee->id,
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'country_id' => 'required|exists:country,id',
            'birthplace_id' => 'required|exists:city,id'
        ]);

        $employee->update([
            'name' => $validated['name'],
            'lastname' => $validated['lastname'],
            'identification' => $validated['identification'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'birthplace_id' => $validated['birthplace_id'],
            'country_id' => $validated['country_id'],
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Empleado actualizado exitosamente.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Empleado eliminado exitosamente.');
    }

    public function getCities($countryId)
    {
        $cities = City::where('country_id', $countryId)->get();
        return response()->json($cities);
    }

    public function destroyMultiple(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|uuid|exists:employee,id'
        ]);

        try {
            Employee::whereIn('id', $request->ids)->delete();

            return redirect()->route('employees.index')
                ->with('success', 'Empleados seleccionados eliminados exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')
                ->with('error', 'Error al eliminar los empleados: ' . $e->getMessage());
        }
    }
}
