<script>

    @if(session('success') != null)

        @if(session('success')['success'])
            $(document).ready(function(){

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 2000
                  });


                    Toast.fire({
                      type: 'success',
                      title: ' {{ session('success')['messages'] }}'
                    })


                /*swal("Sucesso", "{{ session('success')['messages'] }}", "success",
                {
                    buttons: false,
                    timer: 2000,
                })*/
            });
        @else
            $(document).ready(function(){

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 2000
                  });


                  Toast.fire({
                      type: 'error',
                      title: " {{ session('success')['messages'] }}"
                    })

                    //swal("Atenção", "{{ session('success')['messages'] }}", "error");

            });
        @endif
    @endif
</script>
