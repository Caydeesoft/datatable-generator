<?php
	
	namespace Caydeesoft\Datatables\Commands;
	
	use Illuminate\Console\GeneratorCommand;
	
	use Symfony\Component\Console\Input\InputArgument;
	
	use Symfony\Component\Console\Input\InputOption;
	
	class MakeDataTableCommand extends GeneratorCommand
		{
			protected $name = 'make:datatable';
			
			protected $description = 'Generate a DataTable class';
			
			protected $type = 'DataTable';
			
			protected function getStub()
			: string
				
				{
					
					return file_exists(base_path('stubs/datatable.stub'))
						
						? base_path('stubs/datatable.stub')
						
						: __DIR__ . '/../../stubs/datatable.stub';
					
				}
			
			protected function getDefaultNamespace($rootNamespace)
			: string
				
				{
					
					return $rootNamespace . '\Http\Datatables';
					
				}
			
			protected function buildClass($name)
			: string
				
				{
					
					$stub = parent::buildClass($name);
					
					$model = $this->argument('model');
					
					$searchColumns = $this->option('search');
					
					$searchConditions = collect($searchColumns)
						->map(function ($column, $index)
							
							{
								
								$method = $index === 0 ? 'where' : 'orWhere';
								
								return str_repeat(' ', 16)
								       
								       . "\$q->{$method}('{$column}', 'LIKE', \"%{\$search}%\");";
								
							})
						->implode("\n");
					
					return str_replace(
						
						[
							
							'{{ model }}',
							
							'{{ permission }}',
							
							'{{ route }}',
							
							'{{ search_conditions }}',
						
						],
						
						[
							
							$model,
							
							strtolower($model),
							
							strtolower($model),
							
							$searchConditions,
						
						],
						
						$stub
					
					);
					
				}
			
			protected function getArguments()
			: array
				
				{
					
					return [
						
						[
							
							'name',
							
							InputArgument::REQUIRED,
							
							'The DataTable class name',
						
						],
						
						[
							
							'model',
							
							InputArgument::REQUIRED,
							
							'The model name',
						
						],
					
					];
					
				}
			
			protected function getOptions()
			: array
				
				{
					
					return [
						
						[
							
							'search',
							
							null,
							
							InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
							
							'Searchable columns',
							
							[],
						
						],
					
					];
				}
		}