<div class="modal-overlay" id="employeeModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Nuevo empleado</h3>
            <button type="button" class="modal-close" id="modalClose">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="employeeForm" method="POST">
            @csrf
            <input type="hidden" id="formMethod" name="_method" value="POST">

            <div class="modal-body">
                <div class="form-section">
                    <div class="form-row">
                        <div class="form-field">
                            <label class="form-label">Nombres *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="modal_name" name="name" value="{{ old('name') }}"
                                placeholder="Escribe el nombre de tu empleado" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label class="form-label">Apellidos *</label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                id="modal_lastname" name="lastname" value="{{ old('lastname') }}"
                                placeholder="Escribe el apellido de tu empleado" required>
                            @error('lastname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-field">
                            <label class="form-label">Identificación *</label>
                            <input type="text" class="form-control @error('identification') is-invalid @enderror"
                                id="modal_identification" name="identification" value="{{ old('identification') }}"
                                placeholder="Escribe un número de identificación" required>
                            @error('identification')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label class="form-label">Teléfono *</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                id="modal_phone" name="phone" value="{{ old('phone') }}"
                                placeholder="Escribe un número de teléfono" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label class="form-label">País *</label>
                        <select class="form-control @error('country_id') is-invalid @enderror" id="modal_country_id"
                            name="country_id" required>
                            <option value="">Selecciona un país</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label class="form-label">Ciudad *</label>
                        <select class="form-control @error('birthplace_id') is-invalid @enderror"
                            id="modal_birthplace_id" name="birthplace_id" required>
                            <option value="">Primero selecciona un país</option>
                        </select>
                        @error('birthplace_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-field">
                        <label class="form-label">Dirección *</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="modal_address" name="address" rows="3"
                            placeholder="Escribe la dirección completa" required>{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <input type="hidden" name="boss_id" value="">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-modal btn-modal-cancel" id="modalCancel">Cancelar</button>
                <button type="submit" class="btn-modal btn-modal-submit">Ingresar</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-container {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            padding: 24px 24px 16px;
            border-bottom: 1px solid #e9ecef;
            background: #f8f9fa;
            border-radius: 12px 12px 0 0;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 20px;
            color: #6c757d;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: #e9ecef;
            color: #333;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            padding: 16px 24px 24px;
            border-top: 1px solid #e9ecef;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .form-section {
            margin-bottom: 24px;
        }

        .form-section-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #007bff;
        }

        .form-label {
            font-size: 14px;
            color: #000000;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 30px !important;
            padding: 10px 12px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
        }

        .form-control::placeholder {
            color: #6c757d;
        }

        .btn-modal {
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-modal-cancel {
            background: #6c757d;
            color: white;
        }

        .btn-modal-cancel:hover {
            background: #5a6268;
        }

        .btn-modal-submit {
            background: #007bff;
            color: white;
        }

        .btn-modal-submit:hover {
            background: #0056b3;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-field {
            display: flex;
            flex-direction: column;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .modal-container {
                width: 95%;
                margin: 20px;
            }
        }
    </style>
@endpush
@push('scripts')
    <script>
        const employeeModal = document.getElementById('employeeModal');
        const employeeForm = document.getElementById('employeeForm');
        const formMethod = document.getElementById('formMethod');
        const modalTitle = document.querySelector('.modal-title');

        function openEmployeeModal() {
            employeeForm.action = "{{ route('employees.store') }}";
            formMethod.value = 'POST';
            modalTitle.textContent = 'Nuevo empleado';
            resetForm();
            employeeModal.classList.add('show');
        }

        function openEditEmployeeModal(employeeId, employeeData) {
            employeeForm.action = `/employees/${employeeId}`;
            formMethod.value = 'PUT';
            modalTitle.textContent = 'Editar empleado';
            fillForm(employeeData);
            employeeModal.classList.add('show');
        }

        function closeEmployeeModal() {
            employeeModal.classList.remove('show');
            resetForm();
        }

        function resetForm() {
            employeeForm.reset();
            document.getElementById('modal_birthplace_id').innerHTML =
                '<option value="">Primero selecciona un país</option>';

            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });

            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.remove();
            });
        }

        function fillForm(data) {
            document.getElementById('modal_name').value = data.name || '';
            document.getElementById('modal_lastname').value = data.lastname || '';
            document.getElementById('modal_identification').value = data.identification || '';
            document.getElementById('modal_phone').value = data.phone || '';
            document.getElementById('modal_address').value = data.address || '';
            document.getElementById('modal_country_id').value = data.country_id || '';

            if (data.country_id) {
                loadCities(data.country_id, data.birthplace_id);
            }
        }

        function loadCities(countryId, selectedCityId = null) {
            const citySelect = document.getElementById('modal_birthplace_id');
            citySelect.innerHTML = '<option value="">Cargando ciudades...</option>';
            citySelect.disabled = true;

            fetch(`/employees/cities/${countryId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al cargar ciudades');
                    }
                    return response.json();
                })
                .then(cities => {
                    citySelect.innerHTML = '<option value="">Selecciona una ciudad</option>';
                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        if (selectedCityId && city.id == selectedCityId) {
                            option.selected = true;
                        }
                        citySelect.appendChild(option);
                    });
                    citySelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error loading cities:', error);
                    citySelect.innerHTML = '<option value="">Error cargando ciudades</option>';
                    citySelect.disabled = false;
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('modalClose').addEventListener('click', closeEmployeeModal);
            document.getElementById('modalCancel').addEventListener('click', closeEmployeeModal);

            employeeModal.addEventListener('click', function(e) {
                if (e.target === employeeModal) {
                    closeEmployeeModal();
                }
            });

            document.getElementById('modal_country_id').addEventListener('change', function() {
                const countryId = this.value;
                const citySelect = document.getElementById('modal_birthplace_id');

                if (countryId) {
                    loadCities(countryId);
                } else {
                    citySelect.innerHTML = '<option value="">Primero selecciona un país</option>';
                    citySelect.disabled = true;
                }
            });

            employeeForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Ingresar';
                }, 5000);
            });
        });

        window.openEmployeeModal = openEmployeeModal;
        window.closeEmployeeModal = closeEmployeeModal;
        window.openEditEmployeeModal = openEditEmployeeModal;
    </script>
@endpush
