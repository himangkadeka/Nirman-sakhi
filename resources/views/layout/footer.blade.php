<div class="footer-bs">
	    <footer class="container">
	        <div class="row">
	        	<div class="row col-md-7 col-sm-12 footer-nav">
	            	<p class="col-md-12">{{ trans('footer.QuickLinks') }} —</p>
	            	<div class="col-sm-6">
	                    <ul class="list">
	                        <li><a href="#">{{ trans('footer.TermsofUse') }}</a></li>
	                        <li><a href="#">{{ trans('footer.contactus') }}</a></li>
	                        <li><a href="#">{{ trans('footer.accessibilityoptions') }}</a></li>
	                    </ul>
	                </div>
	                <div class="col-sm-6">
	                    <ul class="list">
	                    	<li data-toggle="modal" data-target="#feedback-modal"><a href="javascript:void(0)">{{ trans('footer.feedback') }}</a></li>
	                        <li><a href="inner.html">{{ trans('footer.copyrightpolicy') }}</a></li>
	                        <li><a href="javascript:void(0);">{{ trans('footer.privacypolicy') }}</a></li>
	                    </ul>
	                </div>
	            </div>
	        	<div class="col-md-3 col-sm-8 footer-social d-flex">
        			<div class="d-inline-block align-self-center">
	        			<p class="bg-light"><img src="{{URL::asset('assets/template/images/footer/NIC.png')}}" alt="NIC logo"></p>
	        			<p class="bg-light mb-0"><img src="{{URL::asset('assets/template/images/footer/digital-india.png')}}" alt="digital india logo"></p>
	        		</div>
	            </div>
	        	<div class="col-md-2 col-sm-4 footer-ns d-flex">
	        			<a class="backtotop align-self-center d-flex text-center text-decoration-none text-white" title="{{ trans('footer.backtotop') }}" href="#b-accessibility">
	        				<span style="display:none;">Back to top</span>
		            		<span style="font-size: 24px;" class="fas fa-angle-up align-self-center mx-auto"></span>
		            	</a>
	            </div>
	        </div>
	        <div class="text-center mt-4 b-footer-credit" style="color: #FFF!important">
	        	{{ trans('footer.twbtdo') }} <a class="font-weight-bold" href="#">{{ trans('footer.dngh') }} </a>, <a class="font-weight-bold" href="#">{{ trans('footer.mname') }} </a>, <a class="font-weight-bold" href="https://www.india.gov.in/">{{ trans('footer.govtofindia') }} </a>
	        </div>
            <div class="text-center mt-2" style="color: #FFF!important">
                Visitor Count: <span id="visitorCount"></span>
            </div>
	    </footer>
</div>


<!-- DataTables JS -->
<script type="text/javascript" src="{{URL::asset('assets/template/js/dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url::asset('assets/template/vendor/bootstrap/js/dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/template/js/jquery-3.7.0.js')}}"></script>
<script src="{{URL::asset('assets/template/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{URL::asset('assets/template/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/template/js/jquery.slicknav.min.js')}}"></script>
<script src="{{URL::asset('assets/template/js/dashboard.js')}}"></script>
<script src="{{URL::asset('assets/template/js/general.js')}}"></script>
<script src="{{URL::asset('assets/template/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/template/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{URL::asset('assets/template/vendor/jquery-ui/jquery-ui.js')}}"></script>
<script src="{{ URL::asset('assets/template/js/popper.min.js') }}"></script>
<script src="{{URL::asset('assets/template/js/sweetAlert.js')}}"></script>
<script src="{{URL::asset('assets/template/js/toastr.min.js')}}"></script>
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



