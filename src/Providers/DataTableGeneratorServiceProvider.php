<?php
	namespace Caydeesoft\Datatables\Providers;
	
	use Illuminate\Support\ServiceProvider;
	
	use Caydeesoft\Datatables\Commands\MakeDataTableCommand;
	class DataTableGeneratorServiceProvider extends ServiceProvider
		{
			public function register(): void
				
				{
					
					$this->commands([
						                
						                MakeDataTableCommand::class,
					                
					                ]);
					
				}
			
			public function boot(): void
				
				{
					
					$this->publishes([
						                 
						                 __DIR__ . '/../../stubs/datatable.stub' =>
							                 
							                 base_path('stubs/datatable.stub'),
					                 
					                 ], 'datatable-stubs');
					
				}
		}