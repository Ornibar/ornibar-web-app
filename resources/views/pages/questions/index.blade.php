<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questions') }}
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
                            <h1 class="primary-title">{{ __('Questions List') }}</h1>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between">
                            <h2 class="secondary-title">
                                <strong>{{ count($allQuestions) }}</strong> questions.
                            </h2>  
                            <a href="{{ route('questions.create') }}" title="create question">
                                <button class="primary-btn">
                                    {{ __('Create') }}
                                </button> 
                            </a>   
                        </div>
                        <form id="form_filter_questions" class="form_filter_questions" action="{{ route('questions.index') }}" method="GET">
                            <div class="mb-3">
                                <div class="flex justify-between items-center ">  
                                    <div class="flex justify-between items-center gap-2">
                                        <x-label for="paginate" :value="__('Number per pages')" />
                                        <x-input type="number" name="paginate" class="w-50"  value="{{ isset($currentValues['paginate']) ? $currentValues['paginate'] : '100' }}" oninput="this.value = 
                                        !!this.value && Math.abs(this.value) > 0 ? Math.abs(this.value) : null"/>
                                    </div> 
                                    <div class="flex justify-between items-center gap-2">
                                        <div class="attr-sizes">
                                            <x-input type="text" name="search-question" class="w-100" :placeholder="__('Search by words')"/>               
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
                                    <th>File</th>
                                    <th>title</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filteredQuestions as $question)
                                    {{-- @php
                                        dd($question);
                                    @endphp --}}
                                    <tr>
                                        <td>
                                            <div class="m-b-2 flex justify-center">
                                                <x-switcher :activate="$question->is_active ? 'activate' : ''" :id="$question->id" :question="'true'"/>
                                            </div>                                       
                                        </td>
                                        <td>
                                            {{ $question->id }}
                                        </td>
                                        <td>
                                            @php
                                                $file = json_decode($question->file);
                                            @endphp
                                            @if(isset($file->type))
                                                @if($file->type === "image")
                                                    <img class="m-auto" src="<?= $file != null ? $file->url : ''?>" alt="Question Image"  width="150" height="150"/>
                                                @else
                                                    <video width="150" height="150" controls>
                                                    <source src="<?= $file != null ? $file->url : ''?>" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                    </video>
                                                @endif
                                            @else

                                            @endif
                                        </td>
                                        <td>
                                            {{ $question->title }}
                                        </td>
                                        <td>
                                            <div class="flex justify-center gap-4">
                                                <button id="delete_form_btn" class="icon-btn" title="delete response" data-attr="{{ route('questions.destroy', $question->id) }}"><i class="fas fa-trash"></i></button>
                                                <a href="{{ route('questions.edit', $question->id) }}" class="icon-btn" title="edit question"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('questions.assign', $question->id) }}" class="icon-btn" title="assign question"><i class="fas fa-bookmark"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <x-confirm-modal :visible="'false'" :title="'Dialog Confirmation'" :message="'Are you sure to want delete this question ?'" :method="'post'"/>
                            </tbody>
                        </table>
                        <div class="text-center mt-5">
                            @if(count($filteredQuestions) == 0)
                                {{ 'Aucun résultat' }}
                            @endif 
                        </div>
                        <div class="laravel-pagination">
                            {!! $filteredQuestions->appends(Request::all())->links() !!}
                        </div> 
                    </div> 
                </div>              
            </div>
        </div>
    </div>
    
</x-app-layout>