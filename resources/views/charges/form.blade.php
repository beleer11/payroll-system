<div class="modal-overlay" id="chargeAssignmentModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Asignar Cargo</h3>
            <button type="button" class="modal-close" id="chargeModalClose">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="chargeAssignmentForm" method="POST" action="{{ route('charges.store') }}">
            @csrf
            <input type="hidden" id="chargeFormMethod" name="_method" value="POST">
            <input type="hidden" id="modal_employee_id" name="employee_id">

            <div class="modal-body">
                <div class="form-section">
                    <!-- Identificación y Nombre -->
                    <div class="form-row">
                        <div class="form-field">
                            <label class="form-label">Identificación *</label>
                            <input type="text"
                                class="form-control @error('employee_identification') is-invalid @enderror"
                                id="modal_employee_identification" name="employee_identification"
                                value="{{ old('employee_identification') }}"
                                placeholder="Escribe la identificación del empleado" required>
                            @error('employee_identification')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Escribe la identificación y se buscará automáticamente</div>
                        </div>

                        <div class="form-field">
                            <label class="form-label">Nombre del Empleado</label>
                            <input type="text" class="form-control" id="modal_employee_name" readonly
                                placeholder="El nombre aparecerá aquí">
                            <div id="employeeNotFound" class="text-danger mt-1" style="display: none;">
                                No se encontró un empleado con esta identificación
                            </div>
                        </div>
                    </div>

                    <!-- Área y Cargo -->
                    <div class="form-row">
                        <div class="form-field">
                            <label class="form-label">Área *</label>
                            <input type="text" class="form-control @error('area') is-invalid @enderror"
                                id="modal_area" name="area" value="{{ old('area') }}"
                                placeholder="Ej: Recursos Humanos, Tecnología, Ventas" required>
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label class="form-label">Cargo *</label>
                            <select class="form-control @error('charge_id') is-invalid @enderror" id="modal_charge_id"
                                name="charge_id" required>
                                <option value="">Selecciona un cargo</option>
                                @foreach ($charges as $charge)
                                    <option value="{{ $charge->id }}"
                                        {{ old('charge_id') == $charge->id ? 'selected' : '' }}>
                                        {{ $charge->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('charge_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Fecha Inicio y Jefe -->
                    <div class="form-row">
                        <div class="form-field">
                            <label class="form-label">Fecha de Inicio *</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                id="modal_start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}"
                                required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label class="form-label">Jefe</label>
                            <select class="form-control @error('boss_id') is-invalid @enderror" id="modal_boss_id"
                                name="boss_id">
                                <option value="">Selecciona un jefe</option>
                                @foreach ($bossEmployees as $bossEmployee)
                                    @php
                                        $currentCharge = $bossEmployee->currentCharge();
                                    @endphp
                                    <option value="{{ $bossEmployee->id }}"
                                        {{ old('boss_id') == $bossEmployee->id ? 'selected' : '' }}>
                                        {{ $bossEmployee->name }} {{ $bossEmployee->lastname }}
                                        @if ($currentCharge)
                                            - {{ $currentCharge->name }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('boss_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-modal btn-modal-cancel" id="chargeModalCancel">Cancelar</button>
                <button type="submit" class="btn-modal btn-modal-submit" id="chargeSubmitBtn">Asignar Cargo</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        const chargeAssignmentModal = document.getElementById('chargeAssignmentModal');
        const chargeAssignmentForm = document.getElementById('chargeAssignmentForm');
        const chargeFormMethod = document.getElementById('chargeFormMethod');
        const chargeModalTitle = document.querySelector('#chargeAssignmentModal .modal-title');
        const employeeIdentificationInput = document.getElementById('modal_employee_identification');
        const employeeNameInput = document.getElementById('modal_employee_name');
        const employeeIdInput = document.getElementById('modal_employee_id');

        // Abrir modal para NUEVA asignación
        function openChargeAssignmentModal() {
            chargeAssignmentForm.action = "{{ route('charges.store') }}";
            chargeFormMethod.value = 'POST';
            chargeModalTitle.textContent = 'Asignar Cargo';

            // Habilitar búsqueda para nuevo empleado
            employeeIdentificationInput.disabled = false;
            employeeIdentificationInput.placeholder = "Escribe la identificación del empleado";

            resetChargeForm();
            chargeAssignmentModal.classList.add('show');
        }

        // Abrir modal para EDITAR asignación
        function openEditChargeAssignmentModal(assignmentId, assignmentData) {
            chargeAssignmentForm.action = `/employee-charges/${assignmentId}`;
            chargeFormMethod.value = 'PUT';
            chargeModalTitle.textContent = 'Editar Asignación';

            // Deshabilitar búsqueda para edición - el empleado no se puede cambiar
            employeeIdentificationInput.disabled = true;
            employeeIdentificationInput.placeholder = "Empleado (no editable)";

            fillChargeForm(assignmentData);
            chargeAssignmentModal.classList.add('show');
        }

        // Cerrar modal y limpiar
        function closeChargeAssignmentModal() {
            chargeAssignmentModal.classList.remove('show');
            resetChargeForm();
        }

        function resetChargeForm() {
            chargeAssignmentForm.reset();
            employeeIdentificationInput.disabled = false;
            employeeIdentificationInput.placeholder = "Escribe la identificación del empleado";
            employeeNameInput.value = '';
            employeeIdInput.value = '';
            document.getElementById('employeeNotFound').style.display = 'none';
            document.getElementById('chargeSubmitBtn').disabled = false;

            // Limpiar errores
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.remove();
            });
        }

        function fillChargeForm(data) {
            // Para edición, cargar todos los datos existentes
            document.getElementById('modal_employee_identification').value = data.employee?.identification || data
                .employee_identification || '';
            document.getElementById('modal_employee_name').value = data.employee?.name + ' ' + data.employee?.lastname ||
                data.employee_name || '';
            document.getElementById('modal_employee_id').value = data.employee_id || data.employee?.id || '';
            document.getElementById('modal_area').value = data.area || '';
            document.getElementById('modal_charge_id').value = data.charge_id || data.charge?.id || '';
            document.getElementById('modal_start_date').value = data.start_date || '';
            document.getElementById('modal_boss_id').value = data.boss_id || data.boss?.id || '';
        }

        // Búsqueda de empleado por identificación (solo para nuevo)
        document.addEventListener('DOMContentLoaded', function() {
            const employeeNotFound = document.getElementById('employeeNotFound');
            const chargeSubmitBtn = document.getElementById('chargeSubmitBtn');

            employeeIdentificationInput.addEventListener('input', function() {
                // Solo buscar si el campo está habilitado (modo nuevo)
                if (!this.disabled) {
                    const identification = this.value.trim();

                    if (identification.length > 5) {
                        fetch(`/charges/find-employee/${identification}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.exists) {
                                    employeeNameInput.value = data.employee.full_name;
                                    employeeIdInput.value = data.employee.id;
                                    employeeNotFound.style.display = 'none';
                                    chargeSubmitBtn.disabled = false;
                                } else {
                                    employeeNameInput.value = '';
                                    employeeIdInput.value = '';
                                    employeeNotFound.style.display = 'block';
                                    chargeSubmitBtn.disabled = true;
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                employeeNameInput.value = '';
                                employeeIdInput.value = '';
                                employeeNotFound.style.display = 'block';
                                chargeSubmitBtn.disabled = true;
                            });
                    } else {
                        employeeNameInput.value = '';
                        employeeIdInput.value = '';
                        employeeNotFound.style.display = 'none';
                        chargeSubmitBtn.disabled = false;
                    }
                }
            });

            // Event listeners para cerrar modal
            document.getElementById('chargeModalClose').addEventListener('click', closeChargeAssignmentModal);
            document.getElementById('chargeModalCancel').addEventListener('click', closeChargeAssignmentModal);

            chargeAssignmentModal.addEventListener('click', function(e) {
                if (e.target === chargeAssignmentModal) {
                    closeChargeAssignmentModal();
                }
            });

            // Prevenir envío duplicado
            chargeAssignmentForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Asignar Cargo';
                }, 5000);
            });
        });

        // Hacer funciones globales
        window.openChargeAssignmentModal = openChargeAssignmentModal;
        window.closeChargeAssignmentModal = closeChargeAssignmentModal;
        window.openEditChargeAssignmentModal = openEditChargeAssignmentModal;
    </script>
@endpush
