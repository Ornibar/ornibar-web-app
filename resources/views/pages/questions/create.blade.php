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
                            <h1 class="primary-title">{{ __('Question Create') }}</h1>
                        </div>
                    </div>
                    
                    <div class="container mx-auto">
                        <form id="form_create_questions" class="form_create_questions" action="{{ route('questions.store') }}"  method="POST"
                        enctype="multipart/form-data" 
                        with-wysiwyg
                        >
                        @csrf
                            <div class="mb-3">
                                <!--  Title -->
                                <div class="mt-4">
                                    <x-label for="title" :value="__('Title')" />
                                    <x-input id="title" class="block mt-1 w-full" type="text" name="title" required />
                                </div>

                                <!--  File -->
                                <div class="mt-4">
                                    <x-label for="file" :value="__('File')" />
                                    <x-input id="file" class="block mt-1 w-full" type="file" name="file" required />
                                </div>
                        
                                <div class="flex items-center justify-end mt-4">
                                    <x-button class="ml-4">
                                        {{ __('Add') }}
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