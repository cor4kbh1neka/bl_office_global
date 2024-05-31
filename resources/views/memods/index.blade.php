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
        <div class="secmemods">
            <div class="groupsecmemods">
                <div class="headgroupsecmemods">
                    <a href="/memods" class="tombol grey active">
                        <span class="texttombol">create</span>
                    </a>
                    <a href="/memods/delivered" class="tombol grey">
                        <span class="texttombol">delivered</span>
                    </a>
                    <a href="/memods/viewinbox" class="tombol grey">
                        <span class="texttombol">inbox</span>
                        <span class="unreadmessage">2</span>
                    </a>
                    <a href="/memods/archiveinbox" class="tombol grey">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 6h10M7 9h10m-8 8h6" />
                                <path
                                    d="M3 12h-.4a.6.6 0 0 0-.6.6v8.8a.6.6 0 0 0 .6.6h18.8a.6.6 0 0 0 .6-.6v-8.8a.6.6 0 0 0-.6-.6H21M3 12V2.6a.6.6 0 0 1 .6-.6h16.8a.6.6 0 0 1 .6.6V12M3 12h18" />
                            </g>
                        </svg>
                        <span class="texttombol">archive</span>
                    </a>
                </div>
                <div class="groupdatamemo">
                    <form method="POST" action="/storememo" class="groupplayerinfo">
                        @csrf
                        <div class="listgroupplayerinfo left">
                            <div class="listplayerinfo">
                                <span class="labelbetpl">recipient</span>
                                <select name="statuspriority" id="statuspriority">
                                    <option value="1">All Player</option>
                                    <option value="2">VIP only</option>
                                </select>
                            </div>
                            <div class="listplayerinfo">
                                <span class="labelbetpl">priority</span>
                                <div class="groupradiooption">
                                    <div class="listgrpstatusbank">
                                        <input class="status_primary" type="radio" id="default" name="statustype"
                                            value="1" checked>
                                        <label for="allplayer">default</label>
                                    </div>
                                    <div class="listgrpstatusbank">
                                        <input class="status_primary" type="radio" id="vip" name="statustype"
                                            value="2">
                                        <label for="oneplayer">priority</label>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="listplayerinfo">
                                <label for="pengirim">pengirim</label>
                                <div class="groupeditinput">
                                    <input type="text" id="pengirim" name="pengirim" value=""
                                        placeholder="isi admin pengirim">
                                </div>
                            </div> --}}
                            <div class="listplayerinfo">
                                <label for="subject">subject</label>
                                <div class="groupeditinput">
                                    <input type="text" id="subject" name="subject" value=""
                                        placeholder="isi subject" required>
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="memo">memo</label>
                                <div class="groupeditinput">
                                    <textarea name="memo" id="memo" cols="30" rows="10" placeholder="isi keterangan memo" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="listgroupplayerinfo right solo">
                            <button class="tombol primary">
                                <span class="texttombol">SEND</span>
                            </button>
                        </div>
                    </form>
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

    @if (session('success'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                });
            });
        </script>
    @endif
@endsection
