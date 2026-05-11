<?php
	
	namespace Caydeesoft\Datatables\Commands;
	
	use Illuminate\Console\GeneratorCommand;
	use Illuminate\Support\Str;
	use Symfony\Component\Console\Input\InputOption;
	
	class MakeDataTableViewCommand extends GeneratorCommand
		{
		/**
		 * Console command name.
		 */
			protected $name = 'make:datatable-view';
		
		/**
		 * Description.
		 */
			protected $description = 'Generate a DataTable Blade view';
		
		/**
		 * Generator type.
		 */
			protected $type = 'DataTable View';
		
		/**
		 * Stub location.
		 */
			protected function getStub(): string
				{
					return file_exists(base_path('stubs/datatable-view.stub'))
						? base_path('stubs/datatable-view.stub')
						: __DIR__ . '/../../stubs/datatable-view.stub';
				}
		
		/**
		 * Build class content.
		 */
			protected function buildClass($name): string
				{
					$stub = parent::buildClass($name);
					
					$columns = $this->option('columns');
					
					$route = $this->option('route');
					
					$tableId = $this->option('table');
					
					$headers = collect($columns)
						->map(fn ($column) =>
							'<th>' . Str::headline($column) . '</th>'
						)
						->implode("\n                ");
					
					$jsColumns = collect($columns)
						->map(fn ($column) =>
							'{"data": "' . $column . '"}'
						)
						->implode(",\n                    ");
					
					return str_replace(
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
				}
		
		/**
		 * Get destination path.
		 */
			protected function getPath($name): string
				{
					return resource_path(
						'views/' .
						str_replace('\\', '/', $name) .
						'.blade.php'
					);
				}
		
		/**
		 * Disable namespace replacement.
		 */
			protected function getDefaultNamespace($rootNamespace): string
				{
					return '';
				}
		
		/**
		 * Command options.
		 */
			protected function getOptions(): array
				{
					return [
						[
							'columns',
							null,
							InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
							'Table columns',
							[],
						],
						
						[
							'route',
							null,
							InputOption::VALUE_REQUIRED,
							'Datatable route',
						],
						
						[
							'table',
							null,
							InputOption::VALUE_OPTIONAL,
							'Table ID',
							'datatable',
						],
					];
				}
		}