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
                    <a href="/analyticsds" class="tombol grey">
                        <span class="texttombol">META TAG</span>
                    </a>
                    <a href="/analyticsds/sitemap" class="tombol grey active">
                        <span class="texttombol">SITE MAP</span>
                    </a>
                </div>
                <div class="groupdataanalyticds">
                    <div class="groupsetbankmaster">
                        <a href="/analyticsds/sitemap/create" class="tombol proses">
                            <span class="texttombol">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                    <defs>
                                        <mask id="ipSAdd0">
                                            <g fill="none" stroke-linejoin="round" stroke-width="4">
                                                <rect width="36" height="36" x="6" y="6" fill="#fff" stroke="#fff" rx="3" />
                                                <path stroke="#000" stroke-linecap="round" d="M24 16v16m-8-8h16" />
                                            </g>
                                        </mask>
                                    </defs>
                                    <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSAdd0)" />
                                </svg>
                                ADD PAGE
                            </span>
                        </a>
                        <div>
                            <div class="listdatasitemap">
                                @foreach($data as $d)
                                    <div class="listgroupplayerinfo sitemap">
                                        <div class="listplayerinfo url">
                                            <label for="urpage_{{ $loop->index }}">URL Page</label>
                                            <div class="groupeditinput">
                                                <span class="textslice">/</span>
                                                <input type="text" id="urpage_{{ $loop->index }}" name="urpage" value="{{ $d->urpage }}" placeholder="Input halaman" />
                                            </div>
                                        </div>
                                        <div class="listplayerinfo">
                                            <label for="lastmod_{{ $loop->index }}">last modified</label>
                                            <div class="groupeditinput">
                                                <input type="date" id="lastmod_{{ $loop->index }}" name="lastmod" value="{{ $d->updated_at }}" />
                                            </div>
                                        </div>
                                        <div class="listgroupplayerinfo right sitemap">
                                            <div>
                                                <form action="/analyticsds/sitemap/{{ $d->urpage }}" method="POST">
                                                    @method('put')
                                                    @csrf
                                                    <input type="hidden" id="hiddenUrlPage_{{ $loop->index }}" name="urpage" value="">
                                                    <input type="hidden" id="hiddenLastmod_{{ $loop->index }}" name="lastmod" value="">
                                                    <button class="tombol primary" type="submit">
                                                        <span class="texttombol">UPDATE</span>
                                                    </button>
                                                </form>
                                            </div>
                                            <div>
                                                <form action="/analyticsds/sitemap/{{ $d->urpage }}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="tombol primary" type="submit" onclick="return confirm('Yakin ingin hapus data ini?')">
                                                        <span class="texttombol">Delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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

        document.addEventListener('DOMContentLoaded', function() {
            const urlPageInputs = document.querySelectorAll('input[id^="urpage_"]');
            urlPageInputs.forEach(function(input) {
                const index = input.id.split('_')[1];
                const hiddenUrlPageInput = document.getElementById('hiddenUrlPage_' + index);

                input.addEventListener('input', function() {
                    hiddenUrlPageInput.value = input.value;
                });

                hiddenUrlPageInput.value = input.value;
            });

            const lastmodInputs = document.querySelectorAll('input[id^="lastmod_"]');
            lastmodInputs.forEach(function(input) {
                const index = input.id.split('_')[1];
                const hiddenLastmodInput = document.getElementById('hiddenLastmod_' + index);

                input.addEventListener('input', function() {
                    hiddenLastmodInput.value = input.value;
                });

                hiddenLastmodInput.value = input.value;
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
    @elseif(session()->has('warning'))
    <script>
        Swal.fire({
            text: '{{ session('warning') }}',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
@endsection
