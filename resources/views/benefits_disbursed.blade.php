@extends('layouts.user-app')

@section('title', ' About Us | Benefits Disbursed')

@section('style')

    <style>
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
                        <li class="breadcrumb-item active" aria-current="page" style="color: green;">List of Disbursed Benefits
                        </li>
                        <li class="breadcrumb-item active" aria-current="page" id="year_disbursed">Year {{ $year }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="sidebar" style="width: 25.5%;">
                <nav class="nav flex-column">


                    <a class="nav-link active" onclick="showTab('home')">Home &rsaquo;</a>

                    @if ($benefits->isNotEmpty())
                        <ul id="benefit_id" style=" list-style: none;  padding: 0; ">
                            @foreach ($benefits as $benefit)
                                <li>
                                    <a href="javascript:void(0);" class="benefit-link"
                                        data-benefit="{{ $benefit->benefit_id }}">
                                        {{ $benefit->benefit_name }}&rsaquo;
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    @else
                        <p>No Benefit found with notifications.</p>
                    @endif




                </nav>
            </div>
            <div class="content">
                {{-- Home Section --}}

                <div class="mx-5" style="display: none; margin-top: 4.5%;" id="home-content">
                    <h4>BENEFITS DISBURSED IN THE YEAR {{ $year }}</h4>
                </div>



                {{-- Table Section (Initially hidden) --}}
                <div class="tab-content mx-5" id="table-content" style="display: none; margin-top: 4.5%;">
                    <h4 id="selected-benefit-title" style="margin-bottom: 20px; color: #333;"></h4>
                    <table class="table">
                        <thead class="text-primary">
                            <tr>
                                <th>Sno.</th>
                                <th>Districts</th>
                                <th>Caption</th>
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody id="benefit-files-body">
                            <tr>

                                <td colspan="4">Select a benefit to load files.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initially show home content, hide table
            $('#home-content').show();
            $('#table-content').hide();

            // Handle 'Home' click
            $(document).on('click', '.nav-link', function() {
                const label = $(this).text().trim();
                if (label.includes('Home')) {
                    $('#home-content').show();
                    $('#table-content').hide();
                    $('#benefit-files-body').html(
                        '<tr><td colspan="4">Select a benefit to load files.</td></tr>'
                    );
                }
            });

            // Handle benefit link click
            $(document).on("click", ".benefit-link", function(e) {
                e.preventDefault();

                const benefitId = $(this).data("benefit");
                const year = $("#year_disbursed").text().replace("Year ", "").trim();
                const tbody = $("#benefit-files-body");

                if (!benefitId || !year) {
                    tbody.html('<tr><td colspan="4">Missing benefit ID or year.</td></tr>');
                    return;
                }

                // Show title
                $("#selected-benefit-title").text($(this).text().replace("›", "").trim());

                // Toggle content visibility
                $('#home-content').hide();
                $('#table-content').show();

                $.ajax({
                    url: "/about/schemesandbenefits/benefit-files",
                    type: "GET",
                    data: {
                        benefit_id: benefitId,
                        year: year
                    },
                    beforeSend: function() {
                        tbody.html('<tr><td colspan="4">Loading...</td></tr>');
                    },
                    success: function(response) {
                        tbody.empty();

                        if (!response || !response.length) {
                            tbody.append('<tr><td colspan="4">No districts found.</td></tr>');
                            return;
                        }

                        let groupedByDistrictCaption = {};

                        response.forEach(item => {
                            const district = item.district_name || 'Unknown';
                            const caption = item.caption || 'No Caption';

                            const key = district + '___' + caption;

                            if (!groupedByDistrictCaption[key]) {
                                groupedByDistrictCaption[key] = {
                                    district: district,
                                    caption: caption,
                                    pdfs: []
                                };
                            }

                            if (item.pdf_path) {
                                groupedByDistrictCaption[key].pdfs.push(item.pdf_path);
                            }
                        });

                        // Handle "All Districts" separately
                        let allDistricts = groupedByDistrictCaption[
                            "All Districts___No Caption"] || {
                            district: "All Districts",
                            caption: "No Caption",
                            pdfs: []
                        };

                        const entries = Object.values(groupedByDistrictCaption).sort((a, b) => {
                            const aHasPDF = a.pdfs.length > 0;
                            const bHasPDF = b.pdfs.length > 0;

                            if (aHasPDF !== bHasPDF) {
                                return aHasPDF ? -1 : 1; // PDFs first
                            }

                            return a.district.localeCompare(b
                            .district); // Alphabetical if equal
                        });


                        // Insert "All Districts" entry at the start if it exists
                        if (allDistricts.pdfs.length > 0) {
                            entries.unshift(allDistricts);
                        }

                        let index = 1;

                        entries.forEach(entry => {
                            const district = entry.district;
                            const caption = entry.caption;
                            const pdfLinks = entry.pdfs.map((path, i) => {
                                const fullPath = path.startsWith("/") ? path :
                                    "/" + path;
                                return `<a href="${encodeURI(fullPath)}" target="_blank">List ${i + 1}</a>`;
                            }).join(" | ");

                            tbody.append(`
                                <tr>
                                    <td class="text-primary">${index++}</td>
                                    <td class="text-primary">${district}</td>
                                    <td class="text-primary">${caption}</td>
                                    <td>${pdfLinks || 'No PDF uploaded'}</td>
                                </tr>
                            `);
                        });
                    },
                    error: function(xhr) {
                        console.error("AJAX Error:", xhr.responseText);
                        tbody.html('<tr><td colspan="4">Error loading files.</td></tr>');
                    }
                });
            });
        });
    </script>




    {{-- Display districts Alphabetically --}}
    {{-- <script>
        $(document).ready(function () {
            // Initially show home content, hide table
            $('#home-content').show();
            $('#table-content').hide();

            // Handle 'Home' click
            $(document).on('click', '.nav-link', function () {
                const label = $(this).text().trim();
                if (label.includes('Home')) {
                    $('#home-content').show();
                    $('#table-content').hide();
                    $('#benefit-files-body').html(
                        '<tr><td colspan="4">Select a benefit to load files.</td></tr>'
                    );
                }
            });

            // Handle benefit click
            $(document).on("click", ".benefit-link", function (e) {
                e.preventDefault();

                const benefitId = $(this).data("benefit");
                const year = $("#year_disbursed").text().replace("Year ", "").trim();
                const tbody = $("#benefit-files-body");

                // Show title of benefit
                $("#selected-benefit-title").text($(this).text().replace("›", "").trim());

                // Toggle content visibility
                $('#home-content').hide();
                $('#table-content').show();

                $.ajax({
                    url: "/about/schemesandbenefits/benefit-files",
                    type: "GET",
                    data: {
                        benefit_id: benefitId,
                        year: year
                    },
                    beforeSend: function () {
                        tbody.html('<tr><td colspan="4">Loading...</td></tr>');
                    },
                    success: function (response) {
                        tbody.empty();

                        if (!response.length) {
                            tbody.append('<tr><td colspan="4">No districts found.</td></tr>');
                            return;
                        }

                        let groupedByDistrict = {};

                        // Group data by district
                        response.forEach((item) => {
                            const district = item.district_name || 'Unknown';
                            if (!groupedByDistrict[district]) {
                                groupedByDistrict[district] = [];
                            }

                            if (item.caption && item.pdf_path) {
                                groupedByDistrict[district].push({
                                    caption: item.caption,
                                    path: item.pdf_path
                                });
                            }
                        });

                        let index = 1;

                        // Display each district's data
                        for (let district in groupedByDistrict) {
                            const files = groupedByDistrict[district];

                            if (files.length === 0) {
                                // No PDFs for this district
                                tbody.append(`
                                    <tr>
                                        <td class="text-primary">${index++}</td>
                                        <td class="text-primary">${district}</td>
                                        <td colspan="2">No PDF uploaded</td>
                                    </tr>
                                `);
                            } else {
                                // Display each PDF row
                                files.forEach((file, i) => {
                                    const fullPath = file.path.startsWith("/") ? file.path : "/" + file.path;
                                    tbody.append(`
                                        <tr>
                                            <td class="text-primary">${index++}</td>
                                            <td class="text-primary">${district}</td>
                                            <td class="text-primary">${file.caption}</td>
                                            <td><a href="${encodeURI(fullPath)}" target="_blank">View</a></td>
                                        </tr>
                                    `);
                                });
                            }
                        }
                    },
                    error: function () {
                        tbody.html('<tr><td colspan="4">Error loading files.</td></tr>');
                    }
                });
            });
        });
    </script> --}}


@endsection
