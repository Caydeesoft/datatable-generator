<?php
	
	namespace Caydeesoft\Datatables\Commands;
	
	use Illuminate\Console\Command;
	use Illuminate\Support\Facades\Artisan;
	use Illuminate\Support\Str;
	
	class MakeDataTableStackCommand extends Command
		{
		/**
		 * Command signature.
		 */
			protected $signature = '
        make:datatable-stack
        {name : Resource name}
        {--model= : Model name}
        {--columns=* : Table columns}
        {--search=* : Searchable columns}
        {--table= : Table ID}
        {--route= : Route prefix}
        {--controller : Generate controller}
        {--request : Generate form request}
        {--policy : Generate policy}
        {--api : Generate API resource}
    ';
		
		/**
		 * Command description.
		 */
			protected $description = 'Generate full DataTable stack';
		
		/**
		 * Execute command.
		 */
			public function handle(): void
				{
					$name = Str::studly($this->argument('name'));
					
					$model = $this->option('model')
						?: $name;
					
					$table = $this->option('table')
						?: Str::kebab($name) . '-table';
					
					$route = $this->option('route')
						?: 'backend.' . Str::snake($name) . '.datatable';
					
					$columns = $this->option('columns');
					
					$search = $this->option('search');
					
					$datatable = "{$name}DataTable";
					
					$view = 'backend/' . Str::snake($name) . '/index';
					
					$controller = "{$name}Controller";
					
					$request = "{$name}Request";
					
					$policy = "{$name}Policy";
					
					$resource = "{$name}Resource";
					
					$this->components->info('Generating DataTable stack...');
					
					/*
					|--------------------------------------------------------------------------
					| Generate DataTable
					|--------------------------------------------------------------------------
					*/
					
					Artisan::call('make:datatable', [
						'name' => $datatable,
						'model' => $model,
						'--search' => $search,
					]);
					
					$this->line(
						Artisan::output()
					);
					
					/*
					|--------------------------------------------------------------------------
					| Generate View
					|--------------------------------------------------------------------------
					*/
					
					Artisan::call('make:datatable-view', [
						'name' => $view,
						'--route' => $route,
						'--table' => $table,
						'--columns' => $columns,
					]);
					
					$this->line(
						Artisan::output()
					);
					
					/*
					|--------------------------------------------------------------------------
					| Generate Controller
					|--------------------------------------------------------------------------
					*/
					
					if ($this->option('controller'))
						{
							Artisan::call('make:controller', [
								'name' => $controller,
							]);
							
							$this->line(
								Artisan::output()
							);
						}
					
					/*
					|--------------------------------------------------------------------------
					| Generate Request
					|--------------------------------------------------------------------------
					*/
					
					if ($this->option('request'))
						{
							Artisan::call('make:request', [
								'name' => $request,
							]);
							
							$this->line(
								Artisan::output()
							);
						}
					
					/*
					|--------------------------------------------------------------------------
					| Generate Policy
					|--------------------------------------------------------------------------
					*/
					
					if ($this->option('policy'))
						{
							Artisan::call('make:policy', [
								'name' => $policy,
								'--model' => $model,
							]);
							
							$this->line(
								Artisan::output()
							);
						}
					
					/*
					|--------------------------------------------------------------------------
					| Generate API Resource
					|--------------------------------------------------------------------------
					*/
					
					if ($this->option('api'))
						{
							Artisan::call('make:resource', [
								'name' => $resource,
							]);
							
							$this->line(
								Artisan::output()
							);
						}
					
					/*
					|--------------------------------------------------------------------------
					| Success Message
					|--------------------------------------------------------------------------
					*/
					
					$this->newLine();
					
					$this->components->info('DataTable stack generated successfully.');
					
					$this->table(
						['Component', 'Generated'],
						[
							['DataTable', "app/Http/Datatables/{$datatable}.php"],
							['View', "resources/views/{$view}.blade.php"],
							
							$this->option('controller')
								? ['Controller', "app/Http/Controllers/{$controller}.php"]
								: null,
							
							$this->option('request')
								? ['Request', "app/Http/Requests/{$request}.php"]
								: null,
							
							$this->option('policy')
								? ['Policy', "app/Policies/{$policy}.php"]
								: null,
							
							$this->option('api')
								? ['API Resource', "app/Http/Resources/{$resource}.php"]
								: null,
						]
					);
				}
		}