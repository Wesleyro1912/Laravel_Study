@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: "Pronto!",
                text: "{{ session('success') }}",
                icon: "success"
            });
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: "Error!",
                text: "{{ session('error') }}",
                icon: "error"
            });
        });
    </script>
@endif

@if ($errors->all())
    @php
        $menssage = '';
        foreach ($errors->all() as $error){
            $menssage .= $error . '<br>';
        }
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: "Error!",
                html: "{!! $menssage !!}",
                icon: "error"
            });
        });
    </script>

@endif