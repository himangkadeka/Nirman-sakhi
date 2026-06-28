<!DOCTYPE html>
<html>
<head>
    <title>{{ $customSubject }}</title>
</head>
<body>
    <p>Dear Scrutiny Committee,</p>

    {{-- nl2br converts newlines to <br> tags, e() prevents XSS attacks --}}
    <p>{!! nl2br(e($customMessage)) !!}</p>

    <p>The list of applications requiring review is attached to this email for your convenience.</p>

    <p>Thank you,</p>
    {{-- You can make this dynamic if needed, e.g., Auth::user()->office->name --}}
    <p>HRO, {{ Auth::user()->office->office_name ?? 'System Administrator' }}</p>
</body>
</html>
