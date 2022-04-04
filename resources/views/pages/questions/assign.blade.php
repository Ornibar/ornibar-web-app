<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assign responses') }}
        </h2>
    </x-slot>


    @if (session('message'))
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>
                            <div class="bg-white p-x-4 p-y-3 m-y-5 radius-10 box-shadow">
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <div class="text-center">
                            <h1 class="primary-title">{{ __('Answsers List') }}</h1>
                            <h2 class="secondary-title">{{ $question->title }}</h2>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between">
                            <h2 class="secondary-title">
                                <strong>{{ count($allResponses) }}</strong> responses.
                            </h2>  
                        </div>
                        <form id="form_assign_responses" class="form_assign_responses" action="{{ route('questions.assign', $question->id) }}" method="GET">
                            <div class="mb-3">
                                <div class="flex justify-between items-center ">  
                                    <div class="flex justify-between items-center gap-2">
                                        <x-label for="paginate" :value="__('Number per pages')" />
                                        <x-input type="number" name="paginate" class="w-50"  value="{{ isset($currentValues['paginate']) ? $currentValues['paginate'] : '100' }}" oninput="this.value = 
                                        !!this.value && Math.abs(this.value) > 0 ? Math.abs(this.value) : null"/>
                                    </div> 
                                    <div class="flex justify-between items-center gap-2">
                                        <div class="attr-sizes">
                                            <x-input type="text" name="search-response" class="w-100" :placeholder="__('Search by words')"/>               
                                        </div>
                                    </div>               
                                    <button class="primary-btn">
                                        {{ __('Search') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="flex justify-end">
                            <form action="{{ route('responses.random_assign', $question->id) }}" method="POST">
                                @csrf
                                @method('patch')
                                <button class="primary-btn">
                                    {{ __('Random Assign') }}
                                </button> 
                            </form> 
                        </div> 
                        <table class="table-auto w-full mt-8 text-center">
                            <thead>
                                <tr>
                                    <th>Active</th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filteredResponses as $response)
                                    <tr>
                                        <td>
                                            <div class="m-b-2 flex justify-center">
                                                <x-switcher :activate="$response->is_active ? 'activate' : ''" :id="$response->id" :response="'true'" :question="$question->id"/>
                                            </div>                                       
                                        </td>
                                        <td>
                                            {{ $response->id }}
                                        </td>
                                        <td>
                                            {{ $response->name }}
                                        </td>
                                        <td>
                                            <div class="flex justify-center gap-4">
                                                <button id="delete_form_btn" class="icon-btn" title="delete response" data-attr="{{ route('responses.destroy', $response->id) }}"><i class="fas fa-trash"></i></button>
                                                <a href="{{ route('responses.edit', $response->id) }}" class="icon-btn" title="edit response"><i class="fas fa-edit"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <x-confirm-modal :visible="'false'" :title="'Dialog Confirmation'" :message="'Are you sure to want delete this response ?'" :method="'post'"/>
                            </tbody>
                        </table>
                        <div class="text-center mt-5">
                            @if(count($filteredResponses) == 0)
                                {{ 'Aucun résultat' }}
                            @endif 
                        </div>
                        <div class="laravel-pagination">
                            {!! $filteredResponses->appends(Request::all())->links() !!}
                        </div> 
                    </div> 
                </div>              
            </div>
        </div>
    </div>
    
</x-app-layout>