<?php
	
	namespace Caydeesoft\Datatables\Commands;
	
	use Illuminate\Console\Command;
	use Illuminate\Support\Facades\File;
	use Illuminate\Support\Str;
	use Symfony\Component\Console\Input\InputOption;
	
	class MakeDataTableViewCommand extends Command
		{
			protected $signature = 'make:datatable-view
        {name}
        {--columns=*}
        {--route=}
        {--table=datatable}';
			
			protected $description = 'Generate a DataTable Blade view';
			
			public function handle(): void
				{
					$name = $this->argument('name');
					
					$columns = $this->option('columns');
					$route = $this->option('route');
					$tableId = $this->option('table');
					
					$path = resource_path("views/{$name}.blade.php");
					
					if (File::exists($path)) {
						$this->error("View already exists.");
						return;
					}
					
					$stub = File::get(base_path('stubs/datatable-view.stub'));
					
					$headers = collect($columns)
						->map(fn ($column) => '<th>' . Str::headline($column) . '</th>')
						->implode("\n                ");
					
					$jsColumns = collect($columns)
						->map(fn ($column) => '{"data": "' . $column . '"}')
						->implode(",\n                    ");
					
					$stub = str_replace(
						[
							'{{ table_id }}',
							'{{ route }}',
							'{{ table_headers }}',
							'{{ table_columns }}',
							'{{ order_column }}',
							'{{ order_direction }}',
						],
						[
							$tableId,
							$route,
							$headers,
							$jsColumns,
							0,
							'desc',
						],
						$stub
					);
					
					File::ensureDirectoryExists(dirname($path));
					File::put($path, $stub);
					
					$this->info("View created successfully.");
				}
		}