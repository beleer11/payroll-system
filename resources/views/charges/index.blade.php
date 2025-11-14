@extends('layouts.dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Asignaciones de Cargos</h1>
        <div class="d-flex gap-2">
            <form id="deleteMultipleChargesForm" method="POST" action="{{ route('charges.destroy-multiple') }}">
                @csrf
                <button type="button" class="btn btn-outline-secondary" id="deleteSelectedCharges" disabled>
                    <i class="fas fa-trash-alt"></i> Borrar selección
                </button>
            </form>
            <a href="#" onclick="openChargeAssignmentModal()" class="btn btn-primary">
                <i class="fas fa-plus"></i> Asignar Cargo
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <!-- Encabezado de la lista -->
            <div class="d-flex align-items-center p-3 border-bottom bg-light">
                <div class="form-check me-3">
                    <input class="form-check-input" type="checkbox" id="selectAllCharges">
                </div>
                <div class="d-flex flex-fill">
                    <div class="fw-bold" style="width: 20%;">Empleado</div>
                    <div class="fw-bold" style="width: 15%;">Identificación</div>
                    <div class="fw-bold" style="width: 15%;">Cargo</div>
                    <div class="fw-bold" style="width: 15%;">Área</div>
                    <div class="fw-bold" style="width: 10%;">Fecha Inicio</div>
                    <div class="fw-bold" style="width: 15%;">Jefe</div>
                    <div class="fw-bold" style="width: 5%;">Estado</div>
                    <div class="fw-bold text-center" style="width: 5%;">Acciones</div>
                </div>
            </div>

            <!-- Lista de asignaciones de cargos -->
            <div class="list-group list-group-flush">
                @forelse($employeeCharges as $assignment)
                    <div class="list-group-item p-3">
                        <div class="d-flex align-items-center">
                            <div class="form-check me-3">
                                <input class="form-check-input charge-checkbox" type="checkbox"
                                    value="{{ $assignment->id }}">
                            </div>
                            <div class="d-flex flex-fill">
                                <div style="width: 20%;">{{ $assignment->employee->name }}
                                    {{ $assignment->employee->lastname }}</div>
                                <div style="width: 15%;">{{ $assignment->employee->identification }}</div>
                                <div style="width: 15%;">{{ $assignment->charge->name }}</div>
                                <div style="width: 15%;">{{ $assignment->area }}</div>
                                <div style="width: 10%;">{{ $assignment->start_date->format('d/m/Y') }}</div>
                                <div style="width: 15%;">
                                    @if ($assignment->boss)
                                        {{ $assignment->boss->name }} {{ $assignment->boss->lastname }}
                                        @php
                                            $bossCurrentCharge = $assignment->boss->currentCharge();
                                        @endphp
                                        @if ($bossCurrentCharge)
                                            <br><small class="text-muted">{{ $bossCurrentCharge->name }}</small>
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div style="width: 5%;">
                                    <span class="badge {{ $assignment->active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $assignment->active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                                <div class="text-center" style="width: 5%;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-warning"
                                            onclick="openEditChargeAssignmentModal('{{ $assignment->id }}', {{ json_encode([
                                                'employee_id' => $assignment->employee->id,
                                                'employee_identification' => $assignment->employee->identification,
                                                'employee_name' => $assignment->employee->name . ' ' . $assignment->employee->lastname,
                                                'employee' => $assignment->employee,
                                                'charge_id' => $assignment->charge->id,
                                                'charge' => $assignment->charge,
                                                'area' => $assignment->area,
                                                'start_date' => $assignment->start_date->format('Y-m-d'),
                                                'boss_id' => $assignment->boss_id,
                                                'boss' => $assignment->boss,
                                            ]) }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('employee-charges.destroy', $assignment) }}" method="POST"
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
                        No hay asignaciones de cargos registradas
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @if ($employeeCharges->count())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Mostrando {{ $employeeCharges->firstItem() }} - {{ $employeeCharges->lastItem() }} de
                {{ $employeeCharges->total() }} registros
            </div>
            <div>
                {{ $employeeCharges->links() }}
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCharges = document.getElementById('selectAllCharges');
            const chargeCheckboxes = document.querySelectorAll('.charge-checkbox');
            const deleteSelectedChargesBtn = document.getElementById('deleteSelectedCharges');
            const deleteMultipleChargesForm = document.getElementById('deleteMultipleChargesForm');

            selectAllCharges.addEventListener('change', function() {
                chargeCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCharges.checked;
                });
                updateDeleteChargesButton();
            });

            chargeCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(chargeCheckboxes).every(cb => cb.checked);
                    selectAllCharges.checked = allChecked;
                    updateDeleteChargesButton();
                });
            });

            function updateDeleteChargesButton() {
                const anyChecked = Array.from(chargeCheckboxes).some(cb => cb.checked);
                deleteSelectedChargesBtn.disabled = !anyChecked;
            }

            deleteSelectedChargesBtn.addEventListener('click', function() {
                const selectedIds = Array.from(chargeCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (selectedIds.length > 0 && confirm(
                        '¿Estás seguro de que quieres eliminar las ' + selectedIds.length +
                        ' asignaciones seleccionadas?')) {

                    selectedIds.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = id;
                        deleteMultipleChargesForm.appendChild(input);
                    });

                    deleteMultipleChargesForm.submit();
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const chargeAssignmentModal = document.getElementById('chargeAssignmentModal');

            chargeAssignmentModal.addEventListener('hidden.bs.modal', function() {
                if (window.location.search.includes('success')) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            });

            const chargeAssignmentForm = document.getElementById('chargeAssignmentForm');
            chargeAssignmentForm.addEventListener('submit', function(e) {});
        });

        function refreshTable() {
            window.location.reload();
        }
    </script>
@endsection

@include('charges.form')
