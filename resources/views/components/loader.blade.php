<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>loader</title>
    <style>
        .loader-container {
            background: rgba(0, 0, 0, 0.6);
            bottom: 0;
            left: 0;
            overflow: hidden;
            position: fixed;
            text-align: center;
            right: 0;
            top: 0;
            z-index: 9998;

        }

        .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 28px;
            aspect-ratio: 1;
            border-radius: 50%;
            background: #0f3a47;
            transform-origin: top;
            display: grid;
            animation: l3-0 1s infinite linear;
        }

        .loader::before,
        .loader::after {
            content: "";
            grid-area: 1/1;
            background: #ffffff;
            border-radius: 50%;
            transform-origin: top;
            animation: inherit;
            animation-name: l3-1;
        }

        .loader::after {
            background: #FFD700;
            --s: 180deg;
        }

        @keyframes l3-0 {

            0%,
            20% {
                transform: rotate(0)
            }

            100% {
                transform: rotate(360deg)
            }
        }

        @keyframes l3-1 {
            50% {
                transform: rotate(var(--s, 90deg))
            }

            100% {
                transform: rotate(0)
            }
        }
    </style>
</head>

<body>
    <div class="loader-container">
        <div class="loader"></div>
    </div>
</body>

</html>
