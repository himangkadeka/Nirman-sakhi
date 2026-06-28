@include('layout.header');

<div class="b-bg-image py-5" style="padding-bottom: 200px!important">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 d-flex b-heading-sec">
					<div class="align-self-center pr-5 b-head-in">
						<h1 class="text-left b-left-head">What is Lorem Ipsum?</h1>
                        <h6 class="text-justify  b-left-head">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</h6>
					</div>
				</div>

				<div class="col-lg-6 col-md-6 col-sm-6 b-login-sec">
					<div class="d-block px-5 pt-5 pb-4 border-bottom-0">
						<h2 class="b-login-head">Log In</h2>
					</div>
					<div class="">
						<form action="{{route('login-test')}}" autocomplete="off" method="POST" class="px-5">
						@csrf
{{--							@if ($errors->has('loginfailmsg'))--}}
{{--                    				<span class="text-danger font-weight-bold">{{ $errors->first('loginfailmsg') }}</span>--}}
{{--               				@endif--}}
{{--							@if ($errors->has('usernotfoundmsg'))--}}
{{--                    				<span class="text-danger font-weight-bold">{{ $errors->first('usernotfoundmsg') }}</span>--}}
{{--               				@endif--}}
							<div class="form-group ">
								<label for="username" class="text-white">UAN Number/UAN নম্বৰ:</label>
								<input type="text" class="form-control uan" id="uan" placeholder="Enter UAN Number" name="uan" value="{{ old('uan') }}">
                                @if ($errors->has('uan'))
                    				<span class="text-danger font-weight-bold">{{ $errors->first('uan') }}</span>
               					@endif

							</div>
                            <div class="form-group">

                               <p><span class="badge badge-success font-weight-bold" id="show"></span></p>
                                <p><span class="badge badge-danger font-weight-bold" id="show_error"></span></p>

                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-danger" id="sendOtp">Generate Otp!</button>
                            </div>
							<div class="form-group">
								<label for="login-pwd-1" class="text-white">OTP:</label>
								<input type="password" class="form-control" id="login-pwd-1" placeholder="Enter OTP" name="otp">
								@if ($errors->has('otp'))
								<span class="text-danger font-weight-bold">{{ $errors->first('otp') }}</span>
               					@endif
							</div>
							<div class="form-group custom-control custom-checkbox">
								<input class="custom-control-input" id="login-rem-1" type="checkbox" name="remember">
{{--								<label class="custom-control-label text-white" for="login-rem-1">Remember me</label>--}}
							</div>
{{--                            <div class="text-center">--}}
{{--                            --}}
{{--                                <a href="{{route('generate-otp')}}" type="submit" class="btn btn-sm btn-danger">Generate OTP</a>--}}
{{--                            </div>--}}

							<!-- <p class="text-right b-notreg ">Don't have an account? <a href="">Sign Up</a></p> -->
							<div class="text-center py-2">
								<button type="submit" class="btn btn-primary b-btn">Log In</button>
                                <a href="{{route('register-worker')}}" class="btn btn-warning">Register</a>
							</div>
{{--							<div class="text-center p-2">--}}
{{--								<a href="{{route('registerworker')}}" class="btn btn-warning">Register Here</a>--}}
{{--							</div>--}}
						</form>
{{--                        <form action="{{route('generate-otp')}}" method="post">--}}
{{--                            <div class="text-center py-2">--}}

{{--                                <a href="" type="submit" class="btn btn-sm btn-danger">Generate OTP</a>--}}
{{--                            </div>--}}
{{--                        </form>--}}

					</div>
				</div>

			</div>
		</div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $("#sendOtp").click(function () {
            $('#show_error').html('');
            $('#show').html('');
            var uan = $("#uan").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                data: {'uan' : uan},
                dataType :"json",
                method: "post",
                url: "{{route('otp-send')}}",
                success: function (result) {
                    // console.log(result[0]);

                    if(result.success === true)
                    {
                        // alert(result.otp);
                        $('#show').html('Your OTP is : '+result.otp);

                        /*** to do ***/
                        /** remove otp input attributes **/
                        /** login remove disable attributes **/
                    }else{
                        // alert(result.msg);
                        $('#show_error').html('Error : '+result.msg);
                    }

                }

            });
        })
    });
</script>
<script>

    const forceKeyPressUppercase = (e) => {
        let el = e.target;
        let charInput = e.keyCode;
        if((charInput >= 97) && (charInput <= 122)) { // lowercase
            if(!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
                let newChar = charInput - 32;
                let start = el.selectionStart;
                let end = el.selectionEnd;
                el.value = el.value.substring(0, start) + String.fromCharCode(newChar) + el.value.substring(end);
                el.setSelectionRange(start+1, start+1);
                e.preventDefault();
            }
        }
    };

    document.querySelectorAll(".uan").forEach(function(current) {
        current.addEventListener("keypress", forceKeyPressUppercase);
    });

</script>
<!-- Dashboard -->
<div class="mt-5" id="b-homedb" style="position: relative; top: -170px; margin-bottom: -110px;">
		<div class="container">
			<div class="row text-center">
				<!-- <h2 class="col-md-12">Figures tell the story</h2> -->
				<div class="col-lg-4 p-4">
					<div class="bg-light py-4 b-dbcard">
						<p><span class="fas fa-users" style="font-size:40px"></span></p>
						<!-- <p> <img src="images/wheat.svg" width="40px"></span></p> -->
						<h3 style="font-size: 16px;"><strong>No. of Beneficiaries</strong></h3>
						<div class="text-left ">
							<p class="px-5">So Far  <span class="float-right">39.04 Cr</span></p>

							<p class="px-5">and Counting...</p>
						</div>
					</div>
				</div>

				<div class="col-lg-4 p-4">
					<div class="bg-light py-4 b-dbcard">
						<p><span class="fas fa-rupee-sign" style="font-size:40px"></span></p>
						<h3 style="font-size: 16px;"><strong>Total Amount Deposited</strong></h3>
						<div class="text-left ">
							<p class="px-5">So far <span class="float-right">131,339.59 Cr</span></p>

							<p class="px-5">and Counting...</p>
						</div>

					</div>
				</div>

				<div class="col-lg-4 p-4">
					<div class="bg-light py-4 b-dbcard">
						<p><span class="fas fa-credit-card" style="font-size:40px"></span></p>
						<h3 style="font-size: 16px;"><strong>No. of Rupay Debit Cards Issued</strong></h3>
						<div class="text-left ">
							<p class="px-5">So far  <span class="float-right">29.27 Cr</span></p>

							<p class="px-5">and Counting...</p>
						</div>
					</div>
				</div>

			</div>
		</div>
</div>
@include('layout.footer');
