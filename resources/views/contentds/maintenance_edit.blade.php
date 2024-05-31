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
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }} </h2>
        </div>
        <div class="seceditmemberds updateagent">
            <div class="groupseceditmemberds">
                <spann class="titleeditmemberds">Edit Status Maintenance</spann>
                <form action="/contentds/maintenance/status" method="POST">
                    @method('put')
                    @csrf
                    <div class="groupplayerinfo editpromo">
                        <div class="listplayerinfo" style="align-content: center">
                            <div class="groupradiooption" data-chekced="{{ $data->stsmtncnc }}">
                                <div class="listgrpstatusbank">
                                    <input class="status_online" type="radio" id="active" name="status" value="1">
                                    <label for="active">Running</label>
                                </div>
                                <div class="listgrpstatusbank">
                                    <input class="status_warning" type="radio" id="maintenance" name="status" value="2">
                                    <label for="maintenance">Maintenance</label>
                                </div>
                                <div class="listgrpstatusbank">
                                    <input class="status_offline" type="radio" id="inactive" name="status" value="3">
                                    <label for="inactive">Backup</label>
                                </div>
                                <div class="listgrpstatusbank">
                                    <input class="status_lainnya" type="radio" id="lainnya" name="status" value="4">
                                    <label for="lainnya">Lainnya</label>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="listgroupplayerinfo left">
                            <div class="listplayerinfo">
                                <label for="status">status</label>
                                <select class="sec_dropdown" id="status" name="status">
                                    @if($data->stsmtncnc === '1')
                                    <option disabled selected value="1">Running</option>
                                    <option value="2">Maintenance</option>
                                    <option value="3">Backup</option>
                                    <option value="4">Error</option>
                                    @elseif($data->stsmtncnc === '2')
                                    <option disabled selected value="2">Maintenance</option>
                                    <option value="1">Running</option>
                                    <option value="3">Backup</option>
                                    <option value="4">Error</option>
                                    @elseif($data->stsmtncnc === '3')
                                    <option disabled selected value="3">Backup</option>
                                    <option value="1">Running</option>
                                    <option value="2">Maintenance</option>
                                    <option value="4">Error</option>
                                    @elseif($data->stsmtncnc === '4')
                                    <option disabled selected value="4">Error</option>
                                    <option value="1">Running</option>
                                    <option value="2">Maintenance</option>
                                    <option value="3">Backup</option>
                                    @endif
                                </select>  
                            </div>
                        </div> --}}
                        <div class="listgroupplayerinfo right solo">
                            <button class="tombol primary" type="submit">
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
        $(document).ready(function(){
            $('.groupradiooption[data-chekced]').each(function(){
                var checkedBankValue = $(this).attr('data-chekced');
                $(this).find('.listgrpstatusbank input[type="radio"][value="' + checkedBankValue + '"]').prop('checked', true);
            });
        });
    </script>