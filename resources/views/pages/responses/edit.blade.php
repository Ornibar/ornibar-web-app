<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Responses') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="w-96 mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-back-button />
                    <div>
                        <div class="text-center">
                            <h1 class="primary-title">{{ __('Response Edit') }}</h1>
                        </div>
                    </div>
                    
                    <div class="container mx-auto">
                        <form id="form_update_responses" class="form_update_responses" action="{{ route('responses.update', $response->id) }}"  method="POST"
                        enctype="multipart/form-data" 
                        with-wysiwyg
                        >
                        @csrf
                        @method('PUT')
                            <div class="mb-3">
                                <!--  Name -->
                                <div class="mt-4">
                                    <x-label for="name" :value="__('Name')" />
                                    <x-input id="title" class="block mt-1 w-full" type="text" name="name" value="{{$response->name}}" required />
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