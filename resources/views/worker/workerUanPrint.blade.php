<html>

<head>
    <style type='text/css'>
        body,
        html {
            margin: 0;
            padding: 0;

        }

        body {
            color: black;
            display: table;
            font-family: Georgia, serif;
            font-size: 24px;
            text-align: center;
        }

        .container {
            border: 20px solid cadetblue;
            width: 750px;
            height: 563px;
            display: table-cell;
            vertical-align: middle;
        }

        .logo {
            color: tan;
        }

        .marquee {
            color: deepskyblue;
            font-size: 48px;
            margin: 20px;
        }

        .assignment {
            margin: 20px;
        }

        .person {
            border-bottom: 2px solid black;
            font-size: 32px;
            font-style: italic;
            margin: 20px auto;
            width: 400px;
        }

        .reason {
            margin: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="logo">
                    Labour Commissioner Presents
                </div>

                <div class="marquee">
                    Certificate of Completion Registration
                </div>

                <div class="assignment">
                    This certificate is presented to
                </div>

                <div class="person">
                    {{ $workerData->firstname }} {{ $workerData->lastname }}
                </div>

                <div class="reason">
                    UAN Number is {{ $workerData->uan }}
                </div>
            </div>
        </div>

    </div>
</body>

</html>
