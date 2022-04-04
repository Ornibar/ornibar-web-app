<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
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
                            <h1 class="primary-title">{{ __('Users List') }}</h1>
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="secondary-title">
                            <strong>{{ count($allUsers) }}</strong> utilisateurs inscrits.
                        </h2>        
                        <form id="form_filter_users" class="form_filter_users" action="{{ route('users.index') }}" method="GET">
                            <div class="mb-3">
                                <div class="flex justify-between items-center ">
                                    <div class="flex justify-between items-center gap-2">
                                        @if(@isset($currentValues['role']))
                                            @if($currentValues['role'] == 1)
                                                @php $currentValues['role'] = 'Admin' @endphp
                                            @elseif($currentValues['role'] == 0)
                                                @php $currentValues['role'] = 'User' @endphp
                                            @else
                                                @php $currentValues['role'] = 'Any Role' @endphp
                                            @endif
                                        @else 
                                            @php $currentValues['role'] = 'Any Role' @endphp
                                        @endif
                                        <label for="role">Role: {{$currentValues['role']}} </label> 
                                        <select name="role" class="form-control w-50">
                                            <option value="Any Role" selected>Tous</option>
                                            <option value="1">Admin</option>
                                            <option value="0">User</option>
                                        </select>
                                    </div>    
                                    <div class="flex justify-between items-center gap-2">
                                        <x-label for="paginate" :value="__('Number per pages')" />
                                        <x-input type="number" name="paginate" class="w-50"  value="{{ isset($currentValues['paginate']) ? $currentValues['paginate'] : '100' }}" oninput="this.value = 
                                        !!this.value && Math.abs(this.value) > 0 ? Math.abs(this.value) : null"/>
                                    </div> 
                                    <div class="flex justify-between items-center gap-2">
                                        <div class="attr-sizes">
                                            <x-input type="text" name="search-user" class="w-100" :placeholder="__('Search by firstname')"/>               
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
                                    <th>Id</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Admin</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filteredUsers as $user)
                                        <tr>
                                            <td>
                                                {{ $user->id }}
                                            </td>
                                            <td>
                                                {{ $user->lastname }}
                                            </td>
                                            <td>
                                                {{ $user->firstname }}
                                            </td>
                                            <td>
                                                {{ $user->username }}
                                            </td>
                                            <td>
                                                {{ $user->email}}
                                            </td>
                                            <td>
                                                {{ $user->is_admin == 1 ? 'Admin': 'User'}}
                                            </td>
                                            <td>
                                                <div class="flex justify-center gap-4">
                                                    <button id="delete_form_btn" class="icon-btn" title="delete user"><i class="fas fa-trash"></i></button>
                                                    <a href="{{ route('users.edit', $user->id) }}" class="icon-btn" title="edit user"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('users.edit_password', $user->id) }}" class="icon-btn" title="edit password user"><i class="fas fa-key"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center mt-5">
                            @if(count($filteredUsers) == 0)
                                {{ 'Aucun résultat' }}
                            @endif 
                        </div>
                        <div class="laravel-pagination">
                            {!! $filteredUsers->appends(Request::all())->links() !!}
                        </div> 
                    </div> 
                </div>              
            </div>
        </div>
    </div>

    <x-confirm-modal :visible="'false'" :title="'Dialog Confirmation'" :message="'Are you sure to want delete this user ?'" :action="route('users.destroy', $user->id)" :method="'post'"/>
</x-app-layout>