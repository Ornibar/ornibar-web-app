@props(['name', 'label', 'defaultValue'])

<div {!! $attributes->merge(['class' => 'select-input rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
    <div>
        <span class="label">
            {{ $label }}
        </span>
        <span class="icon">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </span>
    </div>
    <ul class="select-options bg-white rounded-md ring-1 ring-black ring-opacity-5">
        {{ $options ?? '' }}
    </ul>
    <input type="hidden" name="{{ $name }}" 
        @isset ($defaultValue)
            value="{{ $defaultValue }}"
        @endisset
    >
</div>
