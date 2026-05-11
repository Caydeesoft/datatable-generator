# Laravel Datatable Generator

A powerful Laravel package for generating server-side DataTable classes with searchable columns, pagination, ordering, and reusable scaffolding.

---

## Features

- Laravel Artisan DataTable generator
- Server-side DataTables support
- Searchable columns
- Pagination support
- Ordering support
- Stub publishing
- Extensible architecture
- Laravel 11 & 12 support
- PHP 8.2+ support

---

## Installation

Install via Composer:

```bash
composer require caydeesoft/datatable-generator
```

---

## Publish Stubs

Publish the default stub files:

```bash
php artisan vendor:publish --tag=datatable-stubs
```

This will publish:

```plaintext
stubs/datatable.stub
```

You can customize the generated DataTables by editing this stub.

---

## Usage

Generate a DataTable class:

```bash
php artisan make:datatable UserDataTable User
```

Generate with searchable columns:

```bash
php artisan make:datatable UserDataTable User \
    --search=name \
    --search=email \
    --search=phone
```

Generated file:

```plaintext
app/Http/Datatables/UserDataTable.php
```

---

## Example Generated Class

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

## Generated Features

The generated DataTables include:

- Search functionality
- Ordering
- Pagination
- JSON responses
- Action buttons
- Role permissions support
- Reusable architecture

---

## Available Options

| Option | Description |
|---|---|
| `--search` | Add searchable columns |

Example:

```bash
php artisan make:datatable ProductDataTable Product \
    --search=name \
    --search=sku \
    --search=price
```

---

## Package Structure

```plaintext
src/
├── Commands/
├── Providers/
├── Support/

stubs/
tests/
```

---

## Supported Laravel Versions

| Laravel | Supported |
|---|---|
| 11.x | ✅ |
| 12.x | ✅ |

---

## Supported PHP Versions

| PHP | Supported |
|---|---|
| 8.2 | ✅ |
| 8.3 | ✅ |
| 8.4 | ✅ |

---

## Testing

Run tests:

```bash
composer test
```

---

## Code Formatting

Run Laravel Pint:

```bash
composer format
```

---

## Future Features

Planned features include:

- Dynamic column generation
- Relationship searching
- Export support (CSV/XLSX/PDF)
- Vue/React generators
- Livewire integration
- Yajra integration
- API DataTables
- Multi-table reusable engine
- Filters & sorting pipelines
- Column permissions
- Bulk actions

---

## Contributing

Contributions are welcome.

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to your branch
5. Open a Pull Request

---

## Security

If you discover any security-related issues, please email:

dennis.kiptoo@caydeesoft.com

---

## License

The MIT License (MIT).

---

## Author

### Dennis Kiptugen

- Company: Caydeesoft
- Email: dennis.kiptoo@caydeesoft.com

---

## Links

- GitHub Repository:
  https://github.com/caydeesoft/datatable-generator

- Packagist:
  https://packagist.org/packages/caydeesoft/datatable-generator
