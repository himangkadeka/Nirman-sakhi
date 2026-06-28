@include('layout.header')

<!--Modal Start-->
<div class="modal fade" id="firstModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
{{--                <h5 class="modal-title" id="exampleModalLabel">Worker Registration</h5>--}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12 mb-2" style="background-color:#bd362f; padding: 10px;color: whitesmoke;">
                    <h3>Please Note :</h3>
                    <p>If you are working in Kalyan, then please select Kalyan as your nearest WFC location or if you are working in Ichalkaranji, then please select Ichalkaranji as your nearest WFC location.
                        Kalyan talukas - Ambernath, Kalyan, Murbad, Shahapur, Ulhasnagar
                        Ichalkaranji talukas - Shirol, Hathkangle</p>
                </div>
                <form class="form-group" method="post" action="{{route('worker-reg')}}">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-8" for="district">Select the nearest WFC Location/নিকটতম WFC অৱস্থান নিৰ্ব্বাচন কৰক</label>
                        <div class="col-md-12">
                            <select name="district">
                                @foreach ($district as $data)
                                    <option value="{{ $data->district_code }}">{{ $data->district_name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('district'))
                                <span class="text-danger font-weight-normal">{{ $errors->first('district') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="adhaarno">Adhaar No/আধাৰ নং</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="adhaar_no" name="adhaarno" placeholder="Enter Adhaar No"/>
                            @if ($errors->has('adhaarno'))
                                <span class="text-danger font-weight-normal">{{ $errors->first('adhaarno') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="email">Mobile No/মোবাইল নং</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="phoneno" name="phone_no" placeholder="Enter Phone No"/>
                            @if ($errors->has('phone_no'))
                                <span class="text-danger font-weight-normal">{{ $errors->first('phone_no') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="">Proceed To Form</button>
                        <button type="button" class="btn btn-secondary" id="" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--modal end-->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>--}}
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(window).on('load', function() {
        $('#firstModal').modal('show');
    });
    </script>
@include('layout.footer');
