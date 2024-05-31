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
        <div class="secanalyticds">
            <div class="groupsecanalyticds">
                <div class="headsecanalyticds">
                    <a href="/analyticsds" class="tombol grey active">
                        <span class="texttombol">META TAG</span>
                    </a>
                    <a href="/analyticsds/sitemap" class="tombol grey">
                        <span class="texttombol">SITE MAP</span>
                    </a>
                </div>
                <div class="informasipengisiandata">
                    <span class="titleinformasi">Mohon diperhatikan :</span>
                    <ul>
                        <li>Harap hindari penginputan karakter illegal seperti "日本人 中國的éè;∞भारत¥₤€קום " agar tampilan/script berjalan lancar. terima kasih</li>
                        <li>Untuk membantu pengecekan. bisa melalui link ini <a href="https://pages.cs.wisc.edu/~markm/ascii.html" target="_blank">https://pages.cs.wisc.edu/~markm/ascii.html</a></li>
                    </ul>
                </div>
                <div class="groupdataanalyticds">
                    <div class="groupsetbankmaster">
                        <form action="/analyticsds" method="post">
                            @csrf
                            <div class="groupplayerinfo">
                                <div class="listgroupplayerinfo left">
                                    <div class="listplayerinfo">
                                        <label for="metatag">meta tag HTML</label>
                                        <div class="groupeditinput">
                                            <textarea type="text" id="metatag" name="metatag" cols="30" rows="5" placeholder="Masukkan Meta Tag HTML">{{ $data->mttag }}</textarea>
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="article">article</label>
                                        <div class="groupeditinput">
                                            <textarea type="text" id="article" name="article" cols="30" rows="5" placeholder="Masukkan Artikel">{{ $data->artcl }}</textarea>
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="script_livechat">script livechat</label>
                                        <div class="groupeditinput">
                                            <textarea type="text" id="script_livechat" name="script_livechat" cols="30" rows="5" placeholder="Masukkan script Livechat">{{ $data->scrptlvc }}</textarea>
                                        </div>
                                    </div>
                                </div>
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
    @if(session()->has('success'))
    <script>
        Swal.fire({
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
    @elseif(session()->has('error'))
    <script>
        Swal.fire({
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
@endsection
