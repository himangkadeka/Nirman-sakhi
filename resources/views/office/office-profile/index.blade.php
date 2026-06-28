@extends('layouts.admin-app')

@section('title', 'Office | Profile')
@section('breadcrumb_item_1', 'Office')
@section('breadcrumb_item_2', 'Profile')
@section('style')

@endsection


@section('content')
    <div class="container-fluid">
        <div class="my-1" id="b-homedb">
            <div class="container">
                <div class="col-md-12 p-sm-5">
                    <div class="w-sm-50 w-auto mx-auto">
                        <form id="profile-form" action="{{ route('office.office-profile.update') }}" method="POST">
                            @csrf
                            <div class=" form-group d-flex">
                                <div class="mr-4 w-100">
                                    <label for="name" class="bold">User Name</label><span style="color:red;"> *</span>
                                    <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                        id="username" name="username" value="{{ Auth::user()->username }}"
                                        placeholder="Enter first name">
                                </div>
                            </div>


                            <div class=" form-group d-flex">
                                <div class="mr-4 w-100">
                                    <label for="name" class="bold">First Name</label><span style="color:red;">
                                        *</span>
                                    <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                        id="firstname" name="firstname" value="{{ Auth::user()->firstname }}"
                                        placeholder="Enter first name">
                                </div>
                            </div>

                            <div class=" form-group d-flex">
                                <div class="mr-4 w-100">
                                    <label for="name" class="bold">Last Name</label><span style="color:red;"> *</span>
                                    <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                        id="lastname" name="lastname" value="{{ Auth::user()->lastname }}"
                                        placeholder="Enter Last name">
                                </div>
                            </div>

                            <div class="form-group d-flex">
                                <div class="mr-4 w-100">
                                    <label for="email" class="bold">Email</label><span style="color:red;"> *</span>
                                    <input type="email" class="form-control custom-bottom-border uc-text-smooth"
                                        id="email" name="email"
                                        value="{{ str_replace(['[at]', '[dot]'], ['@', '.'], Auth::user()->email) }}"
                                        placeholder="Enter Email">
                                </div>
                            </div>

                            <div class="form-group d-flex">
                                <div class="mr-4 w-100">
                                    <label for="inputPhone" class="bold">Phone Number </label>
                                    <input type="text" value="{{ Auth::user()->phone }}" name="phone"
                                        class="form-control custom-bottom-border" maxlength="10" id="phone"
                                        placeholder="Enter Phone Number">
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary btn-sm">Save Details</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif


        </div>
    </div>
@endsection

@section('footer')
<script>
    document.getElementById('profile-form').addEventListener('submit', function (event) {
        const emailField = document.getElementById('email');
        let email = emailField.value;
        email = email.replace(/@/g, '[at]').replace(/\./g, '[dot]');
        emailField.value = email;
    });
</script>

@endsection
