@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0 min-vh-100">
            <div class="col-lg-8 d-none d-lg-flex left-image align-items-end justify-content-center px-4">
                <div class="left-text text-start mb-5">
                    <span class="title-main">
                        Bienvenido a la mejor plataforma<br>
                        <span class="bold">organizacional online</span>
                    </span>

                    <span class="title-sub">
                        Gestión efectiva del talento humano
                    </span>
                </div>
            </div>
            <div
                class="col-12 col-md-12 col-lg-4 d-flex flex-column justify-content-center align-items-center bg-white p-4 form-container">
                <div class="text-center">
                    <img src="/assets/images/isologo.png" alt="Logo" class="img-fluid"
                        style="width: 250px; padding-bottom: 65px">
                </div>
                <form method="POST" action="{{ route('login') }}" class="w-100" style="max-width: 380px;">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="email" class="form-control rounded-pill px-3 py-2"
                            placeholder="Ingresa tu usuario">
                        @error('email')
                            <span style="color:red; font-size:12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Contraseña</label>
                        <div class="position-relative">
                            <input type="password" name="password" id="password"
                                class="form-control rounded-pill px-3 py-2" placeholder="****">
                            <i class="fa fa-eye position-absolute toggle-password"
                                style="right: 18px; top: 50%; transform: translateY(-50%); opacity: 0.5; cursor: pointer;"></i>
                        </div>
                        @error('password')
                            <span style="color:red; font-size:12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn w-100 rounded-pill py-2"
                        style="background: #2B35FF; color: white; font-weight: 600;">
                        Iniciar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Agregar el script para el funcionamiento del ojito -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('.toggle-password');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function() {
                // Cambiar el tipo de input
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                // Cambiar el icono
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
@endsection
