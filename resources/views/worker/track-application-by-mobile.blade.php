@extends('layouts.user-app') {{-- Or your preferred base layout --}}

@section('styles')
    <style>
        /* A clean and standard background */
        body {
            background-color: #f4f7fc;
        }

        .tracking-container {
            /*max-width: 700px;*/
            margin-top: 50px;
        }

        .tracking-card {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
        }

        .tracking-card .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e7eaf3;
            font-weight: 600;
            font-size: 1.15rem;
            padding: 1.25rem;
            color: #333;
        }

        .tracking-card .card-header i {
            margin-right: 8px;
            color: #0d6efd;
        }

        /* Standard Bootstrap input group styling */
        .input-group-text {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        /* Standard button styling */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary .spinner-border {
            margin-left: 8px;
        }

        #results-container .alert {
            display: flex;
            align-items: center;
        }

        #results-container .alert i {
            margin-right: 12px;
            font-size: 1.2rem;
        }

        /* Styling for the results cards */
        .status-card {
            border-left-width: 4px;
            border-radius: 8px;
            margin-bottom: 1rem;
            padding: 1.25rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            background-color: #fff;
        }

        .status-approved { border-left-color: #198754; } /* Green */
        .status-pending { border-left-color: #ffc107; } /* Yellow */
        .status-rejected { border-left-color: #dc3545; } /* Red */
        .status-default { border-left-color: #6c757d; } /* Grey */

        .status-heading {
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .status-heading i {
            font-size: 1.2rem;
            margin-right: 10px;
        }

        .status-approved .status-heading { color: #198754; }
        .status-pending .status-heading { color: #ffc107; }
        .status-rejected .status-heading { color: #dc3545; }
        .status-default .status-heading { color: #6c757d; }

        .application-details p {
            margin-bottom: 0.25rem;
            color: #555;
        }

    </style>
    {{-- Include FontAwesome for icons --}}
@endsection

@section('content')
    <div class="container tracking-container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card tracking-card">
                    <div class="card-header">
                        <i class="fas fa-search"></i>
                        {{ __('Track Your Application Status') }}
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-4">Enter the mobile number you used during registration to check the status of your application(s).</p>

                        <form id="trackingForm">
                            @csrf
                            <div class="form-group col-md-4 mb-3">
                                <label for="mobile_number" class="form-label fw-bold">{{ __('Mobile Number') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                    <input id="mobile_number" type="tel" class="form-control" name="mobile_number" placeholder="Enter 10-digit mobile number" required>
                                </div>
                            </div>
                            <div class="form-group text-end mb-0">
                                <button type="submit" class="btn btn-primary" id="trackBtn">
                                    <span id="btn-text"><i class="fas fa-search"></i> Track</span>
                                    <span class="spinner-border spinner-border-sm d-none" id="loader" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="results-container" class="mt-4">
                    {{-- AJAX results will be displayed here --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    {{-- Ensure jQuery is loaded in your main app layout --}}
    <script>
        $(document).ready(function() {
            // AJAX call to get the initial list of applications
            $('#trackingForm').on('submit', function(e) {
                e.preventDefault();
                var trackBtn = $('#trackBtn'), btnText = $('#btn-text'), loader = $('#loader'), resultsContainer = $('#results-container');
                trackBtn.prop('disabled', true);
                btnText.addClass('d-none');
                loader.removeClass('d-none');
                resultsContainer.html('');

                $.ajax({
                    url: '{{ route("home.track-by-mobile") }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success && response.applications.length > 0) {
                            var applications = response.applications;
                            var html = '<h4>Your Applications</h4><ul class="list-group">';
                            applications.forEach(function(app) {
                                // Sanitize ack_no for use in an ID attribute
                                var sanitizedAckNo = (app.ack_no || 'N-A').replace(/[^a-zA-Z0-9]/g, '');

                                html += `<li class="list-group-item">
                                    <strong>Application No:</strong> ${app.application_no || 'N/A'}<br>
                                    <strong>Ack No:</strong> ${app.ack_no || 'N/A'}<br>
                                    <strong>Current Status:</strong> ${app.application_status || 'N/A'}<br>
                                    <strong>Remarks:</strong> ${app.remarks || 'None'}<br>
                                    <button class="btn btn-secondary btn-sm mt-2 details-btn" data-ack-no="${app.ack_no}">
                                        <span class="btn-text-details">Get More Details</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                    <div class="details-container mt-3" id="details-${sanitizedAckNo}" style="display:none;"></div>
                                 </li>`;
                            });
                            html += '</ul>';
                            resultsContainer.html(html);
                        } else {
                            resultsContainer.html('<div class="alert alert-danger">' + (response.error || 'No applications found.') + '</div>');
                        }
                    },
                    error: function(xhr) {
                        var error = (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error : 'An unexpected error occurred.';
                        resultsContainer.html(`<div class="alert alert-danger">${error}</div>`);
                    },
                    complete: function() {
                        trackBtn.prop('disabled', false);
                        loader.addClass('d-none');
                        btnText.removeClass('d-none');
                    }
                });
            });

            // NEW: Event listener for the "Get More Details" button (delegated)
            $('#results-container').on('click', '.details-btn', function() {
                var detailsBtn = $(this);
                var ackNo = detailsBtn.data('ack-no');
                var sanitizedAckNo = (ackNo || 'N-A').replace(/[^a-zA-Z0-9]/g, '');
                var detailsContainer = $('#details-' + sanitizedAckNo);

                // If details are already visible, hide them and reset the button text
                if (detailsContainer.is(':visible')) {
                    detailsContainer.slideUp();
                    detailsBtn.find('.btn-text-details').text('Get More Details');
                    return;
                }

                var btnText = detailsBtn.find('.btn-text-details');
                var loader = detailsBtn.find('.spinner-border');

                detailsBtn.prop('disabled', true);
                btnText.text('Loading...');
                loader.removeClass('d-none');
                detailsContainer.html('');

                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ack_no: ackNo
                    },
                    success: function(response) {
                        if (response.success && response.details.length > 0) {
                            var details = response.details;
                            var detailsHtml = '<h6>Detailed Status History:</h6><ul class="list-group list-group-flush">';
                            details.forEach(function(detail) {
                                var eventDate = detail.timestamp ? new Date(detail.timestamp).toLocaleString() : 'N/A';
                                detailsHtml += `<li class="list-group-item">
                                            <p class="mb-0"><strong>Status:</strong> ${detail.application_status}</p>
                                            <p class="mb-0"><strong>Remarks:</strong> ${detail.remarks || 'N/A'}</p>
                                            <small class="text-muted">Date: ${eventDate}</small>
                                        </li>`;
                            });
                            detailsHtml += '</ul>';
                            detailsContainer.html(detailsHtml).slideDown();
                            btnText.text('Hide Details'); // Update button to allow hiding
                        }
                    },
                    error: function(xhr) {
                        var error = (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error : 'Could not fetch details.';
                        detailsContainer.html(`<div class="alert alert-warning">${error}</div>`).slideDown();
                        btnText.text('Get More Details'); // Reset button text on error
                    },
                    complete: function() {
                        detailsBtn.prop('disabled', false);
                        loader.addClass('d-none');
                    }
                });
            });
        });
    </script>
@endsection