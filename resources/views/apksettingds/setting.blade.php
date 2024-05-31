@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor" d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>
        <div class="seccontentds">
            <div class="groupseccontentds">
                <div class="headseccontentds">
                    <a href="/apksettingds" class="tombol grey">
                        <span class="texttombol">NOTIFICATION</span>
                    </a>
                    <a href="/apksettingds/setting" class="tombol grey active">
                        <span class="texttombol">SETTING</span>
                    </a>
                    <a href="/apksettingds/event" class="tombol grey">
                        <span class="texttombol">EVENT</span>
                    </a>
                </div>
                <div class="groupdataanalyticds">
                    <div class="groupsetbankmaster">
                        <div class="groupplayerinfo">
                            <div class="listgroupplayerinfo left">
                                <div class="listplayerinfo">
                                    <label for="home">home</label>
                                    <div class="groupeditinput">
                                        <input type="text" id="home" name="home" placeholder="input url contoh : https://example.com">
                                    </div>
                                </div>
                                <div class="listplayerinfo">
                                    <label for="server1">server 1</label>
                                    <div class="groupeditinput">
                                        <input type="text" id="server1" name="server1" placeholder="input url contoh : https://example.com">
                                    </div>
                                </div>
                                <div class="listplayerinfo">
                                    <label for="server2">server 2</label>
                                    <div class="groupeditinput">
                                        <input type="text" id="server2" name="server2" placeholder="input url contoh : https://example.com">
                                    </div>
                                </div>
                                <div class="listplayerinfo">
                                    <label for="server3">server 3</label>
                                    <div class="groupeditinput">
                                        <input type="text" id="server3" name="server3" placeholder="input url contoh : https://example.com">
                                    </div>
                                </div>
                                <div class="listplayerinfo">
                                    <label for="promo">promo</label>
                                    <div class="groupeditinput">
                                        <input type="text" id="promo" name="promo" placeholder="input url contoh : https://example.com">
                                    </div>
                                </div>
                                <div class="listplayerinfo">
                                    <label for="pwa">PWA</label>
                                    <div class="groupeditinput">
                                        <input type="text" id="pwa" name="pwa" placeholder="input url contoh : https://example.com">
                                    </div>
                                </div>
                                <div class="listplayerinfo">
                                    <label for="penilaian">penilaian</label>
                                    <div class="groupeditinput">
                                        <input type="text" id="penilaian" name="penilaian" placeholder="input url contoh : https://example.com">
                                    </div>
                                </div>
                                <div class="listplayerinfo">
                                    <label for="version">APK version</label>
                                    <div class="groupeditinput">
                                        <input type="text" id="version" name="version" placeholder="versi apk contoh : v1.0">
                                    </div>
                                </div>
                            </div>
                            <div class="listgroupplayerinfo right solo">
                                <button class="tombol primary">
                                    <span class="texttombol">SAVE DATA</span>
                                </button>
                            </div>
                        </div>
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

        // toggle switch
        $(document).ready(function(){
            if ($('input[name="switch_active[]"]').val() == 1) {
                $('#maintenance').prop('checked', true);
            }

            $('label[for="maintenance"]').click(function(){
                var currentValue = $('input[name="switch_active[]"]').val();
                var newValue = (currentValue == 1) ? 0 : 1;
                $('input[name="switch_active[]"]').val(newValue);
                if (newValue == 0) {
                    $('#maintenance').prop('checked', true);
                } else {
                    $('#maintenance').prop('checked', false);
                }
            });
        });
    </script>
@endsection
