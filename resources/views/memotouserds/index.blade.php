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
        <div class="secmemods">
            <div class="groupsecmemods">
                <div class="headgroupsecmemods">
                    <a href="/memotouserds" class="tombol grey active">
                        <span class="texttombol">create</span>
                    </a>
                    <a href="/memotouserds/delivered" class="tombol grey">
                        <span class="texttombol">delivered</span>
                    </a>
                </div>
                <div class="groupdatamemo">
                    <div class="groupplayerinfo">
                        <div class="listgroupplayerinfo left">
                            <div class="listplayerinfo">
                                <label for="pengirim">pengirim</label>
                                <div class="groupeditinput">
                                    <input type="text" id="pengirim" name="pengirim" value="" placeholder="isi pengirim">
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="subject">subject</label>
                                <div class="groupeditinput">
                                    <input type="text" id="subject" name="subject" value="" placeholder="isi subject">
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="textmemo">memo</label>
                                <div class="groupeditinput">
                                    <textarea name="textmemo" id="textmemo" cols="30" rows="10" placeholder="isi keterangan memo"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="listgroupplayerinfo right solo">
                            <button class="tombol primary">
                                <span class="texttombol">SEND</span>
                            </button>
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
    </script>
@endsection
