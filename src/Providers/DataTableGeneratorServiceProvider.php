<?php
	
	namespace Caydeesoft\Datatables\Providers;
	
	use Illuminate\Support\ServiceProvider;
	use Caydeesoft\Datatables\Commands\MakeDataTableCommand;
	use Caydeesoft\Datatables\Commands\MakeDataTableViewCommand;
	use Caydeesoft\Datatables\Commands\MakeDataTableStackCommand;
	
	class DataTableGeneratorServiceProvider extends ServiceProvider
		{
			public function register(): void
				{
					$this->commands([
						                MakeDataTableCommand::class,
						                MakeDataTableViewCommand::class,
						                MakeDataTableStackCommand::class,
					                ]);
				}
			
			public function boot(): void
				{
					$this->registerPublishes();
				}
			
			protected function registerPublishes(): void
				{
					$base = dirname(__DIR__, 2); // <- package root
					
					$this->publishes([
						                 $base . '/stubs/datatable.stub' =>
							                 base_path('stubs/datatable.stub'),
						                 
						                 $base . '/stubs/datatable-view.stub' =>
							                 base_path('stubs/datatable-view.stub'),
					                 ], 'datatable-stubs');
				}
		}