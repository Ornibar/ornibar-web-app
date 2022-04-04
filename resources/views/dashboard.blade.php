<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- @php 
        $routes = ['question', 'answser', 'party', 'user', 'statistic'];   
        $allRoutes = Route::getRoutes();
    @endphp --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200"> <!-- id="app" -->
                    {{-- <router-view /> --}}
                    
                    {{-- @for($i = 0; $i < count($routes); $i++)
                        @php 
                        
                        @endphp
                        <x-item-card :label="$routes[$i]" :routes="$routes" :test="$allRoutes"/>
                    @endfor --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
