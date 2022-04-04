<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    @if ($errors->any())
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <ul>
                            <li>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="w-96 mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-back-button />
                    <div>
                        <div class="text-center">
                            <h1 class="primary-title">{{ __('Users Edit Password') }}</h1>
                        </div>
                    </div>
                    
                    <div class="container mx-auto">
                        <form id="form_update_users" class="form_update_users" action="{{ route('users.update_password', $user->id) }}"  method="POST"
                        enctype="multipart/form-data" 
                        with-wysiwyg
                        >
                        @csrf
                        @method('PUT')
                            <div class="mb-3">

                                <!-- Password -->
                                <div class="mt-4">
                                    <x-label for="password" :value="__('Password')" />

                                    <x-input id="password" class="block mt-1 w-full"
                                                    type="password"
                                                    name="password"
                                                    required autocomplete="new-password" />
                                </div>

                                <!-- Confirm Password -->
                                <div class="mt-4">
                                    <x-label for="password_confirmation" :value="__('Confirm Password')" />

                                    <x-input id="password_confirmation" class="block mt-1 w-full"
                                                    type="password"
                                                    name="password_confirmation" required />
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
