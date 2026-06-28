@extends('layouts.user-app')

@section('title',' Update | Schemes')

@section('style')
<style>
    .table th{
        font-size: 12px;
    }
    .table-container {
        overflow-x: auto;
    }
    .fixed-width {
        min-width: 200px; /* Adjust the width as needed */
    }
    .fixed {
        min-width: 100px; /* Adjust the width as needed */
    }
    .table thead tr {
        border-top: 2px solid #ffc0b4;
    }
    .table thead th {
        border-bottom: 2px solid black;
    }

    .bold{
        font-weight: 500;
        font-family:"Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
        font-size: 14px;
        /*color: #186cb8;*/
        color: #219fa4;
        /*color: #7ea1a2;*/
    }
    body{
        background-color: #f1f1f1;
        font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
    }


    label.bold{
        font-weight: 500;
        font-size: 15px;
        font-family:"Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

    }
    .btn-primary {
        background-color: #0f4547;
    }
    .bar1, .bar2, .bar3 {
        width: 25px;
        height: 3px;
        background-color: #fff;
        margin: 5px 0;
        transition: 0.4s;
    }


    .change .bar1 {
        -webkit-transform: rotate(-45deg) translate(-5px, 5px);
        transform: rotate(-45deg) translate(-5px, 5px);
    }

    .change .bar2 {opacity: 0;}

    .change .bar3 {
        -webkit-transform: rotate(45deg) translate(-5px, -7px);
        transform: rotate(45deg) translate(-5px, -7px);
    }
    .custom-navbar {
        border-bottom: 2px solid #eee;
    }

    .custom-container {
        max-width: 1200px;
    }

    .custom-flex-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .custom-left-content {
        display: flex;
        flex-direction: column;
    }

    .custom-heading {
        margin-bottom: 0.5rem;
    }

    .custom-bold {
        font-weight: bold;
    }

    .custom-icon {
        color: #007bff;
    }
</style>
@endsection


@section('content')

@include('components.multistep')

<div class="container-fluid mb-4" >
    <div class="row">
        <div class="col-md-12">
            <nav class="custom-navbar navbar-light">
                <div class="custom-container">
                    <div class="custom-flex-container">
                        <div class="custom-left-content">
                            @include('components.session-timeout')
                        </div>

                    </div>
                </div>
            </nav>
            <div class="card mt-1">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <span>
                                <i class="fa fa-user" aria-hidden="true"></i>
                                {{ trans('worker-registration/worker-family-details.workername') }}
                                - {{ $getVaultData['name'] }}
                            </span>
                        </div>
                        <div class="card rounded-card">
                            <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                    style="background-color: #2badee;">
                                    <span>
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i> Update Scheme Details&nbsp;
                                        (Application No -
                                        {{ $application_no }})
                                    </span>

                                </div>
                    <form method="post" id="dynamic_field" action="{{ route('update-scheme-details') }}" class="ml-2 mr-2" enctype="multipart/form-data">
                        @csrf
{{--                        @foreach ($tws as $key => $scheme)--}}
                            <div class=" mt-4" style="overflow-x: auto">
                                <div class="form-group">
                                    <label class="ml-4 bold"><i class="fa fa-bullhorn" aria-hidden="true"></i>&nbsp;{{ trans('worker-registration/worker-schemes-details.question') }}? <i class="fa fa-question-circle" aria-hidden="true"></i></label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="enrolled_yes" name="enrolled" value="1" class="form-check-input ml-4" @if($tws[0]->enrolled == 1) checked @endif>
                                        <label for="enrolled_yes" class="form-check-label" style="padding-left: 5px;">{{ trans('worker-registration/worker-schemes-details.yes') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="enrolled_no" name="enrolled" value="0" class="form-check-input" @if($tws[0]->enrolled == 0) checked @endif>
                                        <label for="enrolled_no" class="form-check-label" style="padding-left: 5px;">{{ trans('worker-registration/worker-schemes-details.no') }}</label>

                                    </div>
                                    <span class="text-danger success" id="enrolled-error"></span>
                                </div>
                                <div class="row" id="schemeTableSection" @if($tws[0]->enrolled == 1) style="display: block" @else style="display: none" @endif>
                                    <div class="col">
                                        <div class="table-container">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col" class="bold">{{ trans('worker-registration/worker-schemes-details.mentionscheme') }}</th>
                                                    <th scope="col" class="bold">{{ trans('worker-registration/worker-schemes-details.regno') }}<span class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">{{ trans('worker-registration/worker-schemes-details.regdate') }}</th>
                                                    <th scope="col" class="bold">Action<span class="text-danger">*</span></th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach ($tws as $twsf)
                                                    <tr>
                                                        <td class="fixed">
                                                            <select name="scheme_name[]" class="form-control">
                                                                @if(!$twsf)
                                                                    <option selected disabled>{{ trans('worker-registration/worker-schemes-details.selectscheme') }}</option>
                                                                @else
                                                                    <option value="{{ $twsf->scheme_code }}">{{ $twsf->scheme_name }}</option>
                                                                @endif
                                                                @foreach($schemes as $scheme)
                                                                    <option value="{{ $scheme->scheme_code }}">{{ $scheme->scheme_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger success" id="scheme_name.0_error"></span>
                                                        </td>
                                                        <td class="fixed">
                                                            <input type="text" name="registration_id[]" value="{{ $twsf->registration_id }}" class="form-control"/>
                                                            <span class="text-danger success" id="registration_id.0_error"></span>
                                                        </td>
                                                        <td class="fixed">
                                                            <input type="date" name="date[]" class="form-control" value="{{ $twsf->date }}" max="' + <?php echo json_encode(date('Y-m-d')); ?> +'"/>
                                                            <span class="text-danger success" id="date.0_error"></span>
                                                        </td>
                                                        <td>
                                                            <button type="button" name="remove" class="btn btn-sm btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <button type="button" name="add" id="add" class="btn btn-sm btn-info mt-3"><i class="fa fa-plus-circle"></i>&nbsp;{{ trans('worker-registration/worker-schemes-details.addnew') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--                        @endforeach--}}

                        <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                            <div class="ml-auto d-inline-block align-self-center mr-2">
                                <a type="submit" href="{{route('submit-family-details')}}"
                                   class="btn btn-sm btn-warning"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;
                                   {{ trans('worker-registration/worker-schemes-details.previous') }}</a>
                                <button type="submit"
                                        class="btn btn-sm btn-primary"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                        {{ trans('worker-registration/worker-schemes-details.updateschemes') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- End Left side columns -->
</div>
    </div>
</div>
@endsection


@section('footer')


<link rel="stylesheet" href="{{URL::asset('assets/template/datepicker/jquery-ui.min.css')}}">
<script src="{{URL::asset('assets/template/datepicker/jquery-3.7.date.js')}}"></script>
<script src="{{URL::asset('assets/template/datepicker/jquery-ui.min.js')}}"></script>
<script>
    function updateMaxAttribute() {
        // Get today's date
        var today = new Date().toISOString().split('T')[0];

        // Set the max attribute for each date input field
        $('input[type="date"]').each(function() {
            $(this).attr('max', today);
        });
    }

    // Call the function initially
    updateMaxAttribute();
</script>

<script>
    $(document).ready(function(){
        const currentDate = '<?php echo date('Y-m-d'); ?>';
        let count = $('tbody tr').length;
        let dynamicRowsData = [];
        function dynamic_field(data = null)  {
            html = '<tr>';
            html += `<td class="dropdown">
            <select name="scheme_name[` + count + `]" class="form-control">
                <option value="">{{ trans('worker-registration/worker-schemes-details.selectscheme') }}</option>`;

            @foreach ($schemes as $scheme)
                html += ` <option value="{{ $scheme->scheme_code }}">{{ $scheme->scheme_name }}</option>`;
            @endforeach

                html += '</select><span class="text-danger success"  id="scheme_name.' + count +
                '_error"></span>' +
                '</td>';
            html += ' <td><input type="text" name="registration_id[' + count + ']"  id="registration_id[]" class="form-control " />' +
                '<span class="text-danger success"  id="registration_id.' + count + '_error"></span></td>\';</td>'


            html += '<td><input type="date" name="date[' + count + ']" id="date' + count + '" data-id="' + count + '" class="form-control" max="' + currentDate + '" />' +
                '<span class="text-danger success"  id="date.' + count + '_error"></span></td>';

            html +=
                '<td><button type="button" name="remove" id="" class="btn btn-sm btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';
            $('tbody').append(html);
            count++;
        }
        $('#dynamic_field').submit(function(event) {
            event.preventDefault();
            $('.success').html('');
            const formData = $(this).serialize();
            $.ajax({
                url: "{{ route('update-scheme-details') }}",
                method: 'POST',
                data: formData,
                success: function (response) {
                    if (response.success) {
                        console.log(response.success)
                        window.location.href = "{{ route('submit-schemes-details') }}";
                    }  else{

                        $.each(response.errors, function(field, messages) {
                            var escapedKey = field.replace('.', '\\.');
                            console.log(escapedKey)
                            $("#" + escapedKey + '_error').html(messages[
                                0]);
                        });
                    }
                },
                error: function (xhr, status, error) {

                    alert('An error occurred while processing your request.');
                }
            });
        });

        $(document).on('click', '#add', function(){

            dynamic_field(count);
        });

        $(document).on('click', '.remove', function(){
// count--;
            $(this).closest("tr").remove();
        });
    });
</script>
<script>
    $(document).ready(function(){
        // Function to handle form submission
        $('form').submit(function(event){
            // Check if enrolled = 0
            if($('input[name="enrolled"]:checked').val() == '0'){
                // Set the value of each table data field to null
                $('select[name="scheme_name[]"]').val('');
                $('input[name="registration_id[]"]').val('');
                $('input[name="date[]"]').val('');
            }
        });

        // Function to handle radio button change
        $('input[type="radio"][name="enrolled"]').change(function(){
            if($(this).val() == '1'){
                // If enrolled = 1, show the table
                $('#schemeTableSection').show();
            } else {
                // If enrolled = 0, hide the table and clear its data
                $('#schemeTableSection').hide();
                $('select[name="scheme_name[]"]').val('');
                $('input[name="registration_id[]"]').val('');
                $('input[name="date[]"]').val('');
            }
        });
    });
</script>

@endsection

