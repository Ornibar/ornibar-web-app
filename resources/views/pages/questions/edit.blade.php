<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questions') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="w-96 mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-back-button />
                    <div>
                        <div class="text-center">
                            <h1 class="primary-title">{{ __('Question Edit') }}</h1>
                        </div>
                    </div>
                    
                    <div class="container mx-auto">
                        <form id="form_update_questions" class="form_update_questions" action="{{ route('questions.update', $question->id) }}"  method="POST"
                        enctype="multipart/form-data" 
                        with-wysiwyg
                        >
                        @csrf
                        @method('PUT')
                            <div class="mb-3">
                                <!-- img -->
                                {{-- <div class="mt-4">
                                    <x-label for="username" :value="__('Username')" />
                                    <x-input id="username" class="block mt-1 w-full" type="text" name="username" value="{{ $user->username }}" required autofocus />
                                </div> --}}

                                <!--  Title -->
                                <div class="mt-4">
                                    <x-label for="title" :value="__('Title')" />
                                    <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{$question->title}}" required />
                                </div>
            
                                <div class="mt-4 text-center">
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
                                    <div class="mt-1">
                                        <x-label for="file" :value="__('File')" />
                                        <x-input id="file" class="block mt-1 w-full" type="file" name="file" required />
                                    </div>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <x-button class="ml-4">
                                        {{ __('Update') }}
                                    </x-button>
                                </div>
                            </div>
                        </form>
                    </div> 
                </div>              
            </div>
        </div>
    </div>
</x-app-layout>