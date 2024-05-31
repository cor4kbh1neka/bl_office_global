@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>
        <div class="secbankds">
            <div class="groupsecbankds">
                <div class="headsecbankds">
                    <a href="/bankds" class="tombol grey">
                        <span class="texttombol">ACTIVE BANK</span>
                    </a>
                    <a href="/bankds/addbankmaster" class="tombol grey active">
                        <span class="texttombol">ADD & SET MASTER</span>
                    </a>
                    <a href="/bankds/addgroupbank" class="tombol grey">
                        <span class="texttombol">ADD & SET GROUP</span>
                    </a>
                    <a href="/bankds/addbank" class="tombol grey">
                        <span class="texttombol">ADD & SET BANK</span>
                    </a>
                    <a href="/bankds/listmaster" class="tombol grey">
                        <span class="texttombol">LIST MASTER</span>
                    </a>
                    <a href="/bankds/listgroup" class="tombol grey">
                        <span class="texttombol">LIST GROUP</span>
                    </a>
                    <a href="/bankds/listbank/0/0" class="tombol grey">
                        <span class="texttombol">LIST BANK</span>
                    </a>
                    <a href="/bankds/xdata" class="tombol grey">
                        <span class="texttombol">X DATA</span>
                    </a>
                </div>
                <div class="secgroupdatabankds">
                    <div class="groupsetbankmaster">
                        <span class="titlebankmaster">Tambah Bank Master</span>
                        <form method="POST" action="/storemaster" class="groupplayerinfo">
                            @csrf
                            <div class="listgroupplayerinfo left">
                                <div class="listplayerinfo">
                                    <label for="bankmaster">nama bank</label>
                                    <div class="groupeditinput">
                                        <input type="text" id="bankmaster" name="bnkmstrxyxyx" value=""
                                            placeholder="nama bank (isi menggunakan huruf kecil semua)" required>
                                    </div>
                                </div>
                                <div class="listplayerinfo">
                                    <span class="labelbetpl">STATUS</span>
                                    <div class="groupradiooption">
                                        <div class="listgrpstatusbank">
                                            <input class="status_online" type="radio" id="depo_online_bca"
                                                name="statusxyxyy" value=1 checked>
                                            <label for="depo_online_bca">online</label>
                                        </div>
                                        <div class="listgrpstatusbank">
                                            <input class="status_offline" type="radio" id="depo_offline_bca"
                                                name="statusxyxyy" value=2>
                                            <label for="depo_offline_bca">offline</label>
                                        </div>
                                        <div class="listgrpstatusbank">
                                            <input class="status_trouble" type="radio" id="depo_trouble_bca"
                                                name="statusxyxyy" value=3>
                                            <label for="depo_trouble_bca">trouble</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="listplayerinfo">
                                    <label for="urllogo">url logo</label>
                                    <div class="groupeditinput">
                                        <input type="text" id="urllogo" name="urllogoxxyx" value=""
                                            placeholder="url logo (isi menggunakan huruf kecil semua)" required>
                                    </div>
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
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#myCheckbox').change(function() {
                var isChecked = $(this).is(':checked');

                $('tbody tr:not([style="display: none;"]) [id^="myCheckbox-"]').prop('checked', isChecked);
            });
        });

        $(document).ready(function() {
            $('#myCheckbox, [id^="myCheckbox-"]').change(function() {
                var isChecked = $('#myCheckbox:checked, [id^="myCheckbox-"]:checked').length > 0;
                if (isChecked) {
                    $('.all_act_butt').css('display', 'flex');
                } else {
                    $('.all_act_butt').hide();
                }
            });

        });

        // clear readonly
        $(document).ready(function() {
            $('.groupeditinput svg').click(function() {
                $(this).closest('.groupeditinput').toggleClass('edit');
                $(this).siblings('input').prop('readonly', function(_, val) {
                    return !val;
                });
            });
        });

        // checked radio button berdasarkan value dari status bank 1, 2, 3
        $(document).ready(function() {
            $('.groupradiooption[data-chekced]').each(function() {
                var checkedBankValue = $(this).attr('data-chekced');
                $(this).find('.listgrpstatusbank input[type="radio"][value="' + checkedBankValue + '"]')
                    .prop('checked', true);
            });
        });

        // dropdown selected
        $(document).ready(function() {
            var selectedValue = $('#groupbank').val();
            $('#groupbank option[value="' + selectedValue + '"]').attr('selected', 'selected');
        });
    </script>

    {{-- @dd(session('error')) --}}

    @if (session('error'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                });
            });
        </script>
    @endif
@endsection
