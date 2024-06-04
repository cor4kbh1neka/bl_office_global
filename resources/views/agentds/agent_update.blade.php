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
            <form method="POST" action="/agentds/update" class="groupplayerinfo">
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
            <spann class="titleeditmemberds change">agent setting</spann>
            <form method="POST" action="/agentds/storesetting" class="groupplayerinfo">
                @csrf
                <div class="groupplayerinfo">
                    <div class="listgroupplayerinfo left">
                        <div class="listplayerinfo">
                            <label for="min">minimal bet</label>
                            <div class="groupeditinput">
                                <input type="number" readonly id="min" name="min" value="10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                </svg>
                            </div>
                        </div>
                        <div class="listplayerinfo">
                            <label for="max">maksimal bet</label>
                            <div class="groupeditinput">
                                <input type="number" readonly id="max" name="max" value="10000">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                </svg>
                            </div>
                        </div>
                        <div class="listplayerinfo ssreff">
                            <span class="labelbonusreff">Bonus Referral</span>
                            <div class="groupbnsreff">
                                <div class="listreff">
                                    <label for="sportsbook">sportsbook (%)</label>
                                    <input type="number" id="sportsbook" name="sportsbook" value="0.2"
                                        placeholder="% referral">
                                </div>
                                <div class="listreff">
                                    <label for="virtualsports">virtualsports (%)</label>
                                    <input type="number" id="virtualsports" name="virtualsports" value="0.2"
                                        placeholder="% referral">
                                </div>
                                <div class="listreff">
                                    <label for="games">games (%)</label>
                                    <input type="number" id="games" name="games" value="0.2"
                                        placeholder="% games">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="listgroupplayerinfo right solo">
                        <button class="tombol primary">
                            <span class="texttombol">SAVE DATA</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.groupeditinput svg').click(function() {
            $(this).closest('.groupeditinput').toggleClass('edit');
            $(this).siblings('input').prop('readonly', function(_, val) {
                return !val;
            });
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
