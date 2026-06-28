$(document).ready(function() {
    $('#ifsc').focus(function() {
        $(this).addClass('custom-focus-border');
    });

    $('#ifsc').blur(function() {
        $(this).removeClass('custom-focus-border');
    });

    $('#account_no').focus(function() {
        $(this).addClass('custom-focus-border');
    });

    $('#account_no').blur(function() {
        $(this).removeClass('custom-focus-border');
    });

    $('#account_no_confirmation').focus(function() {
        $(this).addClass('custom-focus-border');
    });

    $('#account_no_confirmation').blur(function() {
        $(this).removeClass('custom-focus-border');
    });
});
