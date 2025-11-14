@extends('layouts.dashboard')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center text-center text-32 mt-5 mb-5">
        <span>Bienvenida!</span>
        <span>{{ Auth::user()->name ?? 'Administrador' }}</span>
    </div>

    <div class="d-flex flex-column justify-content-center align-items-center text-center text-18 mt-5">
        <span>Añade los datos personales de tus empleados y después agrega su cargo en tu empresa</span>
    </div>

    <div class="d-flex flex-column justify-content-center align-items-center text-center text-18 mt-5">
        <div class="btn-employee-wrapper" style="cursor: pointer;">
            <img src="/assets/images/button.png" alt="Agregar Empleado" class="btn-employee" onclick="openEmployeeModal()">
        </div>
        <span>Empieza aquí</span>
    </div>

    <div class="d-flex justify-content-end mt-5">
        <img src="/assets/images/tech.png" alt="Decoración" style="width: 700px;">
    </div>
@endsection
