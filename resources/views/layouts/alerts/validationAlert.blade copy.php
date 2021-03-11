@if(count($errors) != 0)
    <div class="box-body">
        <div class="alert alert-danger flat" >
            @foreach ($errors->all() as $error)
                <p><i class="fa fa-times"></i> {{ $error }}</p>
            @endforeach
        </div>
    </div>
@endif
