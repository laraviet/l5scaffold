@if(count($errors->all()))
<section class="error-box">
    <h3>!!ERROR!!</h3>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</section>
@endif