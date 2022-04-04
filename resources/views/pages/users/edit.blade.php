<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>


     @if (session('error'))
        <div class="weaver-container">
            <div class="bg-white p-x-4 p-y-3 m-y-5 radius-10 box-shadow">
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif

    @if ($errors && count($errors->all()) > 0)
        <div class="weaver-container">
            <div class="bg-white p-x-4 p-y-3 m-y-5 radius-10 box-shadow">
                @foreach ($errors->all() as $message)
                    <div class="alert alert-error error-color">
                        {{ $message }}
                    </div>
                @endforeach
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
                            <h1 class="primary-title">{{ __('Users Edit') }}</h1>
                        </div>
                    </div>
                    
                    <div class="container mx-auto">
                        <form id="form_update_users" class="form_update_users" action="{{ route('users.update', $user->id) }}"  method="POST"
                        enctype="multipart/form-data" 
                        with-wysiwyg
                        >
                        @csrf
                        @method('PUT')
                            <div class="mb-3">

                                {{-- @php dd($user); @endphp --}}
                                <!-- Username -->
                                <div class="mt-4">
                                    <x-label for="username" :value="__('Username')" />
                                    <x-input id="username" class="block mt-1 w-full" type="text" name="username" value="{{ $user->username }}" required autofocus />
                                </div>

                                <!-- Email Address -->
                                <div class="mt-4">
                                    <x-label for="email" :value="__('Email')" />
                                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{$user->email}}" required />
                                </div>

                                <!-- Role  -->
                                <div class="mt-4">
                                    <x-label for="role" :value="__('Admin')" />  
                                    {{-- <input class="hidden-checkbox" type="hidden" value="0" name="is_admin">                  --}}
                                    <input class="checkbox" type="checkbox" name="is_admin" <?= $user->is_admin == 1 ? 'checked' : '' ?> />
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