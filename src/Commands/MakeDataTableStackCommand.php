<?php
	
	namespace Caydeesoft\Datatables\Commands;
	
	use Illuminate\Console\Command;
	use Illuminate\Support\Facades\Artisan;
	use Illuminate\Support\Str;
	
	class MakeDataTableStackCommand extends Command
		{
			protected $signature = '
        make:datatable-stack
        {name : Resource name}
        {--model=}
        {--columns=*}
        {--search=*}
        {--table=}
        {--route=}
        {--controller}
        {--request}
        {--policy}
        {--api}
    ';
			
			protected $description = 'Generate full DataTable stack';
			
			public function handle(): void
				{
					$name = Str::studly($this->argument('name'));
					
					$model = Str::studly($this->option('model') ?: $name);
					
					$table = $this->option('table')
						?: Str::kebab($name) . '-table';
					
					$route = $this->option('route')
						?: 'backend.' . Str::snake($name) . '.datatable';
					
					$columns = array_values($this->option('columns') ?: []);
					
					$search = array_values($this->option('search') ?: []);
					
					$datatable = "{$name}DataTable";
					
					$view = 'backend/' . Str::snake($name) . '/index';
					
					$controller = "{$name}Controller";
					
					$request = "{$name}Request";
					
					$policy = "{$name}Policy";
					
					$resource = "{$name}Resource";
					
					$this->components->info('Generating DataTable stack...');
					
					/*
					|--------------------------------------------------------------------------
					| DataTable
					|--------------------------------------------------------------------------
					*/
					Artisan::call('make:datatable', [
						'name' => $datatable,
						'model' => $model,
						'--search' => $search,
					]);
					
					$this->line(Artisan::output());
					
					/*
					|--------------------------------------------------------------------------
					| View
					|--------------------------------------------------------------------------
					*/
					Artisan::call('make:datatable-view', [
						'name' => $view,
						'--route' => $route,
						'--table' => $table,
						'--columns' => $columns,
					]);
					
					$this->line(Artisan::output());
					
					/*
					|--------------------------------------------------------------------------
					| Controller
					|--------------------------------------------------------------------------
					*/
					if ($this->option('controller')) {
						Artisan::call('make:controller', [
							'name' => $controller,
						]);
						
						$this->line(Artisan::output());
					}
					
					/*
					|--------------------------------------------------------------------------
					| Request
					|--------------------------------------------------------------------------
					*/
					if ($this->option('request')) {
						Artisan::call('make:request', [
							'name' => $request,
						]);
						
						$this->line(Artisan::output());
					}
					
					/*
					|--------------------------------------------------------------------------
					| Policy
					|--------------------------------------------------------------------------
					*/
					if ($this->option('policy')) {
						Artisan::call('make:policy', [
							'name' => $policy,
							'--model' => $model,
						]);
						
						$this->line(Artisan::output());
					}
					
					/*
					|--------------------------------------------------------------------------
					| API Resource
					|--------------------------------------------------------------------------
					*/
					if ($this->option('api')) {
						Artisan::call('make:resource', [
							'name' => $resource,
						]);
						
						$this->line(Artisan::output());
					}
					
					/*
					|--------------------------------------------------------------------------
					| Summary Table (FIXED)
					|--------------------------------------------------------------------------
					*/
					$rows = [
						['DataTable', "app/Http/Datatables/{$datatable}.php"],
						['View', "resources/views/{$view}.blade.php"],
					];
					
					if ($this->option('controller')) {
						$rows[] = ['Controller', "app/Http/Controllers/{$controller}.php"];
					}
					
					if ($this->option('request')) {
						$rows[] = ['Request', "app/Http/Requests/{$request}.php"];
					}
					
					if ($this->option('policy')) {
						$rows[] = ['Policy', "app/Policies/{$policy}.php"];
					}
					
					if ($this->option('api')) {
						$rows[] = ['API Resource', "app/Http/Resources/{$resource}.php"];
					}
					
					$this->newLine();
					
					$this->components->info('DataTable stack generated successfully.');
					
					$this->table(['Component', 'Generated'], $rows);
				}
		}