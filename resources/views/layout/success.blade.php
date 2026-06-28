
<!DOCTYPE html>
<html>
<head>
    <title>Success</title>
</head>
<body>
    <div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <p>{{ session('success') }}</p>
        <a href="{{ route('genuan') }}" class="btn btn-success">Print Acknowledgement</a>

</div>
</body>
</html>
