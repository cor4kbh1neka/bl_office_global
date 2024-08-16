<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/utama/g21-icon.ico') }}">
    <title>Login | L21</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <style>
        .pin_attempts {
            color: var(--red-color);
        }
    </style>
</head>

<body>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            });
        </script>
    @endif
    <section class="containterlogin pin">
        <form action="/pin/validate" method="POST">
            @csrf
            <div class="loginpart">
                <img src="{{ asset('/assets/img/utama/logo.png') }}" alt="logo">
                <div class="formlogin">
                    <div class="headformlogin">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- @if (session()->has('loginError'))
                            <script>
                                $(document).ready(function() {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Login Error',
                                        text: '{{ session('loginError') }}',
                                        confirmButtonText: 'OK'
                                    });
                                });
                            </script>
                        @endif --}}
                        <h1>PIN</h1>
                        <p>Enter your pin to login</p>
                    </div>

                    <div class="listformlogin">
                        <div class="groupinputpin">
                            <input type="password" id="pin1" name="pin1" maxlength="1"
                                class="pin-input @error('pin1') is-invalid @enderror" required readonly>
                            <input type="password" id="pin2" name="pin2" maxlength="1"
                                class="pin-input @error('pin2') is-invalid @enderror" required readonly>
                            <input type="password" id="pin3" name="pin3" maxlength="1"
                                class="pin-input @error('pin3') is-invalid @enderror" required readonly>
                            <input type="password" id="pin4" name="pin4" maxlength="1"
                                class="pin-input @error('pin4') is-invalid @enderror" required readonly>
                            <input type="password" id="pin5" name="pin5" maxlength="1"
                                class="pin-input @error('pin5') is-invalid @enderror" required readonly>
                            <input type="password" id="pin6" name="pin6" maxlength="1"
                                class="pin-input @error('pin6') is-invalid @enderror" required readonly>
                        </div>
                    </div>
                    <div class="listformlogin">
                        <div class="groupinputlogin">
                            <div class="numpad">
                                <button type="button" class="numpad-btn">7</button>
                                <button type="button" class="numpad-btn">8</button>
                                <button type="button" class="numpad-btn">9</button>
                                <button type="button" class="numpad-btn">4</button>
                                <button type="button" class="numpad-btn">5</button>
                                <button type="button" class="numpad-btn">6</button>
                                <button type="button" class="numpad-btn">1</button>
                                <button type="button" class="numpad-btn">2</button>
                                <button type="button" class="numpad-btn">3</button>
                                <button type="button" class="numpad-btn zero">0</button>
                                <button type="button" class="delete"><svg style="position: static !important"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-backspace">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M20 6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-11l-5 -5a1.5 1.5 0 0 1 0 -2l5 -5z" />
                                        <path d="M12 10l4 4m0 -4l-4 4" />
                                    </svg></button>
                            </div>
                        </div>
                    </div>
                    <button class="cupbtn primary">Confirm</button>
                    <p>
                        Try : <b class="pin_attempts"> {{ 3 - auth()->user()->pin_attempts }} </b>
                    </p>
                    <div class="copyright">
                        <p>© Copyright 2010 - 2024 L21 All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <script src="{{ asset('/assets/js/script.js') }}"></script>

</body>

</html>
