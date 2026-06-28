<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        /* @media (min-width: 788px) and (max-width: 1153px) {
            .cmimage{

            }
        } */
        @media (max-width: 2000px) {

            .cmimage{
                margin-left:auto;
            }
        }
        @media (max-width: 1440px) {

    .cmimage{
        margin-left:33px;
    }
    }

    </style>
</head>
<body>

    <!-- (id="b-homedb") for skip content-->

    <section class="container-fluid" style="background-image: url('/assets/template/images/inner-img/banner.png'); height:550px; width:100%" id="b-homedb">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-5 mt-5 order-md-2">
                <img class="cmimage" height="500px" src="{{ asset('assets/template/images/inner-img/CM.png') }}" style="margin-left: -40px;">
            </div>

            <div class="col-md-7 order-md-1 order-1">
                <div class="col-md-10 col-lg-8   text-md-left">
                    <h2 class="ml-1 mb-2" style="color: darkslategray">LOREM IPSUM</h2>
                    <h3 class="ml-1 font-weight-bold" style="color: darkslategray; margin-bottom: 20px">LOREM IPSUM LO</h3>
                    <div class="ml-1" style="background-color: #f2cc5f; height:2px; width:80%;"></div>

                    <p class="ml-1 mt-3 mb-3 h5 font-weight-normal " style="margin-top: 20px">
                        {{-- Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ullamcorper pretium leo, vel
                        vehicula felis faucibus vitae. Aliquam fringilla viverra nunc, non hendrerit velit accumsan id.
                        Maecenas vel ante orci. Aliquam a ex ac velit laoreet luctus. Nunc pretium libero nibh. Phasellus a
                        sem non nulla dictum faucibus lacinia in mauris. Maecenas id elementum ligula. Etiam in orci erat.
                        Maecenas massa magna, tincidunt in nisi sed, ultrices eleifend mauris. Maecenas sit amet rutrum
                        nibh. --}}
                    </p>
                </div>
            </div>
        </div>
    </section>


    <section class="container-fluid"
        style="background-image: url('/assets/template/images/inner-img/banner.png'); background-size: cover;" id="b-homedb">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-5 mt-5 order-md-2">
                <img class="mx-5 " height="500px" src="{{ asset('assets/template/images/inner-img/Sanjoy Kishan Minister1.png') }}">
            </div>

            <div class="col-md-7 order-md-1 order-1">
                <div class="col-md-10 col-lg-8 text-md-left">
                    <h2 class="ml-1 mb-2" style="color: darkslategray">LOREM IPSUM</h2>
                    <h3 class="ml-1 font-weight-bold" style="color: darkslategray; margin-bottom: 20px">LOREM IPSUM LO</h3>
                    <div class="ml-1" style="background-color: #f2cc5f; height:2px; width:80%;"></div>

                    <p class="ml-1 mt-3 mb-3 h5 font-weight-normal " style="margin-top: 20px">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ullamcorper pretium leo, vel
                        vehicula felis faucibus vitae. Aliquam fringilla viverra nunc, non hendrerit velit accumsan id.
                        Maecenas vel ante orci. Aliquam a ex ac velit laoreet luctus. Nunc pretium libero nibh. Phasellus a
                        sem non nulla dictum faucibus lacinia in mauris. Maecenas id elementum ligula. Etiam in orci erat.
                        Maecenas massa magna, tincidunt in nisi sed, ultrices eleifend mauris. Maecenas sit amet rutrum
                        nibh.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- Optional: Add Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> --}}


</body>
</html>
