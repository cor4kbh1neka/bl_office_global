<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/utama/g21-icon.ico') }}" />
    <title>Dashboard | L21</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/design.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/custom_dash.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

    {{-- <script>
        $(document).ready(function() {
            adjustElementSize();
        });
    </script> --}}
</head>
<div class="sec_table">
    <div class="secgrouptitle">
        <h2>{{ $title }} </h2>
    </div>
    <div class="seceditmemberds updateagent">
        <div class="groupseceditmemberds">
            <spann class="titleeditmemberds">edit profile</spann>
            <form method="POST" action="/agentds/update" class="groupplayerinfo" id="form-agentds">
                @csrf
                <div class="listgroupplayerinfo left">
                    <div class="listplayerinfo">
                        <label for="username">user agent</label>
                        <div class="groupeditinput">
                            <input type="hidden" name="id" value={{ $data->id }}>
                            <input type="text" disabled id="username" name="username" value="{{ $data->username }}">
                        </div>
                    </div>
                    <div class="listplayerinfo">
                        <label for="password">password baru</label>
                        <div class="groupeditinput">
                            <input type="password" id="newpassword" name="newpassword" value=""
                                placeholder="input password agent">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0" />
                            </svg>
                        </div>
                    </div>
                    <div class="listplayerinfo">
                        <label for="repassword">retype password</label>
                        <div class="groupeditinput">
                            <input type="password" id="repassword" name="repassword" value=""
                                placeholder="input password agent">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0" />
                            </svg>
                        </div>
                    </div>

                    <div class="listplayerinfo">
                        <label for="newpin">pin baru</label>
                        <div class="groupeditinput">
                            <input type="password" id="newpin" name="newpin" maxlength="6" pattern="\d*"
                                inputmode="numeric" placeholder="Input PIN agent">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0" />
                            </svg>
                        </div>
                    </div>
                    <div class="listplayerinfo">
                        <label for="repin">retype pin</label>
                        <div class="groupeditinput">
                            <input type="password" id="repin" name="repin" value=""
                                placeholder="input retype pin agent">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0" />
                            </svg>
                        </div>
                    </div>
                    <div class="listplayerinfo">
                        <label for="divisi">access type</label>
                        <select id="divisi" name="divisi">
                            <option value="superadmin" {{ $data->divisi == 'superadmin' ? 'selected' : '' }}>
                                Superadmin-Access</option>
                            @foreach ($dataAccess as $d)
                                <option value="{{ $d->name_access }}"
                                    {{ $data->divisi == $d->name_access ? 'selected' : '' }}>{{ $d->name_access }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="listgroupplayerinfo right solo">
                    <button class="tombol primary">
                        <span class="texttombol">SAVE DATA</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //show password
        $('.listplayerinfo svg').click(function() {
            var inputField = $(this).siblings('input');
            if (inputField.attr('type') === 'password') {
                inputField.attr('type', 'text');
                $(this).html(
                    '<path fill="currentColor" d="M2 5.27L3.28 4L20 20.72L18.73 22l-3.08-3.08c-1.15.38-2.37.58-3.65.58c-5 0-9.27-3.11-11-7.5c.69-1.76 1.79-3.31 3.19-4.54zM12 9a3 3 0 0 1 3 3a3 3 0 0 1-.17 1L11 9.17A3 3 0 0 1 12 9m0-4.5c5 0 9.27 3.11 11 7.5a11.8 11.8 0 0 1-4 5.19l-1.42-1.43A9.86 9.86 0 0 0 20.82 12A9.82 9.82 0 0 0 12 6.5c-1.09 0-2.16.18-3.16.5L7.3 5.47c1.44-.62 3.03-.97 4.7-.97M3.18 12A9.82 9.82 0 0 0 12 17.5c.69 0 1.37-.07 2-.21L11.72 15A3.064 3.064 0 0 1 9 12.28L5.6 8.87c-.99.85-1.82 1.91-2.42 3.13"/>'
                );
            } else {
                inputField.attr('type', 'password');
                $(this).html(
                    '<path fill="currentColor" d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0"/>'
                );
            }
        });

        $('#form-agentds').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            var password = $('#newpassword').val();
            var repassword = $('#repassword').val();

            var pin = $('#newpin').val();
            var repin = $('#repin').val();

            if (password !== '') {
                if (password !== repassword) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Password dan Retypepassword harus sama',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
            }

            if (pin !== '') {
                if (pin !== repin) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Pin dan Retypepin harus sama',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
            }

            this.submit(); // If passwords match, submit the form
        });

        $('#newpin, #repin').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 6) {
                this.value = this.value.slice(0, 6);
            }
        });
    });
</script>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    </script>
@endif

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: '<ul>' +
                @foreach ($errors->all() as $error)
                    '<li>{{ $error }}</li>' +
                @endforeach
            '</ul>',
        });
    </script>
@endif
