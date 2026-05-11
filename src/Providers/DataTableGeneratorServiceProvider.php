<?php
	namespace Caydeesoft\Datatables\Providers;
	
	use Caydeesoft\Datatables\Commands\MakeDataTableStackCommand;
	use Caydeesoft\Datatables\Commands\MakeDataTableViewCommand;
	use Illuminate\Support\ServiceProvider;
	
	use Caydeesoft\Datatables\Commands\MakeDataTableCommand;
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
		
		
		
		/**
		 
		 * Bootstrap services.
		 
		 */
			
			public function boot(): void
				
				{
					
					$this->registerPublishes();
					
				}
		
		/**
		 
		 * Handle publishable resources.
		 
		 */
			
			protected function registerPublishes(): void
				
				{
					
					$this->publishes([
						                 
						                 __DIR__ . '/../../stubs/datatable.stub' =>
							                 
							                 base_path('stubs/datatable.stub'),
						                 
						                 __DIR__ . '/../../stubs/datatable-view.stub' =>
							                 
							                 base_path('stubs/datatable-view.stub'),
					                 
					                 ], 'datatable-stubs');
					
				}
		}