@include('components.header')

@if (session('toast_success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('toast_success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
@endif




@yield('style')

@include('components.login-component')

@yield('content')

@include('components.footer')


@yield('footer')
