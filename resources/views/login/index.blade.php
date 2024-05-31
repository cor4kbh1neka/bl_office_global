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
</head>

<body>
    <section class="containterlogin">
        <form action="" method="POST">
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

                        @if (session()->has('loginError'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('loginError') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <h1>LOGIN</h1>
                        <p>Enter your username & password to login</p>
                    </div>
                    <div class="listformlogin">
                        <form role="form" action="/login" method="post">
                            @csrf

                        </form>
                        <span class="titleinput">username</span>
                        <div class="groupinputlogin">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                            <input type="text" class="@error('username') is-invalid @enderror" id="username"
                                name="username" placeholder="Username" autofocus required value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="listformlogin">
                        <span class="titleinput">Password</span>
                        <div class="groupinputlogin">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                                <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                            </svg>
                            <input type="password" id="password" name="password"
                                class="@error('password') is-invalid @enderror" placeholder="Password" required>

                        </div>
                    </div>
                    <button class="cupbtn primary">Sign in</button>
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
