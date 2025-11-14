@extends('layouts.dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Empleados</h1>
        <div class="d-flex gap-2">
            <form id="deleteMultipleForm" method="POST" action="{{ route('employees.destroy-multiple') }}">
                @csrf
                <button type="button" class="btn btn-outline-secondary" id="deleteSelected" disabled>
                    <i class="fas fa-trash-alt"></i> Borrar selección
                </button>
            </form>
            <a href="#" onclick="openEmployeeModal()" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Empleado
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <!-- Encabezado de la lista -->
            <div class="d-flex align-items-center p-3 border-bottom bg-light">
                <div class="form-check me-3">
                    <input class="form-check-input" type="checkbox" id="selectAll">
                </div>
                <div class="d-flex flex-fill">
                    <div class="fw-bold" style="width: 25%;">Nombre</div>
                    <div class="fw-bold" style="width: 15%;">Identificación</div>
                    <div class="fw-bold" style="width: 25%;">Dirección</div>
                    <div class="fw-bold" style="width: 15%;">Teléfono</div>
                    <div class="fw-bold" style="width: 10%;">País</div>
                    <div class="fw-bold" style="width: 10%;">Ciudad</div>
                    <div class="fw-bold text-center" style="width: 10%;">Acciones</div>
                </div>
            </div>

            <!-- Lista de empleados -->
            <div class="list-group list-group-flush">
                @forelse($employees as $employee)
                    <div class="list-group-item p-3">
                        <div class="d-flex align-items-center">
                            <div class="form-check me-3">
                                <input class="form-check-input employee-checkbox" type="checkbox"
                                    value="{{ $employee->id }}">
                            </div>
                            <div class="d-flex flex-fill">
                                <div style="width: 25%;">{{ $employee->full_name }}</div>
                                <div style="width: 15%;">{{ $employee->identification }}</div>
                                <div style="width: 25%;">{{ $employee->address ?? 'N/A' }}</div>
                                <div style="width: 15%;">{{ $employee->phone }}</div>
                                <div style="width: 10%;">
                                    {{ $employee->country->name ?? ($employee->birthplace->country->name ?? 'N/A') }}</div>
                                <div style="width: 10%;">{{ $employee->birthplace->name ?? 'N/A' }}</div>
                                <div class="text-center" style="width: 10%;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-warning"
                                            onclick="openEditEmployeeModal('{{ $employee->id }}', {{ json_encode($employee) }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('employees.destroy', $employee) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('¿Estás seguro?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="list-group-item p-3 text-center">
                        No hay empleados registrados
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @if ($employees->count())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Mostrando {{ $employees->firstItem() }} - {{ $employees->lastItem() }} de {{ $employees->total() }}
                registros
            </div>
            <div>
                {{ $employees->links() }}
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const employeeCheckboxes = document.querySelectorAll('.employee-checkbox');
            const deleteSelectedBtn = document.getElementById('deleteSelected');
            const deleteMultipleForm = document.getElementById('deleteMultipleForm');

            selectAll.addEventListener('change', function() {
                employeeCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
                updateDeleteButton();
            });

            employeeCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(employeeCheckboxes).every(cb => cb.checked);
                    selectAll.checked = allChecked;
                    updateDeleteButton();
                });
            });

            function updateDeleteButton() {
                const anyChecked = Array.from(employeeCheckboxes).some(cb => cb.checked);
                deleteSelectedBtn.disabled = !anyChecked;
            }

            deleteSelectedBtn.addEventListener('click', function() {
                const selectedIds = Array.from(employeeCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (selectedIds.length > 0 && confirm(
                        '¿Estás seguro de que quieres eliminar los ' + selectedIds.length +
                        ' empleados seleccionados?')) {

                    selectedIds.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = id;
                        deleteMultipleForm.appendChild(input);
                    });

                    deleteMultipleForm.submit();
                }
            });
        });
    </script>
@endsection
@include('employees.form')
