<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('assets/template/vendor/fontawesome-free/css/all.min.css')}}">


    <title>Multi-Step Form</title>
    <style>
        /* custom font */
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        /* form styles */
        #msform {
            text-align: center;
            position: relative;
            margin-top: 30px;
        }

        /* progressbar */
        #progressbar {
            display: flex;
            justify-content: space-between;
            padding: 0;
            list-style-type: none;
            counter-reset: step;
        }

        #progressbar li {
            flex: 1;
            position: relative;
            text-align: center;
            font-size: 14px;
        }


        /* Font Awesome icons for steps */
        #progressbar li:before {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            display: block;
            font-size: 14px;
            color: #333;
            background: white;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            transition: all 0.3s ease;
            width: 36px;
            height: 36px;
            line-height: 36px;
        }

        /* Icons for specific steps */
        #progressbar li:nth-child(1):before {
            content: '\f007';
            /* fa-user */
        }

        #progressbar li:nth-child(2):before {
            content: '\f015';
            /* fa-home */
        }

        #progressbar li:nth-child(3):before {
            content: '\f19c';
            /* fa-university */
        }

        #progressbar li:nth-child(4):before {
            content: '\f0c0';
            /* fa-users */
        }

        #progressbar li:nth-child(5):before {
            content: '\f1ad';
            /* fa-briefcase */
        }

        #progressbar li:nth-child(6):before {
            content: '\f543';
            /* fa-file-alt */
        }

        #progressbar li:nth-child(7):before {
            content: '\f093';
            /* fa-upload */
        }

        #progressbar li:nth-child(8):before {
            content: '\f00c';
            /* fa-check */
        }

        #progressbar li:nth-child(9):before {
            content: '\f09d';
            /* fa-credit-card */
        }


        /* progressbar connectors */
        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: #2C3E50;
            position: absolute;
            left: -50%;
            top: 17px;
            z-index: -1;
            /* put it behind the numbers */
            transition: all 0.3s ease;
        }

        #progressbar li:first-child:after {
            /* connector not needed before the first step */
            content: none;
        }

        /* marking active step green */
        /* The number of the step and the connector before it = green */
        #progressbar li.active:before,
        #progressbar li.active:after {
            color: white;
            background-color: green;
        }

        /* marking completed steps gray */
        /* The number of the step and the connector before it = gray */
        #progressbar li.completed:before,
        #progressbar li.completed:after {
            color: #fff;
            background-color: green;
        }

        /* marking current step different color */
        #progressbar li.current:before {
            color: white;
            background-color: blue;
            /* Change to the desired color */
        }

        /* hover effect */
        #progressbar li:hover:not(.completed):not(.current):before {
            background-color: #3498db;
            color: white;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            #progressbar li {
                font-size: 10px;
            }

            #progressbar li:before {
                width: 24px;
                height: 24px;
                line-height: 24px;
            }

            #progressbar li:after {
                top: 13px;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid mb-4">
        <div class="row ">
            <div class="col-md-12">
                <form id="msform">
                    <!-- progressbar -->
                    <ul id="progressbar">
                        <li>Basic Details</li>
                        <li>Worker Address</li>
                        <li>Bank Details</li>
                        <li>Family Details</li>
                        <li>Certificate Details</li>
                        <li>Scheme Details</li>
                        <li>Upload Documents</li>
                        <li>Final Preview</li>
                        <li>Payment</li>
                    </ul>
                    <!-- fieldsets -->
                </form>
                <!-- link to designify.me code snippets -->
                <!-- /.link to designify.me code snippets -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var currentUrl = window.location.href;
            var stepUrls = [
                '{{ route('main-page') }}',
                '{{ route('submit-basic-details') }}',
                '{{ route('save-address') }}',
                '{{ route('submit-bank') }}',
                '{{ route('submit-family-details') }}',
                '{{ route('submit-employer-details') }}',
                '{{ route('submit-schemes-details') }}',
                '{{ route('submit-document-details') }}',
                '{{ route('submit-worker-payment') }}',
            ];

            var currentIndex = stepUrls.indexOf(currentUrl);
            console.log("Current URL:", currentUrl);
            console.log("Current Index:", currentIndex);

            var progressBarItems = document.querySelectorAll('#progressbar li');

            progressBarItems.forEach(function (item, index) {
                if (index === currentIndex) {
                    item.classList.add('current');
                } else if (index < currentIndex) {
                    item.classList.add('completed');
                } else {
                    item.classList.remove('current', 'completed');
                }
            });
        });
    </script>
</body>

</html>
