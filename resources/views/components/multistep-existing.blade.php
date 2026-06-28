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
            margin-bottom: 30px;
            overflow: hidden;
            counter-reset: step;
            display: flex;
            justify-content: space-between;
            /* Distribute items evenly */
            list-style-type: none;
            padding: 0;
        }

        #progressbar li {
            color: #2C3E50;
            font-size: 15px;
            width: calc(100% / 8 + 10px);
            /* Divide equally for all steps */
            position: relative;
            text-align: center;
            transition: all 0.3s ease;
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

        /* progressbar connectors */
        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: #2C3E50;
            position: absolute;
            left: -59%;
            top: 17px;
            z-index: -1;
            /* put it behind the numbers */
            transition: all 0.3s ease;
        }

        #progressbar li:first-child:after {
            /* connector not needed before the first step */
            content: none;
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            color: white;
            background-color: green;
        }

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
                <form id="msform" >
                    <ul id="progressbar">
                        <li>Basic Details</li>
                        <li>Worker Address</li>
                        <li>Bank Details</li>
                        <li>Family Details</li>
                        <li>Scheme Details</li>
                        <li>Upload Documents</li>
                        <li>Final Submit</li>
                    </ul>
                </form>
            </div>
        </div>
    </div>

    <script>
        var currentUrl = window.location.href;
        var stepUrls = [
            '{{ route("submit-basic-page") }}',
            '{{ route("submit-existing-basic-details") }}',
            '{{ route("submit-worker-address-details") }}',
            '{{ route("submit-bank-details") }}',
            '{{ route("submit-existing-employers") }}',
            '{{ route("submit-existing-schemes") }}',
            '{{ route("submit-existing-documents") }}'
        ];

        var currentIndex = stepUrls.indexOf(currentUrl);
        console.log(currentUrl);

        var progressBarItems = document.querySelectorAll('#progressbar li');
        progressBarItems.forEach(function(item, index) {
            if (index === currentIndex) {
                item.classList.add('current');
            } else if (index < currentIndex) {
                item.classList.add('completed');
            } else {
                item.classList.remove('current', 'completed');
            }
        });
    </script>
</body>

</html>


