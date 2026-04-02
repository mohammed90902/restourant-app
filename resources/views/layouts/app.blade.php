<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RestaurantSystem') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        /* Header Styles */
        .navbar-custom {
            background-color: #3f51b5; /* Blue Header */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: bold;
            color: #ffcc00 !important; /* Yellow Text */
        }
        .navbar-nav .nav-link, .text-light {
            color: white !important;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 60px; /* Adjust based on header height */
            left: 0;
            background-color: #f8f9fa;
            padding: 20px;
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1);
        }
        .sidebar .nav-link {
            color: #333;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .sidebar .nav-link:hover {
            background-color: #e9ecef;
        }
        .sidebar .nav-link.active {
            background-color: #3f51b5;
            color: white !important;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 250px; /* Adjust based on sidebar width */
            padding: 20px;
            margin-top: 60px; /* Adjust based on header height */
        }

        /* Card Styles */
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top shadow-sm">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Restaurant System</a>
            <!-- Toggle Button for Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link text-light">{{ Auth::user()->email }}</span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#usersCollapse" aria-expanded="false">
                    <i class="fas fa-users me-2"></i> Users <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul id="usersCollapse" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'users.index' ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <i class="fas fa-list me-2"></i> Show
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'users.create' ? 'active' : '' }}" href="{{ route('users.create') }}">
                            <i class="fas fa-plus me-2"></i> Create
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#categoriesCollapse" aria-expanded="false">
                    <i class="fas fa-tags me-2"></i> Categories <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul id="categoriesCollapse" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'categories.index' ? 'active' : '' }}" href="{{ route('categories.index') }}">
                            <i class="fas fa-list me-2"></i> Show
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'categories.create' ? 'active' : '' }}" href="{{ route('categories.create') }}">
                            <i class="fas fa-plus me-2"></i> Create
                        </a>
                    </li>
                </ul>
            </li>
            <!-- SubCategories Section -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#subCategoriesCollapse" aria-expanded="false">
                    <i class="fas fa-layer-group me-2"></i> SubCategories <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul id="subCategoriesCollapse" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'sub-categories.index' ? 'active' : '' }}" href="{{ route('sub-categories.index') }}">
                            <i class="fas fa-list me-2"></i> Show
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'sub-categories.create' ? 'active' : '' }}" href="{{ route('sub-categories.create') }}">
                            <i class="fas fa-plus me-2"></i> Create
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Food Section -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#foodCollapse" aria-expanded="false">
                    <i class="fas fa-utensils me-2"></i> Food <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul id="foodCollapse" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <!-- Food Section -->
<li class="nav-item">

    <ul id="foodCollapse" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <!-- SubCategories List -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#foodSubCategoriesCollapse" aria-expanded="false">
                <i class="fas fa-list me-2"></i> SubCategories <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <ul id="foodSubCategoriesCollapse" class="nav-content collapse">
                @foreach ($subCategories as $subCategory)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('foods.index', ['sub_category' => $subCategory->id]) }}">
                            {{ $subCategory->name_en }}
                            @if(isset($subCategory->category))
                                <small class="text-muted">({{ $subCategory->category->name_en }})</small>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
       
    </ul>
</li>
                    <!-- Create Food Item -->
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'foods.create' ? 'active' : '' }}" href="{{ route('foods.create') }}">
                            <i class="fas fa-plus me-2"></i> Create
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Tables Section -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#tablesCollapse" aria-expanded="false">
                    <i class="fas fa-table me-2"></i> Tables <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <ul id="tablesCollapse" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'tables.index' ? 'active' : '' }}" href="{{ route('tables.index') }}">
                            <i class="fas fa-list me-2"></i> Show
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'tables.create' ? 'active' : '' }}" href="{{ route('tables.create') }}">
                            <i class="fas fa-plus me-2"></i> Create
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <!-- Page Content -->
                    <main class="p-3">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let deleteFunction = (id) => {
            Swal.fire({
                title: 'Are you sure to delete this?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'Deleted Successfully',
                        'success'
                    );
                    document.getElementById(id).submit();
                }
            });
        };
    </script>
</body>
</html>