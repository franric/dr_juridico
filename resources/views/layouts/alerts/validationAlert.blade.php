<script>

    @if(count($errors) != 0)
        @foreach ($errors->all() as $error)

            $(document).ready(function(){
                toastr.error('{{ $error }}');
            });

        @endforeach
    @endif

</script>
