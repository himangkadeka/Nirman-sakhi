<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to Payment Gateway</title>
    <script src="{{ URL::asset('assets/template/js/jquery-3.7.0.js') }}"></script>
</head>
<body>
<p>Wait while we are redirecting you to payment gateway</p>

<form method="post" action="https://wallet.csccloud.in/v1/payment/<?php echo $frac;?>" id="myform" style="display:none">
{{--<form method="post" action="https://payuat.csccloud.in/v1/payment/<?php echo $frac;?>" id="myform" style="display:none">--}}
    <input type="hidden" name="message" value="<?=$enc_text;?>" />
    <input type="submit" value="Pay" id="pay" />
</form>

<script type="text/javascript">
    $(document).ready(function(){
        $('#myform').submit();
    });
</script>
</body>
</html>