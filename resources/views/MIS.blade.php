@extends('layouts.user-app')

@section('title', ' MIS')


@section('style')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .nav-tabs .nav-link {
            margin-right: 10px;
            /* Adds space between the tabs */
        }
    </style>
@endsection


@section('content')

    <div class="container-fluid" id="b-homedb">

        <div class="content">
            <div class="container-fluid mt-4">
                <div class="row">
                    <div class="col-md-2">
                        <div class="card pt-3 px-3 pb-3">
                            <h6>Total Registrations</h6>
                            <h4>{{ $rowCount }}</h4>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card pt-3 px-3 pb-3">
                            <h6>New Registrations</h6>
                            <h4>{{ $totalNew }}</h4>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card  px-3" style="padding-top: 7%;">
                            <h6>Onboarding Registrations</h6>
                            <h4>{{ $totalOnboarding }}</h4>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card px-3" style="padding-top: 7%;">
                            <h6>Total Registrations Approved</h6>
                            <h4>{{ $countApproved }}</h4>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card px-3" style="padding-top: 7%;">
                            <h6>Total Registrations Rejected</h6>
                            <h4>{{ $countRejected }}</h4>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card pt-3 px-3">
                            <h6>Total Registrations Reverted</h6>
                            <h4>{{ $countReverted }}</h4>

                        </div>
                    </div>

                </div>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                            type="button" role="tab" aria-controls="nav-home" aria-selected="true">Global
                            Range</button>
                        <button class="nav-link " id="nav-house-tab" data-bs-toggle="tab" data-bs-target="#nav-house"
                            type="button" role="tab" aria-controls="nav-house" aria-selected="true">Date Range</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                            type="button" role="tab" aria-controls="nav-profile" aria-selected="false">District
                            Wise</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                            type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Office
                            Wise</button>
                    </div>
                </nav>



                <div class="tab-content" id="nav-tabContent">

                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row my-4">
                            <div class="col-md-8">
                                <div class="card p-3">
                                    <h6>Global Range</h6>









                                    <div class="row">
                                        <!-- Total Applications Card -->
                                        <div class="col-md-4 mb-3">
                                            <div class="card shadow-sm p-3">
                                                <h6>Total Registrations</h6>
                                                <p class="h5 text-center">{{ $rowCount }}</p>

                                            </div>
                                        </div>

                                        <!-- New Applications Card -->
                                        <div class="col-md-4 mb-3">
                                            <div class="card shadow-sm p-3">
                                                <h6>New Registrations</h6>
                                                <p class="h5 text-center">{{ $totalNew }}</p>

                                            </div>
                                        </div>

                                        <!-- Onboarding Applications Card -->
                                        <div class="col-md-4 mb-3">
                                            <div class="card shadow-sm p-3">
                                                <h6>Onboarding Registrations</h6>
                                                <p class="h5 text-center">{{ $totalOnboarding }}</p>

                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="card shadow-sm p-3">
                                                <h6>Total Registrations Approved</h6>
                                                <p class="h5 text-center">{{ $countApproved }}</p>

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card shadow-sm p-3">
                                                <h6>Total Registrations Rejected</h6>
                                                <p class="h5 text-center">{{ $countRejected }}</p>

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card shadow-sm p-3">
                                                <h6>Total Registrations Reverted</h6>
                                                <p class="h5 text-center">{{ $countReverted }}</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pie Chart Section -->
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <h6>Global-Range</h6>
                                    <canvas id="chartDateRange"></canvas>
                                </div>
                            </div>

                        </div>
                    </div>



                    <div class="tab-pane fade show active" id="nav-house" role="tabpanel" aria-labelledby="nav-house-tab">
                        <div class="row my-4">
                            <div class="col-md-8">
                                <div class="card p-3">
                                    <h6>Date Range</h6>
                                    <div class="row mb-3" style="gap: 20px;">
                                        <!-- From Date -->
                                        <div class="col-md-4">
                                            <label for="fromDate" class="form-label">From Date</label>
                                            <input type="date" id="fromDate" class="form-control" />
                                        </div>

                                        <!-- To Date -->
                                        <div class="col-md-4">
                                            <label for="toDate" class="form-label">To Date</label>
                                            <input type="date" id="toDate" class="form-control" />
                                        </div>
                                        <div class="col-md-2 " style="margin-top:5%;">
                                            <button class="btn btn-primary" id="fetchDataBtn"
                                                style="border-radius: 5px; font-size: 12px;">
                                                Show Data
                                            </button>

                                        </div>
                                    </div>


                                    <div class="row">
                                        <!-- Total Applications Card -->
                                        <div class="col-md-4 mb-3">
                                            <div class="card shadow-sm p-3">
                                                <h6>Total Registrations</h6>
                                                <p class="h5 text-center">{{ $rowCount }}</p>

                                            </div>
                                        </div>

                                        <!-- New Applications Card -->
                                        <div class="col-md-4 mb-3">
                                            <div class="card shadow-sm p-3">
                                                <h6>New Registrations</h6>
                                                <p class="h5 text-center">{{ $totalNew }}</p>

                                            </div>
                                        </div>

                                        <!-- Onboarding Applications Card -->
                                        <div class="col-md-4 mb-3">
                                            <div class="card shadow-sm p-3">
                                                <h6>Onboarding Registrations</h6>
                                                <p class="h5 text-center">{{ $totalOnboarding }}</p>

                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="card shadow-sm p-3">
                                                <h6>Total Registrations Approved</h6>
                                                <p class="h5 text-center">{{ $countApproved }}</p>

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card shadow-sm p-3">
                                                <h6>Total Registrations Rejected</h6>
                                                <p class="h5 text-center">{{ $countRejected }}</p>

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card shadow-sm p-3">
                                                <h6>Total Registrations Reverted</h6>
                                                <p class="h5 text-center">{{ $countReverted }}</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pie Chart Section -->
                            <!-- Date-Range Chart (Initially Hidden) -->
                            <div class="col-md-4" id="dateRangeChartSection">
                                <div class="card p-3">
                                    <h6>Date-Range</h6>
                                    <canvas id="chartDate"></canvas>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="row my-4">
                            <div class="col-md-8">
                                <div class="card p-3">
                                    <h6>District Wise</h6>
                                    @if (isset($districts))
                                        <p>✅ Data received: {{ count($districts) }} records</p>

                                        @if (count($districts) > 0)
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Sno.</th>
                                                        <th>District</th>
                                                        <th>Total Applications</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($districts as $district)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $district->district_name }}</td>
                                                            <td>{{ $district->getCount($district->district_code) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>❌ No data found inside $districts!</p>
                                        @endif
                                    @else
                                        <p>❌ $districts is not set!</p>
                                    @endif

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <h6>District Wise </h6>
                                    <canvas id="chartDistrictWise"></canvas>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="row my-4">
                            <div class="col-md-8">
                                <div class="card p-3">
                                    <h6>Office Wise</h6>
                                    <table class="table">
                                        <tr>
                                            <th>Sno.</th>
                                            <th>Office Name</th>
                                            <th>Total Applications</th>
                                            <th>New Applications</th>
                                            <th>On boarding Applications</th>
                                            <th>Approved Applications</th>
                                            <th>Reject Applications</th>
                                            <th>Revert Applications</th>
                                        </tr>
                                        <tr>
                                            <td>Water Bottle</td>
                                            <td>Peterson Jack</td>
                                            <td>Water Bottle</td>
                                            <td>Peterson Jack</td>
                                            <td>Water Bottle</td>
                                            <td>Peterson Jack</td>
                                            <th>Peter</th>
                                            <td class="text-warning">Pending</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <h6>Office Wise Chart</h6>
                                    <canvas id="chartOfficeWise"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row my-4">
                    <div class="col-md-6">
                        <div class="card p-3">
                            <h6>Recent Orders</h6>
                            <table class="table">
                                <tr>
                                    <th>Product</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                </tr>
                                <tr>
                                    <td>Water Bottle</td>
                                    <td>Peterson Jack</td>
                                    <td class="text-warning">Pending</td>
                                </tr>
                                <tr>
                                    <td>iPhone 15 Pro</td>
                                    <td>Michel Datta</td>
                                    <td class="text-danger">Cancelled</td>
                                </tr>
                                <tr>
                                    <td>Headphone</td>
                                    <td>Jeslyn Rose</td>
                                    <td class="text-success">Shipped</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3">
                            <h6>Weekly Top Customers</h6>
                            <ul>
                                <li>Mark Hoverson - 25 Orders</li>
                                <li>Mark Hoverson - 15 Orders</li>
                                <li>Jhony Peters - 23 Orders</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection


@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Function to initialize a pie chart with enhanced animation
        function initializePieChart(ctx, labels, data, backgroundColor) {
            return new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Data',
                        data: data,
                        backgroundColor: backgroundColor,
                        borderWidth: 2,
                        pointRadius: 3,
                        fill: '1',
                    }]
                },
                options: {
                    responsive: true,
                    animation: {
                        duration: 2000, // Duration of the animation in milliseconds
                        easing: 'easeOutQuart', // Easing function for smooth animation
                        animateRotate: true, // Enable rotation animation
                        animateScale: true // Enable scale animation
                    },
                    plugins: {
                        legend: {
                            position: 'top', // Position of the legend
                        },
                        title: {
                            display: true,
                            text: 'Pie Chart Animation' // Title of the chart
                        }
                    }
                }
            });
        }

        // Initialize Pie Charts
        document.addEventListener("DOMContentLoaded", function() {
            // Get the data from Laravel variables
            var registrationData = {
                labels: [
                    'Total Registrations',
                    'New Registrations',
                    'Onboarding Registrations',
                    'Approved Registrations',
                    'Rejected Registrations',
                    'Reverted Registrations'
                ],
                data: [
                    {{ $rowCount }},
                    {{ $totalNew }},
                    {{ $totalOnboarding }},
                    {{ $countApproved }},
                    {{ $countRejected }},
                    {{ $countReverted }}
                ],
                backgroundColors: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ]
            };

            function createPieChart(ctx, labels, data, backgroundColors) {
                return new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: backgroundColors,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        animation: {
                            animateRotate: true,
                            animateScale: true
                        },
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Registration Data'
                            }
                        }
                    }
                });
            }

            // Initialize Pie Chart
            var ctxDateRange = document.getElementById('chartDateRange').getContext('2d');
            var chartDateRange = createPieChart(
                ctxDateRange,
                registrationData.labels,
                registrationData.data,
                registrationData.backgroundColors
            );

        });

        var ctxDistrictWise = document.getElementById('chartDistrictWise').getContext('2d');
        var chartDistrictWise = initializePieChart(ctxDistrictWise,
            ['District 1', 'District 2', 'District 3', 'District 4'],
            [30, 20, 25, 25],
            [
                'rgba(255,99,132,1)',
                'rgba(54,162,235,1)',
                'rgba(75,192,192,1)',
                'rgba(255,205,86,1)'
            ]
        );

        var ctxOfficeWise = document.getElementById('chartOfficeWise').getContext('2d');
        var chartOfficeWise = initializePieChart(ctxOfficeWise,
            ['Office A', 'Office B', 'Office C'],
            [50, 30, 20],
            [
                'rgba(255,99,132,1)',
                'rgba(54,162,235,1)',
                'rgba(75,192,192,1)'
            ]
        );

        // Function to trigger chart animation when switching tabs
        function triggerChartAnimation() {
            // Update and re-render the charts to trigger animation
            chartDateRange.update();
            chartDistrictWise.update();
            chartOfficeWise.update();
        }

        // Function to destroy and reinitialize charts to force re-animation
        function reinitializeCharts() {
            // Destroy existing charts
            chartDateRange.destroy();
            chartDistrictWise.destroy();
            chartOfficeWise.destroy();



            chartDistrictWise = initializePieChart(document.getElementById('chartDistrictWise').getContext('2d'),
                ['District 1', 'District 2', 'District 3', 'District 4'],
                [30, 20, 25, 25],
                [
                    'rgba(255,99,132,1)',
                    'rgba(54,162,235,1)',
                    'rgba(75,192,192,1)',
                    'rgba(255,205,86,1)'
                ]
            );

            chartOfficeWise = initializePieChart(document.getElementById('chartOfficeWise').getContext('2d'),
                ['Office A', 'Office B', 'Office C'],
                [50, 30, 20],
                [
                    'rgba(255,99,132,1)',
                    'rgba(54,162,235,1)',
                    'rgba(75,192,192,1)'
                ]
            );
        }

        // Event listener to trigger animation when switching tabs
        var tabLinks = document.querySelectorAll('.nav-link');
        tabLinks.forEach(function(link) {
            link.addEventListener('shown.bs.tab', function() {
                // Trigger animation after the tab switch
                setTimeout(reinitializeCharts, 200); // Small delay to let tab switch complete
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get elements
            const dateRangeChartSection = document.getElementById("dateRangeChartSection");
            const navHomeTab = document.getElementById("nav-home-tab");
            const navHouseTab = document.getElementById("nav-house-tab");
            const navProfileTab = document.getElementById("nav-profile-tab");
            const navContactTab = document.getElementById("nav-contact-tab");

            // Hide the Date-Range chart by default
            dateRangeChartSection.style.display = "none";

            // Event listener for clicking on the "Date Range" tab
            navHomeTab.addEventListener("click", function() {
                dateRangeChartSection.style.display = "block"; // Show Date-Range chart
            });

            // Event listeners for other tabs (to hide the Date-Range chart)
            [navProfileTab, navContactTab].forEach(tab => {
                tab.addEventListener("click", function() {
                    dateRangeChartSection.style.display = "none"; // Hide Date-Range chart
                });
            });
        });
    </script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get elements
        const dateRangeSection = document.getElementById("nav-house");
        const globalRangeSection = document.getElementById("nav-home");
        const districtWiseSection = document.getElementById("nav-profile");
        const officeWiseSection = document.getElementById("nav-contact");
        const dateRangeChartSection = document.getElementById("dateRangeChartSection");
        const fetchDataBtn = document.getElementById('fetchDataBtn');

        // Get Tab Buttons
        const navHomeTab = document.getElementById("nav-home-tab");
        const navHouseTab = document.getElementById("nav-house-tab");
        const navProfileTab = document.getElementById("nav-profile-tab");
        const navContactTab = document.getElementById("nav-contact-tab");

        // Hide all sections except Global Range by default
        dateRangeSection.style.display = "none";
        districtWiseSection.style.display = "none";
        officeWiseSection.style.display = "none";
        dateRangeChartSection.style.display = "none";

        // Function to switch tabs
        function showSection(activeSection) {
            globalRangeSection.style.display = "none";
            dateRangeSection.style.display = "none";
            districtWiseSection.style.display = "none";
            officeWiseSection.style.display = "none";
            dateRangeChartSection.style.display = "none";

            if (activeSection === "dateRange") {
                dateRangeSection.style.display = "block";
                dateRangeChartSection.style.display = "block";
            } else if (activeSection === "globalRange") {
                globalRangeSection.style.display = "block";
            } else if (activeSection === "districtWise") {
                districtWiseSection.style.display = "block";
            } else if (activeSection === "officeWise") {
                officeWiseSection.style.display = "block";
            }
        }

        // Show respective sections when clicking tabs
        navHouseTab.addEventListener("click", function () {
            showSection("dateRange");
        });

        navHomeTab.addEventListener("click", function () {
            showSection("globalRange");
        });

        navProfileTab.addEventListener("click", function () {
            showSection("districtWise");
        });

        navContactTab.addEventListener("click", function () {
            showSection("officeWise");
        });

        // Function to update BOTH Global and Date Range cards
        function updateCardValues(data) {
            // ✅ Update Top Cards
            const topCards = document.querySelectorAll(".col-md-2 h4");
            if (topCards.length >= 6) {
                topCards[0].innerText = data.rowCount;
                topCards[1].innerText = data.totalNew;
                topCards[2].innerText = data.totalOnboarding;
                topCards[3].innerText = data.countApproved;
                topCards[4].innerText = data.countRejected;
                topCards[5].innerText = data.countReverted;
            }

            // ✅ Update "Date Range" Cards Inside #nav-house (BOTTOM CARDS)
            const dateRangeCards = document.querySelectorAll("#nav-house .card h5");
            if (dateRangeCards.length >= 6) {
                dateRangeCards[0].innerText = data.rowCount;
                dateRangeCards[1].innerText = data.totalNew;
                dateRangeCards[2].innerText = data.totalOnboarding;
                dateRangeCards[3].innerText = data.countApproved;
                dateRangeCards[4].innerText = data.countRejected;
                dateRangeCards[5].innerText = data.countReverted;
            } else {
                console.error("❌ Error: Date Range cards not found!");
            }
        }

        // Fetch and update data on clicking "Show Data" button
        fetchDataBtn.addEventListener('click', function () {
            let fromDate = document.getElementById('fromDate').value;
            let toDate = document.getElementById('toDate').value;

            if (!fromDate || !toDate) {
                alert("Please select both From and To dates.");
                return;
            }

            fetch("{{ url('/get-date-range-data') }}?from_date=" + fromDate + "&to_date=" + toDate)
                .then(response => response.json())
                .then(data => {
                    console.log("✅ Fetched Data:", data);

                    updateCardValues(data); // ✅ Update ALL Cards (Top + Date Range)
                    if (!chartDateRange) createPieChart(); // ✅ Ensure Pie Chart is Initialized
                    updatePieChart(data); // ✅ Update Pie Chart Data
                })
                .catch(error => console.error('❌ Error fetching data:', error));
        });

        // Initialize Pie Chart
        let chartDateRange;

        function createPieChart() {
            let ctx = document.getElementById('chartDateRange').getContext('2d');
            chartDateRange = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [
                        'Total Registrations',
                        'New Registrations',
                        'Onboarding Registrations',
                        'Approved Registrations',
                        'Rejected Registrations',
                        'Reverted Registrations'
                    ],
                    datasets: [{
                        data: [0, 0, 0, 0, 0, 0], // Initially empty
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    animation: {
                        animateRotate: true,
                        animateScale: true
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Registration Data'
                        }
                    }
                }
            });
        }

        // Function to update Pie Chart dynamically
        function updatePieChart(data) {
            if (chartDateRange) {
                chartDateRange.data.datasets[0].data = [
                    data.rowCount,
                    data.totalNew,
                    data.totalOnboarding,
                    data.countApproved,
                    data.countRejected,
                    data.countReverted
                ];
                chartDateRange.update(); // Refresh the chart
            } else {
                console.error("❌ Error: Chart instance not found!");
            }
        }

        // ✅ Ensure Chart is Initialized Before First Update
        if (!chartDateRange) createPieChart();
    });
</script>









@endsection
