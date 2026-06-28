
$(document).ready(function() {
    $.ajax({
        url: 'generate-auth-token',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        data: {
            userName: 'anamika.acs@assam.gov.in',
            password: 'eXm2!c$aJo',
        },
        success: function(response) {
            // console.log('Auth Token:', response.authToken);
            // You can now use the auth token as needed
        },
        error: function(xhr, status, error) {
            // console.error('Error:', error);
        }
    });
});

