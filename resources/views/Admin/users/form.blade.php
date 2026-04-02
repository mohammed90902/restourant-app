<x-app-layout>
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap & Font Awesome -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
     
        <!-- jQuery (necessary for Select2) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </head>

    <body class="bg-light">
        <!-- Page Content -->
        <main>
            <div class="container mt-5">
                <div class="bg-white p-4 rounded shadow-sm mx-auto" style="max-width: 900px;">
                    <!-- Back Button -->
                    <a href="#" class="btn btn-success mb-3" onclick="window.history.back();">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>

                    <!-- Form Title -->
                    <h4 class="mb-4">
                        @if (isset($data))
                            Update User
                        @else
                            User Creation
                        @endif
                    </h4>

                    <!-- Form -->
                    <form action="{{ isset($data) ? route('users.update', ['user' => $data->id]) : route('users.store') }}" method="POST">
                        @csrf
                        @isset($data)
                            @method('PUT')
                        @endisset

                        <x-input title="Email" name="email" type="email" data="{{isset($data) ? true:false }}"/>
                        <x-input title="password" name="password" type="password" data="{{false}}"/>
                        <x-input title="password_confirmation" name="password_confirmation" type="password" data="{{false}}"/>

                        <div class="row">
                            <!-- Role Selection -->
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <label for="role" class="form-label fw-semibold">Role</label>
                                <select name="role" id="role" class="form-select js-example-basic-single">
                                    <option @selected(isset($data) ? $data->role == 1 : old('role') == 1) value="1">Admin</option>
                                    <option @selected(isset($data) ? $data->role == 2 : old('role') == 2) value="2">Waiter</option>
                                    <option @selected(isset($data) ? $data->role == 3 : old('role') == 3) value="3">Chef</option>
                                    <option @selected(isset($data) ? $data->role == 4 : old('role') == 4) value="4">Customer</option>
                                </select>
                            </div>
                        </div>

                        <x-button :checkifupdate="isset($data)" />
                    </form>
                </div>
            </div>
        </main>

        <!-- Bootstrap Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Initialize Select2 -->
        <script>
            $(document).ready(function() {
                // Initialize Select2 for elements with the class 'js-example-basic-single'
                $('.js-example-basic-single').select2();
            });
        </script>
    </body>
    </html>
</x-app-layout>