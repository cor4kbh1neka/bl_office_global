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
                    <a href="/contentds" class="tombol grey active">
                        <span class="texttombol">GENERAL</span>
                    </a>
                    <a href="/contentds/promo" class="tombol grey">
                        <span class="texttombol">PROMO</span>
                    </a>
                    <a href="/contentds/slider" class="tombol grey">
                        <span class="texttombol">SLIDER</span>
                    </a>
                    <a href="/contentds/link" class="tombol grey">
                        <span class="texttombol">LINK</span>
                    </a>
                    <a href="/contentds/socialmedia" class="tombol grey">
                        <span class="texttombol">SOCIAL MEDIA</span>
                    </a>
                    <a href="/contentds/maintenance" class="tombol grey">
                        <span class="texttombol">STATUS MAINTENANCE</span>
                    </a>
                </div>
                <div class="groupdataanalyticds">
                    <div class="groupsetbankmaster">
                        <form action="/contentds/{{ $data->idnmwebst }}" method="POST">
                            @method('put')
                            @csrf
                            <div class="groupplayerinfo">
                                <div class="listgroupplayerinfo left">
                                    <div class="listplayerinfo">
                                        <label for="sitename">nama website</label>
                                        <div class="groupeditinput">
                                            <input type="text" id="sitename" name="sitename" value="{{ $data->nmwebsite }}" readonly placeholder="nama website">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="urllogo">url logo</label>
                                        <div class="groupeditinput">
                                            <input type="text" id="urllogo" name="urllogo" value="{{ $data->logrl }}" readonly placeholder="url logo">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="urlicon">url icon</label>
                                        <div class="groupeditinput">
                                            <input type="text" id="urlicon" name="urlicon" value="{{ $data->icrl }}" readonly placeholder="url icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="urlapk">url apk download</label>
                                        <div class="groupeditinput">
                                            <input type="text" id="urlapk" name="urlapk" value="{{ $data->pkrl }}" readonly placeholder="url download apk">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="runningtext">running text</label>
                                        <div class="groupeditinput">
                                            <input type="text" id="runningtext" name="runningtext" value="{{ $data->rnntxt }}" readonly placeholder="isi running text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                            </svg>
                                        </div>
                                    </div>
                                    {{-- <div class="listplayerinfo">
                                        <label for="mtschedule">maintenance schedule</label>
                                        <div class="groupeditinput">
                                            <input type="datetime-local" id="mtschedule" name="mtschedule" value="">
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="maintenance">maintenance</label>
                                        <div class="sec_togle">
                                            <input type="checkbox" id="maintenance" name="switch_active[]" value="0"> <!-- value adalah nilai dari switch maintenance -->
                                            <label for="maintenance" class="sec_switch"></label>
                                        </div>
                                    </div> --}}
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
        </div>
    </div>
    @if(session('success'))
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
