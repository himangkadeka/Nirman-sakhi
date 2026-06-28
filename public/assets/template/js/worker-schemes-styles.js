$(document).ready(function() {

    $('#Schemes').focus(function() {
        $(this).addClass('custom-focus-border');
    });

    $('#Schemes').blur(function() {
        $(this).removeClass('custom-focus-border');
    });

    $('#registrationid').focus(function() {
        $(this).addClass('custom-focus-border');
    });

    $('#registrationid').blur(function() {
        $(this).removeClass('custom-focus-border');
    });

    $('#date').focus(function() {
        $(this).addClass('custom-focus-border');
    });

    $('#date').blur(function() {
        $(this).removeClass('custom-focus-border');
    });

});
