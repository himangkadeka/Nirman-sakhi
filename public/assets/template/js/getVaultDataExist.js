// $(document).ready(function(){
//     var csrfToken = $('meta[name="csrf-token"]').attr('content');
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': csrfToken
//         }
//     });
//     $.ajax({
//         url: 'get-vault-data-exist',  // Your Laravel endpoint
//         type: 'POST',
//         dataType: 'json',
//         success: function(response) {
//
//         },
//         error: function(xhr) {
//             if (xhr.status >= 500) {
//                 toastr.error('Server error, please try again later.');
//             } else {
//                 toastr.error('An error occurred, please try again.');
//             }
//         }
//     });
// });
//
//
