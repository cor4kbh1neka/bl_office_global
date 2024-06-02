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

    <script>
        $(document).ready(function() {
            adjustElementSize();
        });
    </script>
</head>
<div class="sec_table newwindow">
    <div class="secgrouptitle">
        <h2>{{ $title }} </h2>
    </div>
    <div class="seceditmemberds updateagent">
        <div class="groupseceditmemberds">
            <spann class="titleeditmemberds">edit link</spann>
            <form action="/contentds/link/{{ $data->idctlnk }}" method="POST">
                @method('put')
                @csrf
                <div class="groupplayerinfo editpromo">
                    <div class="listgroupplayerinfo left">
                        <div class="listplayerinfo">
                            <label for="name">name</label>
                            <div class="groupeditinput">
                                <input type="text" readonly id="name" name="name"
                                    value="{{ $data->ctlnkname }}" placeholder="isi judul promo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                </svg>
                            </div>
                        </div>
                        <div class="listplayerinfo">
                            <label for="urldomain">url domain</label>
                            <div class="groupeditinput">
                                <input type="text" readonly id="urldomain" name="urldomain"
                                    value="{{ $data->ctlnkdmn }}" placeholder="isi link target promo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                </svg>
                            </div>
                        </div>
                        <div class="listplayerinfo">
                            <span class="labelbetpl">STATUS</span>
                            <div class="groupradiooption" data-chekced="{{ $data->statusctlnk }}">
                                <div class="listgrpstatusbank">
                                    <input class="status_online" type="radio" id="active" name="statuspromo"
                                        value="1">
                                    <label for="active">active</label>
                                </div>
                                <div class="listgrpstatusbank">
                                    <input class="status_offline" type="radio" id="inactive" name="statuspromo"
                                        value="2">
                                    <label for="inactive">in-active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="listgroupplayerinfo right solo" type="submit">
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

    // checked radio button berdasarkan value dari status 1, 2
    $(document).ready(function() {
        $('.groupradiooption[data-chekced]').each(function() {
            var checkedBankValue = $(this).attr('data-chekced');
            $(this).find('.listgrpstatusbank input[type="radio"][value="' + checkedBankValue + '"]')
                .prop('checked', true);
        });
    });
</script>
