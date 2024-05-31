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
                    <a href="/contentds" class="tombol grey">
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
                    <a href="/contentds/maintenance" class="tombol grey active">
                        <span class="texttombol">STATUS MAINTENANCE</span>
                    </a>
                </div>
                <div class="groupdatasecagentds">
                    <div class="tabelproses slider">
                        <table id="sortable-table">
                            <tbody>
                                <tr class="hdtable">
                                    <th class="bagno">#</th>
                                    <th class="action">Status Maintenance</th>
                                    <th class="action">Tools</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <div class="sec_card_count">
                                            <div class="prog_icon_circle primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-news" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11" />
                                                    <path d="M8 8l4 0" />
                                                    <path d="M8 12l4 0" />
                                                    <path d="M8 16l4 0" />
                                                </svg>
                                                <div class="half_circle"></div>
                                            </div>
                                            <div class="detail_count">
                                                @if($data->stsmtncnc == 1)
                                                <h3>Running</h3>
                                                @elseif($data->stsmtncnc == 2)
                                                <h3>Maintenance</h3>
                                                @elseif($data->stsmtncnc == 3)
                                                <h3>Backup</h3>
                                                @elseif($data->stsmtncnc == 4)
                                                <h3>Error</h3>
                                                @endif
                                                <span>Status</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/contentds/maintenance/status/edit" target="_blank" class="tombol grey openviewport">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                                                    </g>
                                                </svg>
                                                <span class="texttombol">edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
    <script>
        // Menutup jendela setelah 2 detik
        setTimeout(function() {
            window.close();
        }, 2000);
    </script>
    @elseif(session()->has('error'))
        <script>
            Swal.fire({
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
        <script>
            // Menutup jendela setelah 2 detik
            setTimeout(function() {
                window.close();
            }, 2000);
        </script>
    @endif

    <script>
        //open jendela edit agent
        $(document).ready(function() {
            $(".openviewport").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 700;
                var windowHeight = $(window).height() * 0.6;
                var windowLeft = ($(window).width() - windowWidth) / 1.3;
                var windowTop = ($(window).height() - windowHeight) / 1.5;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" + windowLeft + ", top=" + windowTop);
            });
        });

        //open jendela info agent
        $(document).ready(function() {
            $(".openviewportinfo").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 300;
                var windowHeight = $(window).height() * 0.20;
                var windowLeft = ($(window).width() - windowWidth) / 1.6;
                var windowTop = ($(window).height() - windowHeight) / 1.8;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" + windowLeft + ", top=" + windowTop);
            });
        });

        // print text status
        $(document).ready(function(){
            $('.statuspromo').each(function(){
                var statusValue = $(this).attr('data-status');
                switch(statusValue) {
                    case '1':
                        $(this).text('Active');
                        break;
                    case '2':
                        $(this).text('in-active');
                        break;
                    default:
                        break;
                }
            });
        });
    </script>
@endsection
