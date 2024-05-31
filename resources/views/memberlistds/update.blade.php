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
    <div class="seceditmemberds">
        <div class="groupseceditmemberds">
            <spann class="titleeditmemberds">player information</spann>
            <form action="/memberlistds/updateuser/{{ $id }}" method="POST" class="groupplayerinfo"
                data-statusakun="9" id="form-user">
                @csrf
                <div class="listgroupplayerinfo left">
                    <div class="listplayerinfo">
                        <label for="xyusernamexxy">username</label>
                        <input type="hidden" value="{{ $datauser['xyusernamexxy'] }}" name="xyusernamexxy">
                        <input class="nosabel" readonly type="text" id="xyusernamexxy" name="xyusernamexxy"
                            value="{{ $datauser['xyusernamexxy'] }}">
                    </div>
                    <div class="listplayerinfo">
                        <label for="isverified">verified status</label>
                        <select name="isverified" id="isverified" value="">
                            <option value="0" {{ $datauser['is_verified'] == '0' ? 'selected' : '' }}>not verified
                            </option>
                            <option value="1" {{ $datauser['is_verified'] == '1' ? 'selected' : '' }}>verified
                            </option>
                        </select>
                    </div>
                    <div class="listplayerinfo">
                        <label for="xybanknamexyy">nama bank</label>
                        <div class="groupeditinput">
                            <input type="text" readonly id="xybanknamexyy" name="xybanknamexyy"
                                value="{{ $datauser['xybanknamexyy'] }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                            </svg>
                        </div>
                    </div>
                    <div class="listplayerinfo">
                        <label for="xybankuserxy">nama rekening</label>
                        <div class="groupeditinput">
                            <input type="text" readonly id="xybankuserxy" name="xybankuserxy"
                                value="{{ $datauser['xybankuserxy'] }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                            </svg>
                        </div>
                    </div>
                    <div class="listplayerinfo">
                        <label for="xxybanknumberxy">nomor rekening</label>
                        <div class="groupeditinput">
                            <input type="text" readonly id="xxybanknumberxy" name="xxybanknumberxy"
                                value="{{ $datauser['xxybanknumberxy'] }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                            </svg>
                        </div>
                    </div>
                    <div class="listplayerinfo">
                        <label for="xyx11xuser_mailxxyy">xyx11xuser_mailxxyy</label>
                        <input class="nosabel" readonly type="text" id="xyx11xuser_mailxxyy"
                            name="xyx11xuser_mailxxyy"
                            value="{{ substr_replace($datauser['xyx11xuser_mailxxyy'], str_repeat('*', 5), 0, 5) }}">
                    </div>
                    <div class="listplayerinfo">
                        <label for="xynumbphonexyyy">nomor hp</label>
                        <input class="nosabel" readonly type="text" id="xynumbphonexyyy" name="xynumbphonexyyy"
                            value="{{ substr_replace($datauser['xynumbphonexyyy'], str_repeat('*', 5), 0, 5) }}">
                    </div>
                    <div class="listplayerinfogrp">
                        <div class="datalistplayerinfogrp">
                            <label for="group">group bank deposit</label>
                            <select name="group" id="group">
                                <option value="" place="" style="color: #838383; font-style: italic;"
                                    disabled="">pilih group</option>
                                <option value="groupbank1" {{ $datauser['group'] == 'groupbank1' ? 'selected' : '' }}>
                                    groupbank1</option>
                                <option value="groupbank2" {{ $datauser['group'] == 'groupbank2' ? 'selected' : '' }}>
                                    groupbank2</option>
                                <option value="groupbank3" {{ $datauser['group'] == 'groupbank3' ? 'selected' : '' }}>
                                    groupbank3</option>
                                <option value="groupbank4" {{ $datauser['group'] == 'groupbank4' ? 'selected' : '' }}>
                                    groupbank4</option>
                            </select>
                        </div>
                        <div class="datalistplayerinfogrp">
                            <label for="groupwd">group bank withdraw</label>
                            <select name="groupwd" id="groupwd">
                                <option value="" place="" style="color: #838383; font-style: italic;"
                                    disabled="">pilih group</option>
                                <option value="groupbank1"
                                    {{ $datauser['groupwd'] == 'groupbank1' ? 'selected' : '' }}>
                                    groupbank1</option>
                                <option value="groupbank2"
                                    {{ $datauser['groupwd'] == 'groupbank2' ? 'selected' : '' }}>groupbank2
                                </option>
                                <option value="groupbank3"
                                    {{ $datauser['groupwd'] == 'groupbank3' ? 'selected' : '' }}>groupbank3
                                </option>
                                <option value="groupbank4"
                                    {{ $datauser['groupwd'] == 'groupbank4' ? 'selected' : '' }}>groupbank4
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="listgroupplayerinfo right">
                    <button class="tombol cancel" type="button" id="suspend">
                        <span class="texttombol">SUSPEND PLAYER</span>
                    </button>
                    <button class="tombol primary" type="submit">
                        <span class="texttombol">SAVE DATA</span>
                    </button>
                </div>
            </form>
            <spann class="titleeditmemberds change">cange data player</spann>
            <div class="groupchangedataplayer">
                <form action="/memberlistds/updatepassword/{{ $id }}" class="listchangedataplayer"
                    method="POST" id="form-password">
                    @csrf
                    <div class="groupinputchangedataplayer">
                        <input type="hidden" id="xyusernamexxy" name="xyusernamexxy"
                            value="{{ $datauser['xyusernamexxy'] }}">
                        <label for="changepassword">CHANGE PASSWORD</label>
                        <input type="password" id="changepassword" name="changepassword"
                            placeholder="masukkan password baru" required>
                        <input type="password" id="repassword" name="repassword"
                            placeholder="konsfirmasi password baru" required>
                    </div>
                    <div class="groupbuttonplayer">
                        <button class="tombol primary" type="submit">
                            <span class="texttombol">SAVE DATA</span>
                        </button>
                    </div>
                </form>
                <div class="centerborder"></div>
                <form action="/memberlistds/updateinfomember/{{ $id }}" class="listchangedataplayer"
                    method="POST" id="form-infomember">
                    @csrf
                    <label for="changepassword">CHANGE INFORMATION</label>
                    <input type="text" id="informasiplayer" name="informasiplayer"
                        placeholder="masukkan informasi player" value="{{ $data->keterangan }}">
                    <div class="groupstatuspl">
                        <label for="statuspl">STATUS</label>
                        <select name="status" id="status" value="9">
                            <option value="" place="" style="color: #838383; font-style: italic;"
                                disabled="">PILIH STATUS</option>
                            <option value="9" {{ $data->status == 9 ? 'selected' : '' }}>new member</option>
                            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>default</option>
                            <option value="2" {{ $data->status == 2 ? 'selected' : '' }}>VVIP</option>
                            <option value="3" {{ $data->status == 3 ? 'selected' : '' }}>bandar</option>
                            <option value="4" {{ $data->status == 4 ? 'selected' : '' }}>warning</option>
                            <option value="5" {{ $data->status == 5 ? 'selected' : '' }}>suspend</option>
                        </select>
                    </div>
                    <div class="groupdatbetpl">
                        <span class="labelbetpl">BET</span>
                        <div class="groupdatabet">
                            <label for="minbet">minimal</label>
                            <input type="number" id="minbet" name="minbet"
                                value={{ $data->min_bet == '' ? 10 : $data->min_bet }}>
                        </div>
                        <div class="groupdatabet">
                            <label for="maxbet">minimal</label>
                            <input type="number" id="maxbet" name="maxbet"
                                value={{ $data->min_bet == '' ? 50000 : $data->min_bet }}>
                        </div>
                    </div>
                    <div class="groupbuttonplayer">
                        <button class="tombol primary" type="submit">
                            <span class="texttombol">SAVE DATA</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if (session('success'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000
            });
        });
    </script>
@endif

@if (session('error'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                timer: 3000
            });
        });
    </script>
@endif

<script>
    $(document).ready(function() {
        $('.groupeditinput svg').click(function() {
            $(this).closest('.groupeditinput').toggleClass('edit');
            $(this).siblings('input').prop('readonly', function(_, val) {
                return !val;
            });
        });
    });

    $(document).ready(function() {
        $('#form-password').submit(function(e) {
            e.preventDefault();

            var password = $('#changepassword').val();
            var repassword = $('#repassword').val();

            if (password !== repassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Password dan konfirmasi password tidak cocok!',
                    timer: 3000
                });
                return;
            }

            this.submit();
        });
    });

    $(document).ready(function() {
        $("#suspend").click(function() {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Anda yakin ingin menonaktifkan pemain?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, nonaktifkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan tindakan nonaktifkan pemain di sini
                    Swal.fire(
                        'Nonaktifkan!',
                        'Pemain telah dinonaktifkan.',
                        'success'
                    );
                }
            });
        });
    });
</script>
