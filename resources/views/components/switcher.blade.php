@props(['activate', 'id', 'question', 'response'])

@if(isset($question))
    @php 
        $action = route('questions.update_is_active');
        $style = "activate-switcher"
    @endphp
@endif
@if(isset($response))
    @php 
        $action = route('responses.update_is_active');
        $style = "activate-switcher"
    @endphp
@endif

<form 
    action="{{ $action }}" 
    class="{{ $style }} z-index-1 {{ $activate }}" 
    id="{{ $id }}"
    question_id="{{ $question }}"
    method="POST"
    >
    @csrf
    @method('patch')
    <span class="ball"></span>
</form>
