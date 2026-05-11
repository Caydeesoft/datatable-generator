# Laravel Datatable Generator

A powerful and extensible DataTable scaffolding package for Laravel.

Generate server-side DataTables, Blade views, controllers, requests, policies, API resources, and complete admin stacks using Artisan commands.

Built for scalable Laravel applications.

---

# Features

- Generate server-side DataTables
- Generate Blade DataTable views
- Generate full DataTable stacks
- Searchable columns
- Server-side pagination
- Ordering support
- Stub publishing support
- Extensible architecture
- Laravel package auto-discovery
- Laravel 11 & 12 support
- PHP 8.2+ support

---

# Installation

Install the package via Composer:

```bash
composer require caydeesoft/datatable-generator
```

---

# Package Auto Discovery

The package supports Laravel auto-discovery.

No manual provider registration required.

---

# Publish Stubs

Publish all package stubs:

```bash
php artisan vendor:publish --tag=datatable-stubs
```

Published stubs:

```plaintext
stubs/
├── datatable.stub
└── datatable-view.stub
```

You can fully customize generated files by editing these stubs.

---

# Commands

## Generate DataTable

```bash
php artisan make:datatable UserDataTable User
```

### With Search Columns

```bash
php artisan make:datatable UserDataTable User \
    --search=name \
    --search=email \
    --search=phone
```

---

## Generate DataTable View

```bash
php artisan make:datatable-view backend/users/index \
    --route=backend.user.datatable \
    --table=user-table \
    --columns=id \
    --columns=name \
    --columns=email \
    --columns=status \
    --columns=action
```

---

## Generate Full DataTable Stack

```bash
php artisan make:datatable-stack User \
    --columns=id \
    --columns=name \
    --columns=email \
    --columns=status \
    --columns=action \
    --search=name \
    --search=email \
    --controller \
    --request \
    --policy \
    --api
```

---

# Generated Structure

## DataTable Generator

```plaintext
app/Http/Datatables/UserDataTable.php
```

---

## View Generator

```plaintext
resources/views/backend/users/index.blade.php
```

---

## Stack Generator

```plaintext
app/
├── Http/
│   ├── Controllers/
│   │   └── UserController.php
│   │
│   ├── Datatables/
│   │   └── UserDataTable.php
│   │
│   ├── Requests/
│   │   └── UserRequest.php
│   │
│   └── Resources/
│       └── UserResource.php
│
├── Policies/
│   └── UserPolicy.php

resources/
└── views/
    └── backend/
        └── users/
            └── index.blade.php
```

---

# Example Generated DataTable

```php
<?php

namespace App\Http\Datatables;

use App\Models\User;

class UserDataTable
{
    public array $columns = [
        'id',
        'name',
        'email',
    ];

    public function data($request): array
    {
        $query = User::query();

        if ($search = $request->input('search.value'))
        {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
        }

        return [
            'data' => $query->get(),
        ];
    }
}
```

---

# Example Generated View

```blade
@extends('layouts.backend')

@section('content')

<table id="user-table" class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
</table>

@endsection

@section('footer')

<script type="application/javascript">
document.addEventListener('DOMContentLoaded', function ()
{
    new window.DataTable('#user-table',
    {
        processing: true,
        serverSide: true,

        ajax:
        {
            url: "{{ route('backend.user.datatable') }}",
            type: "POST",

            data:
            {
                _token: "{{ csrf_token() }}"
            }
        },

        columns:
        [
            {"data": "id"},
            {"data": "name"},
            {"data": "email"},
            {"data": "status"},
            {"data": "action"}
        ]
    });
});
</script>

@endsection
```

---

# Available Commands

| Command | Description |
|---|---|
| `make:datatable` | Generate DataTable class |
| `make:datatable-view` | Generate Blade DataTable view |
| `make:datatable-stack` | Generate full DataTable stack |

---

# Command Options

## make:datatable

| Option | Description |
|---|---|
| `--search=*` | Searchable columns |

---

## make:datatable-view

| Option | Description |
|---|---|
| `--columns=*` | Table columns |
| `--route=` | AJAX route |
| `--table=` | HTML table ID |

---

## make:datatable-stack

| Option | Description |
|---|---|
| `--columns=*` | Table columns |
| `--search=*` | Searchable columns |
| `--controller` | Generate controller |
| `--request` | Generate request |
| `--policy` | Generate policy |
| `--api` | Generate API resource |

---

# Supported Versions

## Laravel

| Version | Supported |
|---|---|
| 11.x | ✅ |
| 12.x | ✅ |

---

## PHP

| Version | Supported |
|---|---|
| 8.2 | ✅ |
| 8.3 | ✅ |
| 8.4 | ✅ |

---

# Stub Customization

All generated files are powered by stubs.

Publish stubs:

```bash
php artisan vendor:publish --tag=datatable-stubs
```

Modify:

```plaintext
stubs/datatable.stub
stubs/datatable-view.stub
```

to customize generated output.

---

# Recommended DataTables Library

This package works perfectly with:

- DataTables.net
- Bootstrap DataTables
- Server-side Laravel DataTables

Official site:

https://datatables.net/

---

# Testing

Run tests:

```bash
composer test
```

---

# Code Formatting

Run Laravel Pint:

```bash
composer format
```

---

# Package Structure

```plaintext
datatable-generator/
├── src/
│   ├── Commands/
│   ├── Providers/
│   └── Support/
│
├── stubs/
│   ├── datatable.stub
│   └── datatable-view.stub
│
├── tests/
├── composer.json
├── README.md
└── LICENSE
```

---

# Future Features

Planned features include:

- Dynamic schema detection
- Relationship searching
- Export support (CSV/XLSX/PDF)
- Filters
- Column permissions
- Bulk actions
- Query pipelines
- Vue integration
- React integration
- Livewire integration
- API DataTables
- Multi-tenant support
- Admin module scaffolding
- Yajra DataTables integration

---

# Roadmap

Future commands:

```bash
php artisan make:admin-module
php artisan make:datatable-filter
php artisan make:datatable-export
php artisan make:datatable-column
```

---

# Contributing

Contributions are welcome.

## Steps

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Open a Pull Request

---

# Security

If you discover any security vulnerabilities, please email:

dennis.kiptoo@caydeesoft.com

---

# License

This package is open-sourced software licensed under the MIT license.

---

# Author

## Dennis Kiptugen

- Company: Caydeesoft
- Email: dennis.kiptoo@caydeesoft.com

---

# Links

## GitHub Repository

https://github.com/caydeesoft/datatable-generator

---

## Packagist

https://packagist.org/packages/caydeesoft/datatable-generator