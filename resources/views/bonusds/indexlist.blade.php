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
        <div class="secagentds">
            <div class="groupsecagentds">
                <div class="headgroupsecagentds">
                    <div class="listheadsecagentds bottom">
                        <a href="/bonusds" class="tombol proses">
                            <span class="texttombol">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                    <defs>
                                        <mask id="ipSAdd0">
                                            <g fill="none" stroke-linejoin="round" stroke-width="4">
                                                <rect width="36" height="36" x="6" y="6" fill="#fff"
                                                    stroke="#fff" rx="3" />
                                                <path stroke="#000" stroke-linecap="round" d="M24 16v16m-8-8h16" />
                                            </g>
                                        </mask>
                                    </defs>
                                    <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSAdd0)" />
                                </svg>
                                ADD BONUS
                            </span>
                        </a>
                        <form action="/bonuslistds" method="GET" class="groupsearchagentds">
                            <div class="listinputmember">
                                <select name="bonus" id="bonus">
                                    <option value="" selected="" place="">All Bonus</option>
                                    <option value="cashback" {{ $bonus == 'cashback' ? 'selected' : '' }}>Cashback
                                    </option>
                                    <option value="rolingan" {{ $bonus == 'rolingan' ? 'selected' : '' }}>Rollingan
                                    </option>
                                </select>
                            </div>
                            <div class="listinputmember">
                                <input type="date" id="gabungdari" name="gabungdari" placeholder="tanggal gabung dari"
                                    value="{{ $gabungdari }}">
                            </div>
                            <div class="listinputmember">
                                <input type="date" id="gabunghingga" name="gabunghingga"
                                    placeholder="tanggal gabung hingga" value="{{ $gabunghingga }}">
                            </div>

                            <div class="grubsearchnav">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14" />
                                </svg>
                                <input type="text" placeholder="Search No. Invoice..." id="searchTabel"
                                    name="searchinvoice" value="{{ $search }}">
                            </div>
                            <button class="tombol primary">
                                <span class="texttombol">search</span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="groupdatasecagentds">
                    <div class="tabelproses">
                        <table>
                            <tbody>
                                <tr class="hdtable">
                                    <th class="bagno">#</th>
                                    <th class="baglogininfo">no. invoice</th>
                                    <th class="bagiplogin">bonus</th>
                                    <th class="bagiplogin">periode</th>
                                    <th class="baguser">status</th>
                                    <th class="baguser">total</th>
                                    <th class="baguser">log</th>
                                    <th class="baguser">Tools</th>
                                </tr>
                                @foreach ($data as $i => $d)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $d->no_invoice }}</td>
                                        <td>{{ ucwords($d->jenis_bonus) }}</td>
                                        <td>{{ $d->periodedari }} to {{ $d->periodesampai }}</td>
                                        <td>{{ $d->status }}</td>
                                        <td>{{ $d->total }}</td>
                                        <td>{{ $d->processed_by }} ({{ $d->created_at }})</td>
                                        <td>
                                            <div class="grouptools">
                                                <a href="/bonusdetailds/{{ $d->id }}" target="_blank"
                                                    class="tombol grey openviewport">
                                                    <span class="texttombol">VIEW</span>
                                                </a>
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

        //open jendela edit agent
        $(document).ready(function() {
            $(".openviewport").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 700;
                var windowHeight = $(window).height() * 0.6;
                var windowLeft = ($(window).width() - windowWidth) / 1.3;
                var windowTop = ($(window).height() - windowHeight) / 1.5;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" +
                    windowLeft + ", top=" + windowTop);
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

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" +
                    windowLeft + ", top=" + windowTop);
            });
        });

        // print text status
        $(document).ready(function() {
            $('.statusagent').each(function() {
                var statusValue = $(this).attr('data-status');
                switch (statusValue) {
                    case '1':
                        $(this).text('Active');
                        break;
                    case '2':
                        $(this).text('Non-active');
                        break;
                    case '3':
                        $(this).text('Suspend');
                        break;
                    default:
                        break;
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
@endsection
