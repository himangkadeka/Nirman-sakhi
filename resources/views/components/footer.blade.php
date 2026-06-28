<style>
    @media (max-width: 575.98px) {
        .line1 {
            width: 90%;
        }

        .line2 {
            width: 75%;
        }

        .footer-social2 {
            padding-left: 700px;
        }


    }

    @media (min-width: 576px) and (max-width: 767.98px) {

        .line1,
        .line2 {
            width: 70%;
        }
    }

    @media (min-width: 768px) and (max-width: 1023.98px) {

        .line1 {
            width: 80%;
        }

        .line2 {
            width: 65%;
        }


    }

    @media (min-width: 1024px) and (max-width: 1199.98px) {

        .line1 {
            width: 65%;
        }

        .line2 {
            width: 55%;
        }


    }

    @media (min-width: 1200px) and (max-width: 1439.98px) {

        .line1 {
            width: 55%;
        }

        .line2 {
            width: 45%;
        }

        .about-website {
            padding-left: 4%;
        }

        .footer-nic {
            padding-left: 2%;
        }

    }



    @media (min-width: 1440px) and (max-width: 2559.98px) {

        .line1 {
            width: 50%;
        }

        .line2 {
            width: 40%;
        }

        .footer-social2 {
            margin-left: -20px;
        }

        .footerrow {
            margin-left: 10%;
        }
    }

    @media (min-width: 2560px) {

        .line1 {
            width: 20%;
        }

        .line2 {
            width: 17%;
        }

        .footer-social {
            margin-left: 100px;

        }

        .footer-social2 {
            margin-left: 50px;

        }

        .websitelist2 {
            padding-left: 50px;
        }

        .abcd {
            margin-left: 100px;
        }

        .bg-light {
            margin-left: 150px;
        }

        /* .footerrow {
            margin-left: 10%;
        } */

        .footer-ns {
            padding-right: -100px;
        }

    }

    .footer-bs p {

        font-size: 16px;
        color: #ffbf49;
        font-weight: 600;
    }

    .footer-bs ul li a {
        font-family: 'Roboto', sans-serif;
        color: #f0f0f0;
        font-size: 14px;
        text-decoration: none;
        transition: color 0.3s;
    }

    .footer-bs ul li a:hover {
        color: #ffbf49;
    }

    .footer-bs {
        background: linear-gradient(to right, #009cdb, #1198ff);
        padding: 40px 0;
        color: white;
    }

    .footer-bs a:hover {
        text-decoration: underline;
        color: #ffbf49;
    }

    /*.footer-bs .footer-nav {*/
    /*    background: rgba(255, 255, 255, 0.1);*/
    /*    padding: 20px;*/
    /*    border-radius: 8px;*/
    /*    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);*/
    /*}*/
    .backtotop {
        background-color: #ffbf49;
        color: #000;
        padding: 10px 15px;
        border-radius: 50%;
        transition: background-color 0.3s;
    }

    .backtotop:hover {
        background-color: #4ca1af;
        color: #fff;
    }

    #visitorCount {


        color: white;
        font-weight: bold;
    }

    /*.myfooter {*/
    /*    width: 100%;*/
    /*    padding: 40px 0;*/
    /*    font-family: "Poppins", Sans-Serif;*/
    /*    color: white;*/
    /*    padding-bottom: 0;*/
    /*}*/




    img.footer_logo {
        width: 140px;
    }

    .myfooter h3 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px
    }

    .myfooter ul {
        padding: 0px;
        list-style-type: none;
    }

    .myfooter ul li {
        padding-left: 18px;
        position: relative;
        margin-bottom: 6px;
    }

    .myfooter ul li a {
        text-decoration: none;
        color: white;
        transition: 0.2s linear
    }

    .myfooter ul li:hover a,
    .myfooter ul li:hover i {
        color: #f8e905;
    }

    .myfooter ul li i {
        position: absolute;
        left: 0;
        font-size: 12px;
        line-height: 24px;
    }

    .visitors {
        background: #002a4c;
        color: white;
        padding: 10px 0px;
        text-align: center;
    }

    .container.visitorcol {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 125px;
    }

    .line {
        width: 150px;
        height: 2px;
        background: white;
        margin-bottom: 15px;
    }

    ul.footerNic li {
        margin-top: 0px;
        margin-bottom: 10px;
        padding: 0;
    }

    .footer-contact {
        margin-top: 20px;
        color: white;
        border: 1px solid white;
        border-bottom: 1px solid white;
        padding: 6px 14px;
        width: fit-content;
        border-radius: 5px;
        transition: 0.3s linear;
        cursor: pointer;
    }

    .footer-contact a {
        color: white;
        text-decoration: none;
    }

    .footer-contact:hover {
        background: #11587c
    }

    .scroll-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 45px;
        height: 45px;
        background: linear-gradient(45deg, #00c6ff, #0072ff);
        border: none;
        border-radius: 50%;
        color: white;
        font-size: 24px;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    }

    .scroll-to-top:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    @media (max-width: 768px) {
        .scroll-to-top {
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            font-size: 20px;
        }
    }
</style>
<section class="myfooter">
    <div class="container-fluid col-md-11 footerrow ">
        <div class="row">
            <div class="col-sm-12 col-md-4 mb-3 order-1">

                <h3 style="font-family:'Poppins',Sans-Serif;">{{ trans('footer.AbouttheGovernment') }}</h3>
                <div class="line"></div>
                <ul style="font-family:'Roboto',Sans-Serif">
                    <li><i class="fa fa-angle-double-right"></i><a href="https://assam.gov.in/" alt="assam state portal"
                            target="_blank">{{ trans('footer.AssamStatePortal') }}</a></li>
                    <li><i class="fa fa-angle-double-right"></i><a href="https://labourcommissioner.assam.gov.in/"
                            alt="assam state portal" target="_blank">{{ trans('footer.LabourCommisionerate') }}</a>
                    </li>
                    <li><i class="fa fa-angle-double-right"></i><a href="https://labour.assam.gov.in/"
                            alt="assam state portal" target="_blank">{{ trans('footer.LabourWelfareDepartment') }}</a>
                    </li>
                    <li><i class="fa fa-angle-double-right"></i><a href="https://eodb.assam.gov.in/"
                            alt="assam state portal" target="">{{ trans('footer.assambusiness') }}</a></li>

                    <li><i class="fa fa-angle-double-right"></i><a href="https://sewasetu.assam.gov.in/"
                            alt="assam state portal" target="_blank">{{ trans('footer.SewaSetu') }}</a></li>
                    <li><i class="fa fa-angle-double-right"></i><a href="https://cm.assam.gov.in/" alt="CM Portal"
                            target="_blank">{{ trans('footer.CMPortal') }}</a></li>
                    <li><i class="fa fa-angle-double-right"></i><a href="https://eshram.gov.in/" alt=""
                            target="_blank">{{ trans('footer.eshram') }}</a></li>
                </ul>

            </div>

            <div class="col-sm-12 col-md-4 mb-3 order-2 about-website">
                <h3 style="font-family:'Poppins',Sans-Serif;">{{ trans('footer.AbouttheWebsite') }}</h3>
                <div class="line"></div>
                <ul style="font-family:'Roboto',Sans-Serif">
                    <li><i class="fa fa-angle-double-right"></i><a href="{{ route('home.termsofuse') }}"
                            alt="Terms of use" target="">{{ trans('footer.TermsofUse') }}</a></li>
                    <li><i class="fa fa-angle-double-right"></i><a href="{{ route('home.copyrightpolicy') }}"
                            alt="assam state portal" target="">{{ trans('footer.copyrightpolicy') }}</a></li>
                    <li><i class="fa fa-angle-double-right"></i><a href="{{ route('home.accessibilitypolicy') }}"
                            alt="assam state portal" target="">{{ trans('footer.accessibilityoptions') }}</a></li>
                    <li><i class="fa fa-angle-double-right"></i><a href="{{ route('home.sitemaps') }}"
                            alt="assam state portal" target="">{{ trans('footer.Sitemap') }}</a></li>
                    <li><i class="fa fa-angle-double-right"></i><a href="{{ route('home.privacypolicy') }}"
                            alt="assam state portal" target="">{{ trans('footer.privacypolicy') }}</a></li>
                    <li><i class="fa fa-angle-double-right"></i><a href="https://labour.gov.in/" alt="MoLe"
                            target="_blank">{{ trans('footer.mole') }}</a></li>
                    <li><i class="fa fa-angle-double-right"></i><a href="{{ route('home.faq') }}"
                            alt="assam state portal" target="">{{ trans('footer.faq') }}</a></li>

                </ul>
            </div>


            <div class="col-sm-12 col-md-4 mb-3 order-3 footer-nic">
                <img src="{{ URL::asset('assets/template/images/NIC_logo.svg') }}" alt="footer logo"
                    class="footer_logo">
                <ul class="footerNic">
                    <li><a href="https://assam.nic.in/" alt="assam state portal"
                            target="_blank"><br>{{ trans('footer.design&develop') }}
                            <br> {{ trans('footer.nic') }} {{ trans('footer.design&develop2') }}
                        </a></li>

                    <li>{{ trans('footer.maintained') }} <br> <a href="https://abocwwb.assam.gov.in/"
                            alt="assam state portal" target="_blank">{{ trans('footer.byabocwwb') }}</a></li>
                </ul>
                <p class="footer-contact" onclick="window.location.href='{{ route('home.contactus') }}'">Contact Us
                </p>
            </div>

        </div>
    </div>
    <div class="visitors">
        <div class="container visitorcol">
            <div>Total Visitors : <span id="visitorCount"></span></div>
            <div>Website Last Update on : <span id="lastUpdate"></span></div>


        </div>
    </div>
    <button id="scrollToTop" class="scroll-to-top">
        <i class="bi bi-rocket-fill"></i>
    </button>
</section>
{{-- <div class="footer-bs">
    <footer class="container-fluid">
        <div class="row">
            <div class="col footer-nav footer-row ">
                <p class="col-md-12" style="color:#ffbf49; font-weight:600;">{{ trans('footer.AbouttheGovernment') }}
                </p>
                <div class=" mt-n2 line1" style="background-color:  #ffbf49; height:1.5px;">
                </div>
                <div class="row">

                    <div class="col-lg-9">
                        <ul class="list" style="color: white;">
                            <li><a href="https://assam.gov.in/">{{ trans('footer.AssamStatePortal') }}</a></li>

                            <li><a
                                    href="https://labourcommissioner.assam.gov.in/">{{ trans('footer.LabourCommisionerate') }}</a>
                            </li>
                            <li><a href="https://labour.assam.gov.in/">{{ trans('footer.LabourWelfareDepartment') }}</a>
                            </li>


                        </ul>
                    </div>
                    <div class="col-lg-3 websitelist1">
                        <ul class="list" style="color: white;">

                            <li><a href="https://labour.gov.in/">MoLE</a></li>
                            <li><a href="https://sewasetu.assam.gov.in/">{{ trans('footer.SewaSetu') }}</a></li>
                            <li><a href="https://cm.assam.gov.in/">{{ trans('footer.CMPortal') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col footer-nav footer-social2 ">
                <div class="row">
                    <div class="col abcd">
                        <p class="col-md-12 " style="color:#ffbf49; font-weight:600;">
                            {{ trans('footer.AbouttheWebsite') }}
                        </p>
                        <div class=" mt-n2 line2" style="background-color:  #ffbf49; height:1.5px; ">
                        </div>
                        <div class="row">

                            <div class="col-lg-8 ">
                                <ul class="list " style="color: white;">
                                    <li><a href="{{ route('home.termsofuse') }}">{{ trans('footer.TermsofUse') }}</a></li>

                                    {{-- <li><a href="{{ route('home.copyrightpolicy') }}">{{ trans('footer.copyrightpolicy') }}</a></li> --}}

{{-- <li><a href="#">{{ trans('footer.copyrightpolicy') }}</a></li>
                                    <li><a href="#">{{ trans('footer.accessibilityoptions') }}</a></li>

                                    <li><a href="{{ route('home.sitemaps') }}">{{ trans('footer.Sitemap') }}</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-4 websitelist2">
                                <ul class="list" style="color: white;"> --}}

{{-- <li data-toggle="modal" data-target="#feedback-modal"><a
                                            href="javascript:void(0)">{{ trans('footer.feedback') }}</a></li> --}}
{{-- <li><a href="">{{ trans('footer.copyrightpolicy') }}</a></li> --}}
{{-- <li><a href="{{ route('home.contactus') }}">{{ trans('header.contact_us') }}</a>
                                    </li> --}}
{{-- <li><a href="{{ route('home.privacypolicy') }}">{{ trans('footer.privacypolicy') }}</a></li> --}}

{{-- <li><a href="#">{{ trans('footer.privacypolicy') }}</a></li>
                                    <li><a href="{{ route('home.faq') }}">FAQs</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 footer-social d-flex">
                <div class="d-inline-block align-self-left">
                    <p class="bg-light"><img src="{{ URL::asset('assets/template/images/footer/NIC.png') }}"
                            alt="NIC logo"></p>
                    <p class="bg-light mb-0"><img
                            src="{{ URL::asset('assets/template/images/footer/digital-india.png') }}"
                            alt="digital india logo"></p>
                </div>
            </div>
            <div class="col-lg-2 col-md-5 col-sm-4 footer-ns d-flex">
                <a class="backtotop align-self-center d-flex text-center text-decoration-none text-white"
                    title="{{ trans('footer.backtotop') }}" href="#b-accessibility">
                    <span style="display:none;">Back to top</span>
                    <span style="font-size: 24px;" class="fas fa-angle-up align-self-center mx-auto"></span>
                </a>
            </div>
        </div>

        <div class="text-center mt-2" style="color: #FFF!important">
            Vistors Count: <span id="visitorCount">0</span>
        </div>

        <div class="text-center mt-4 b-footer-credit" style="color: #FFF!important">
            {{ trans('footer.twbtdo') }} <a class="font-weight-bold" href="https://abocwwb.assam.gov.in/"> {{ trans('footer.abocwwb') }}  </a>, <a class="font-weight-bold"
                href="https://labour.assam.gov.in/">{{ trans('footer.LabourWelfareDepartment') }}</a>, <a class="font-weight-bold"
                href="https://www.india.gov.in/">{{ trans('footer.govtofassam') }} </a>
        </div>

    </footer> --}}
{{-- </div> --}}
<!-- DataTables JS -->






<script type="text/javascript" src="{{ URL::asset('assets/template/vendor/datatables/jquery.dataTables.min.js') }}">
</script>
<script type="text/javascript"
    src="{{ URL::asset('assets/template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/jquery-3.7.0.js') }}"></script>
<script src="{{ URL::asset('assets/template/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
{{--<script src="{{ URL::asset('assets/template/js/bootstrap.bundle.min.js') }}"></script>--}}
<script src="{{ URL::asset('assets/template/js/jquery.slicknav.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/dashboard.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/main.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/popper.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/vendor/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ URL::asset('assets/template/vendor/jquery/jquery-3.7.0.js') }}"></script>
<script src="{{ URL::asset('assets/template/vendor/datatables/jquery.dataTables-01.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/vendor/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/vendor/datatables/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/vendor/datatables/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/vendor/datatables/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/template/vendor/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/vendor/datatables/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/toastify-js.js') }}"></script>

{{-- @if (env('APP_STAGING') === true) --}}
{{-- @if (session()->has('website-seeiosn')) --}}
{{-- <script> --}}
{{-- document.addEventListener('DOMContentLoaded', function() { --}}
{{-- var websiteSession = "{{ session()->get('website-session') }}"; // Fetch the session value in JS --}}

{{-- // alert(websiteSession); // This will be printed to the console --}}

{{-- // Check if session value is NOT 'Labour@123454321' --}}
{{-- if (websiteSession !== 'Labour@123454321') { --}}
{{-- $(document).ready(function() { --}}
{{-- // alert('11111'); --}}
{{-- // Uncomment the next line to redirect to the 'test-site' route --}}
{{-- window.location.href = "{{ route('test-site') }}"; --}}
{{-- }); --}}
{{-- } --}}
{{-- }); --}}
{{-- </script> --}}
{{-- @elseif(!(session()->has('website-session'))) --}}
{{-- <script> --}}
{{-- $(document).ready(function() { --}}
{{-- // alert('11111'); --}}
{{-- // Uncomment the next line to redirect to the 'test-site' route --}}
{{-- window.location.href = "{{ route('test-site') }}"; --}}
{{-- }); --}}
{{-- </script> --}}
{{-- @endif --}}
{{-- @endif --}}

<script>
    const scrollBtn = document.getElementById("scrollToTop");

    window.onscroll = function() {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            scrollBtn.style.display = "flex";
        } else {
            scrollBtn.style.display = "none";
        }
    };
    scrollBtn.addEventListener("click", function() {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
</script>

<script>
    function myFunction(x) {
        x.classList.toggle("change");
    }
</script>

{{-- @if (Route::is('home.index'))  --}}{{-- Replace 'home' with your actual route name --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/visitor-count')
            .then(response => response.text())
            .then(count => {
                document.getElementById('visitorCount').textContent = count;
            })
            .catch(error => console.error('Error fetching visitor count:', error));
    });
</script>
<script>
    @if (session()->has('nonce_value'))
        var nonce_value = '{{ session()->get('nonce_value') }}';
    @endif
</script>
{{-- <script>
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
    });
</script>
<script>
    document.addEventListener('keydown', function(event) {
        // Block Ctrl+U (View Source)
        if (event.ctrlKey && event.key === 'u') {
            event.preventDefault();
            // alert("Viewing source has been disabled."); //
        }

        // Block F12 (Dev Tools)
        if (event.key === 'F12') {
            event.preventDefault();
            // alert("Developer tools are disabled.");
        }

        // Block Ctrl+Shift+I (Inspect Element)
        if (event.ctrlKey && event.shiftKey && event.key === 'I') {
            event.preventDefault();
            // alert("Inspect element is disabled.");
        }

        // Block Ctrl+Shift+J (Console)
        if (event.ctrlKey && event.shiftKey && event.key === 'J') {
            event.preventDefault();
            // alert("Console access is disabled.");
        }

        // Block Ctrl+Shift+C (Inspect Element Shortcut)
        if (event.ctrlKey && event.shiftKey && event.key === 'C') {
            event.preventDefault();
            // alert("Inspect element is disabled.");
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Disable the Console tab
        console.log = function () {
            // alert("Console access is disabled.");
        };

        // Disable network requests and log them instead
        const originalOpen = XMLHttpRequest.prototype.open;
        XMLHttpRequest.prototype.open = function() {
            console.warn("Network requests are disabled.");
            return originalOpen.apply(this, arguments);
        };
    });
</script> --}}


{{-- @endif --}}


{{-- <script>
    function redirectToHome() {
        window.location.href = "index";
    }
</script> --}}

<script>
    /* When the user clicks on the button,
                toggle between hiding and showing the dropdown content */
    function mydropdownFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
<style>

</style>
<script>
    // Show loader and overlay
    function showLoader() {
        document.querySelector('.loader-container').style.display = 'block';
        // document.querySelector('.overlay').style.display = 'block';
    }

    // Hide loader and overlay
    function hideLoader() {
        document.querySelector('.loader-container').style.display = 'none';
        // document.querySelector('.overlay').style.display = 'none';
    }

    // Show loader initially
    showLoader();


    // Show loader initially
    showLoader();

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            hideLoader();
        }, 100);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            hideLoader();
        }, 100);
    });
</script>
<script>
    // Get the current date
    var today = new Date();
    var formattedDate = today.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    // Display the current date
    document.getElementById('lastUpdate').textContent = formattedDate;
</script>
</body>

</html>
