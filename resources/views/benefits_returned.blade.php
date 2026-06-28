@extends('layouts.user-app')

@section('title', ' About Us | Benefits Returned')

@section('style')

    <style>
        .district-link {
            padding: 10% 5%;
        }

        .table td a {
            color: red !important;
            text-decoration: none;
        }

        .table td a:hover {
            color: blue !important;
            text-decoration: none;
        }



        section.background {
            width: 100%;
            padding: 50px 0px;

            position: relative;
        }

        section.background .box {
            margin: 0 auto;
            width: 80%;
            display: block;
            background: white;
            padding: 20px;
            box-sizing: border-box;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        }

        @media(min-width:1600px) {
            section.background .box {
                width: 60%;
                display: block;
            }
        }

        section.background .box ul {
            padding: 0px;
            margin: 0px;
            list-style: none;
            counter-reset: list-counter;
        }

        section.background .box ul li {
            counter-increment: list-counter;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: #f9f9f9;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: 0.4s linear;
        }

        section.background .box ul li:hover {
            background: #dddddd;
        }

        .container {
            display: flex;
        }

        .sidebar {
            border-right: 2px solid #ccc;
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
            background-color: white;

            padding-top: 20px;
            padding-bottom: 0px;
            /* Removed unnecessary bottom padding */
            border-radius: 0;
            width: 20%;

            display: flex;
            flex-direction: column;
            min-height: auto;
            /* Height adjusts dynamically */
        }

        .sidebar nav {
            flex-grow: 1;
            /* Ensures sidebar grows with content */
            border-bottom: 1px solid #ccc;
            /* Keeps the bottom border only within content */
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
        }

        .sidebar ul li:last-child {
            border-bottom: none;
            /* Removes the bottom border from the last item */
        }



        .sidebar .nav-link {
            display: block;
            padding: 10px 20px;
            border-bottom: 1px solid #eee;
            color: black;
            cursor: pointer;

        }

        .sidebar .nav-link.active {
            color: #007bff;
            font-weight: bold;
        }


        .table td {
            border: 1px solid #ccc;

        }



        .content {
            flex-grow: 1;
            padding: 10px;
        }

        .content h2 {
            border-bottom: 2px solid #007bff;
            width: 40%;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .content h4 {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 30px;
            color: #454141;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            /* Ensures borders collapse into a single line */
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            /* Thin light border */
            padding: 8px;
            /* Adds padding inside each cell for better readability */
            text-align: left;
            /* Aligns the text to the left in the cells */
        }

        .table th {
            background-color: #f5f5f5;
            /* Light background for headers */
        }

        .last-updated {
            position: absolute;

            bottom: 80%;

            right: 10%;

            font-size: 12px;

            color: gray;

        }

        .tab-content {
            /* display: none; */
            border-left: 1px;
        }

        .tab-content.active {
            display: block;
        }




        .returnletter {

            padding: 3px 0px;
            margin-top: 15px;
        }

        .returnletter a {
            color: red;
            font-size: 16px
        }

        .returnletter a:hover {
            color: blue;
            text-shadow: none;
            text-decoration: none;
        }

        .navbar,
        .sticky-top {
            overflow: visible;
        }
    </style>
@endsection

@section('content')

    <section class="background">
        <div class="container">
            <div class="pagination text-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="#">Schemes and Benefits</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: green;">List of Benefits Returned
                        </li>
                        <li class="breadcrumb-item active" aria-current="page" id="year_return">Year {{ $year }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="sidebar" style="width: 20%;">
                <nav class="nav flex-column">
                    <a class="nav-link active" onclick="showTab('home')">Home &rsaquo;</a>

                    @if ($districts->isNotEmpty())
                        <ul id="district_code" style=" list-style: none;  padding: 0; ">
                            @foreach ($districts as $district)
                                <li class="border-bottom py-2">
                                    <a href="javascript:void(0);" class="district-link"
                                        data-district="{{ $district->district_code }}">
                                        {{ $district->district_name }}&rsaquo;
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No districts found with notifications.</p>
                    @endif
                </nav>
            </div>
            <div class="content">
                {{-- Home Heading --}}
                <div class="mx-5" style="display: none; margin-top: 4.5%;" id="home-content">
                    <h4>BENEFITS RETURNED IN THE YEAR {{ $year }}</h4>
                </div>

                {{-- Table: initially hidden --}}
                <div class="tab-content mx-5" id="table-content" style="display: none; margin-top: 4.5%;">
                    <h4 id="selected-district-name"></h4>

                    <table class="table">
                        <thead class="text-primary">
                            <tr>
                                <th>Sno.</th>
                                <th>Title</th>
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody id="district-files-body">
                            <tr>
                                <td colspan="3">Please select a district to view files.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            {{-- <div id="home-content">
                <h4>BENEFITS RETURNED IN THE YEAR {{ $year }}</h4>
            </div>
            <div id="table-content" style="display: none;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sno.</th>
                            <th>Title</th>
                            <th>Downloads</th>
                        </tr>
                    </thead>
                    <tbody id="district-files-body">
                        <tr>
                            <td></td>
                            <td></td>

                        </tr>
                    </tbody>
                </table>

            </div> --}}

        </div>
    </section>


@endsection


@section('footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $(document).on("click", ".district-link", function(e) {
                e.preventDefault(); // Prevent page reload

                let districtCode = $(this).data("district");
                let year = $("#year_return").text().replace("Year ", "").trim();
                let tbody = $("#district-files-body");

                $.ajax({
                    url: "/about/schemesandbenefits/district-files",
                    type: "GET",
                    data: {
                        district_code: districtCode,
                        year: year
                    },
                    beforeSend: function() {
                        tbody.html('<tr><td colspan="3">Loading...</td></tr>');
                    },
                    success: function(response) {
                        tbody.empty(); // Clear previous data
                        console.log(response);
                        if (!response.length) {
                            tbody.append('<tr><td colspan="3">No data found</td></tr>');
                            return;
                        }

                        $.each(response, function(index, file) {
                            let pdfPath = file.pdf_path ? file.pdf_path.trim() : "#";
                            let fullPdfPath = pdfPath.startsWith("/") ? pdfPath : "/" +
                                pdfPath;

                            let row = `
        <tr>
            <td class="text-primary">${index + 1}</td>
            <td class="text-primary">${file.caption}</td>
            <td><a href="${encodeURI(fullPdfPath)}" target="_blank">Return Letter</a></td>
        </tr>
    `;

                            $("#district-files-body").append(row);
                        });

                    },
                    error: function() {
                        tbody.html('<tr><td colspan="3">Error fetching data</td></tr>');
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // On page load
            $('#home-content').show();
            $('#table-content').hide();

            // Clicking "Home"
            $(document).on('click', '.nav-link', function() {
                let label = $(this).text().trim();
                if (label.includes("Home")) {
                    $('#home-content').show();
                    $('#table-content').hide();
                    $('#district-files-body').html(
                        '<tr><td colspan="3">Please select a district to view files.</td></tr>');
                }
            });

            // Clicking a district
            $(document).on("click", ".district-link", function(e) {
                e.preventDefault();

                let districtCode = $(this).data("district");
                let year = $("#year_return").text().replace("Year ", "").trim();
                let tbody = $("#district-files-body");

                // Show table, hide home
                $('#home-content').hide();
                $('#table-content').show();

                let selectedDistrictName = $(this).text().replace('›', '').trim();
                $("#selected-district-name").text(
                    ` ${selectedDistrictName.toUpperCase()} DISTRICT, ${year}`);


                $.ajax({
                    url: "/about/schemesandbenefits/district-files",
                    type: "GET",
                    data: {
                        district_code: districtCode,
                        year: year
                    },
                    beforeSend: function() {
                        tbody.html('<tr><td colspan="3">Loading...</td></tr>');
                    },
                    success: function(response) {
                        tbody.empty();

                        if (!response.length) {
                            tbody.append('<tr><td colspan="3">No data found</td></tr>');
                            return;
                        }

                        $.each(response, function(index, file) {
                            let pdfPath = file.pdf_path ? file.pdf_path.trim() : "#";
                            let fullPdfPath = pdfPath.startsWith("/") ? pdfPath : "/" +
                                pdfPath;

                            let row = `
                            <tr>
                                <td class="text-primary">${index + 1}</td>
                                <td class="text-primary">${file.caption}</td>
                                <td><a href="${encodeURI(fullPdfPath)}" target="_blank">Return Letter</a></td>
                            </tr>
                        `;
                            tbody.append(row);
                        });
                    },
                    error: function() {
                        tbody.html('<tr><td colspan="3">Error fetching data</td></tr>');
                    }
                });
            });
        });
    </script>


    {{-- <script>
        // Target the tbody element
        const tbody = document.getElementById("district-files-body");

        // Clear existing rows
        tbody.innerHTML = "";

        // Populate table with data
        response.forEach((item, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
        <td>${index + 1}</td>
        <td>${item.caption}</td>
        <td><a href="${item.pdf_path}" target="_blank" download>Download</a></td>
    `;
            tbody.appendChild(row);
        });
    </script> --}}


@endsection
