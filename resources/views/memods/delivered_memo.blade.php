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
                    <a href="/memods" class="tombol grey">
                        <span class="texttombol">create</span>
                    </a>
                    <a href="/memods/delivered" class="tombol grey active">
                        <span class="texttombol">delivered</span>
                    </a>
                    {{-- <a href="/memods/viewinbox" class="tombol grey">
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
                    </a> --}}
                </div>
                <div class="groupdatamemo inbox">
                    <div class="headfilter">
                        <form id="searchForm" action="/memods/delivered" method="GET">
                            <div class="groupinputfilter">
                                <div class="listinputmember">
                                    <label for="statuspriority">penerima</label>
                                    <select name="statuspriority" id="statuspriority">
                                        <option value="" {{ request('statuspriority') === null || request('statuspriority') === '' ? 'selected' : '' }}>
                                            Lihat Semua
                                        </option>
                                        <option value="1" {{ request('statuspriority') == 1 ? 'selected' : '' }}>All Player</option>
                                        <option value="2" {{ request('statuspriority') == 2 ? 'selected' : '' }}>VIP Only</option>
                                    </select>
                                </div>
                                <div class="listinputmember">
                                    <label for="idmemo">ID delivered</label>
                                    <input type="text" id="idmemo" name="idmemo" placeholder="Cari ID Memo" value="{{ request('idmemo') }}">
                                </div>
                                <div class="listinputmember">
                                    <button class="tombol primary">
                                        <span class="texttombol">SUBMIT</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="exportdata">
                            <span class="textdownload">download</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                            </svg>
                        </div>
                    </div>
                    <div class="groupplayerinfo">
                        <div class="tabelproses">
                            <table>
                                <tbody>
                                    <tr class="hdtable">
                                        <th class="bagno">#</th>
                                        <th class="bagidms">ID delivered</th>
                                        <th class="baguser">penerima</th>
                                        <th class="bagsubject">subject</th>
                                        <th class="bagtanggalinbox">tanggal message</th>
                                        <th class="bagpengirim">pengirim</th>
                                        <th class="bagaction">actions</th>
                                    </tr>
                                    @php
                                        $currentPage = $data->currentPage();
                                        $perPage = $data->perPage();
                                        $startNumber = ($currentPage - 1) * $perPage + 1;
                                    @endphp
                                    @foreach ($data as $index => $d)
                                    {{-- @dd($d) --}}
                                        <tr>
                                            <td>{{ $startNumber + $index }}</td>
                                            <td>DV{{ sprintf('%06d', $d['idmemo']) }}</td>
                                            <td>{{ $d['statuspriority'] == 1 ? 'All Member' : 'Only VIP' }}</td>
                                            <td>{{ $d['subject'] }}</td>
                                            <td class="ganti">{{ $d['created_at'] == null ? date('Y-m-d') : $d['created_at'] }}</td>
                                            <td>ADMIN</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/memods/readdelivered/{{ $d['idmemo'] }}" target="_blank"
                                                            class="openviewport">
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                                    height="1em" viewBox="0 0 32 32">
                                                                    <circle cx="16" cy="16" r="4"
                                                                        fill="currentColor" />
                                                                    <path fill="currentColor"
                                                                        d="M30.94 15.66A16.69 16.69 0 0 0 16 5A16.69 16.69 0 0 0 1.06 15.66a1 1 0 0 0 0 .68A16.69 16.69 0 0 0 16 27a16.69 16.69 0 0 0 14.94-10.66a1 1 0 0 0 0-.68M16 22.5a6.5 6.5 0 1 1 6.5-6.5a6.51 6.51 0 0 1-6.5 6.5" />
                                                                </svg>
                                                                <span>Lihat</span>
                                                            </div>
                                                        </a>
                                                        {{-- <a href="#">
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                                    height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor"
                                                                        d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                </svg>
                                                                <span>Delete</span>
                                                            </div>
                                                        </a> --}}
                                                        <form id="deleteForm" action="/deletememods/{{ $d['idmemo'] }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" style="border:none;background:#fff"
                                                                onclick="confirmDelete('{{ $d['idmemo'] }}')">
                                                                <div class="list_action">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                                        height="1em" viewBox="0 0 24 24">
                                                                        <path fill="currentColor"
                                                                            d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                    </svg>
                                                                    <span>Delete</span>
                                                                </div>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="padding-left:25px;padding-right:25px">
                                {{ $data->links('vendor.pagination.customdashboard') }}
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

        // status read atau unread
        $(document).ready(function() {
            $(".dataxstatus").each(function() {
                var status = $(this).attr("data-status");
                var xstatusElement = $(this).find(".xstatus");

                if (status === "0") {
                    xstatusElement.text("unread");
                } else if (status === "1") {
                    xstatusElement.text("read");
                }
            });
        });

        //open jendela detail
        $(document).ready(function() {
            $(".openviewport").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 700;
                var windowHeight = $(window).height() * 0.65;
                var windowLeft = ($(window).width() - windowWidth) / 1;
                var windowTop = ($(window).height() - windowHeight) / 0.95;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" +
                    windowLeft + ", top=" + windowTop);
            });
        });

        function confirmDelete(id) {
            event.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').action = '/deletememods/' + id;
                    document.getElementById('deleteForm').submit();
                }
            });
        }
        document.getElementById('searchForm').addEventListener('submit', function(event) {
        const inputs = [
            'statuspriority',
            'idmemo',
        ];
            inputs.forEach(id => {
                const inputElement = document.getElementById(id);
                if (!inputElement.value) {
                    inputElement.disabled = true; // Untuk disabled input kalau tidak ada filter :D
                }
            });
        });
        function formatDate(dateString) {
            const date = new Date(dateString);
            const year = date.getFullYear();
            const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
            const day = date.getDate().toString().padStart(2, '0');
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            const seconds = date.getSeconds().toString().padStart(2, '0');
            
            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }
        const tdElements = document.querySelectorAll('.ganti');
        tdElements.forEach(tdElement => {
            const originalDate = tdElement.textContent;
            const formattedDate = formatDate(originalDate);
            tdElement.textContent = formattedDate;
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
