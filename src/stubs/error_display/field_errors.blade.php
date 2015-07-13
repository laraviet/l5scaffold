@if(count($errors->get($field)))
<section class="error-message">
    @foreach($errors->get($field) as $error)
        {{ $error }}
    @endforeach
</section>
@endif