<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TEST SITE</title>
</head>

<body>
    <div class="container">
        <div class="centre">
            <h1>This is a Test Site. To Accces this site please enter the password</h1>
        </div>

        <form action="{{ route('test-site') }}" method="post">
            @csrf
            Password: <input type="password" name="password" id="" required>
            <button type="submit">Submit</button>
        </form>

    </div>
</body>

</html>
