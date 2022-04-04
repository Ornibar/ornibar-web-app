<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Responses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-back-button />
                    <div>
                        <div class="text-center">
                            <h1 class="primary-title">{{ __('Response Create') }}</h1>
                        </div>
                    </div>
                    
                    <div class="container mx-auto">
                        <form id="form_create_responses" class="form_create_responses" action="{{ route('responses.store') }}"  method="POST"
                        enctype="multipart/form-data" 
                        with-wysiwyg
                        >
                        @csrf
                            <div class="mb-3">
                                <!-- Question id -->
                                <div class="m-b-2">
                                    <label for="question_id">Question</label><br>
                                    <select name="question_id" class="form-control w-50">
                                        @foreach($allQuestions as $question)
                                            <option value="{{$question->id}}">{{ $question->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                    

                                <!--  Title -->
                                <div class="mt-4">
                                    <x-label for="name" :value="__('Name')" />
                                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" required />
                                </div>
            
                                <div class="flex items-center justify-end mt-4">
                                    <x-button class="ml-4">
                                        {{ __('Add') }}
                                    </x-button>
                                </div>
                            </div>
                        </form>
                        <div>
                            <div class="flex justify-between">
                                <h2 class="secondary-title">
                                    <strong>{{ count($allResponses) }}</strong> responses.
                                </h2>  
                            </div>
                            <form id="form_filter_responses" class="form_filter_responses" action="{{ route('responses.index') }}" method="GET">
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
                                                    <input type="checkbox" <?= $response->is_active ? 'checked' : '' ?> disabled/>  
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
                                                    <button id="delete_form_btn" class="icon-btn" title="delete response"><i class="fas fa-trash"></i></button>
                                                    <a href="{{ route('responses.edit', $response->id) }}" class="icon-btn" title="edit response"><i class="fas fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <x-confirm-modal :visible="'false'" :title="'Dialog Confirmation'" :message="'Are you sure to want delete this response ?'" :action="route('responses.destroy', $response->id)" :method="'post'"/>
                                    @endforeach
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
    </div>
</x-app-layout>