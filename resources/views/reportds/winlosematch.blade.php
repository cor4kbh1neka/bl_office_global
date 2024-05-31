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
        <div class="secreportds">
            <div class="groupsecreportds">
                <div class="headsecreportds">
                    <a href="/reportds" class="tombol grey">
                        <span class="texttombol">WIN LOSE MEMBER</span>
                    </a>
                    <a href="/reportds/winlosematch" class="tombol grey active">
                        <span class="texttombol">WIN LOSE MATCH</span>
                    </a>
                    {{-- <a href="/reportds/memberstatement" class="tombol grey">
                        <span class="texttombol">STATEMENT</span>
                    </a> --}}
                </div>
                <div class="groupdatareportds">
                    <div class="grouphistoryds memberlist winlosematch">
                        <div class="groupheadhistoryds">
                            {{-- <div class="listmembergroup">
                                <div class="listinputmember">
                                    <label for="portfolio">jenis game <span class="required">*</span></label>
                                    <select name="portfolio" id="portfolio" required>
                                        <option value="" selected="" style="color: #838383; font-style: italic;" disabled="">pilih jenis</option>
                                        <option value="SportsBook">SportsBook</option>
                                        <option value="VirtualSports">VirtualSports</option>
                                        <option value="Games">Games</option>
                                    </select>
                                </div>
                                <div class="listinputmember">
                                    <label for="sportsType">sports type</label>
                                    <select id="sportsType" name="sportsType">
                                        <option value="all">all type</option>
                                        <option value="Mix Parlay">Mix Parlay</option>
                                        <option value="Football">Football</option>
                                        <option value="Basketball">Basketball</option>
                                    </select>
                                </div>
                                <div class="listinputmember">
                                    <label for="marketType">market type</label>
                                    <select id="marketType" name="marketType">
                                        <option value="all">all market</option>
                                        <option value="Handicap">Handicap</option>
                                        <option value="Over/Under">Over/Under</option>
                                        <option value="1X2">1X2</option>
                                    </select>
                                </div>
                                <div class="listinputmember">
                                    <label for="username">username</label>
                                    <input type="text" id="username" name="username" placeholder="username">
                                </div>
                                <div class="listinputmember">
                                    <label for="refNo">invoice code</label>
                                    <input type="text" name="refNo" id="refNo" placeholder="code invoice">
                                </div>
                                <div class="listinputmember">
                                    <label for="gabungdari">tanggal dari</label>
                                    <input type="date" id="gabungdari" name="gabungdari" placeholder="tanggal gabung dari">
                                </div>
                                <div class="listinputmember">
                                    <label for="gabunghingga">tanggal hingga</label>
                                    <input type="date" id="gabunghingga" name="tanggal gabung hingga" placeholder="nama rekening">
                                </div>
                                <div class="listinputmember">
                                    <button class="tombol primary">
                                        <span class="texttombol">SUBMIT</span>
                                    </button>
                                </div>
                                <div class="exportdata">
                                    <span class="textdownload">download</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                    </svg>
                                </div>
                            </div> --}}

                            <form method="GET" action="/reportds/winlosematch" id="form-historygameds"
                                class="groupheadhistorygame">
                                <div class="headhistorygame one">
                                    <div class="listinputmember">
                                        <label for="username">username <span class="required">*</span></label>
                                        <input type="text" name="username" id="username"
                                            placeholder="username (wajib di isi)" value="{{ $username }}" required>
                                    </div>
                                    <div class="listinputmember">
                                        <label for="portfolio">jenis game <span class="required">*</span></label>
                                        <select name="portfolio" id="portfolio" required>
                                            <option value="" style="color: #838383; font-style: italic;"
                                                disabled="" selected>
                                                pilih
                                                jenis</option>
                                            <option value="SportsBook" {{ $portfolio == 'SportsBook' ? 'selected' : '' }}>
                                                SportsBook
                                            </option>
                                            <option value="VirtualSports"
                                                {{ $portfolio == 'VirtualSports' ? 'selected' : '' }}>
                                                VirtualSports
                                            </option>
                                            <option value="Games" {{ $portfolio == 'Games' ? 'selected' : '' }}>Games
                                            </option>
                                            <option value="SeamlessGame"
                                                {{ $portfolio == 'SeamlessGame' ? 'selected' : '' }}>SeamlessGame
                                            </option>
                                        </select>
                                    </div>
                                    <div class="listinputmember">
                                        <label for="startDate">dari <span class="required">*</span></label>
                                        <input type="date" name="startDate" id="startDate" value="{{ $startDate }}"
                                            required>
                                    </div>
                                    <div class="listinputmember">
                                        <label for="endDate">hingga <span class="required">*</span></label>
                                        <input type="date" name="endDate" id="endDate" value="{{ $endDate }}"
                                            required>
                                    </div>
                                </div>
                                <div class="headhistorygame two">
                                    <div class="listinputmember">
                                        <label for="refNo">invoice bet</label>
                                        <input type="text" name="refNo" id="refNo" value="{{ $refNo }}"
                                            placeholder="nomor invoice">
                                    </div>
                                    <div class="listinputmember">
                                        <label for="sportsType">type bet</label>
                                        <select name="sportsType" id="sportsType">
                                            <option value="">show all</option>
                                            @foreach ($data_filter_sportsTypes as $dt_filter)
                                                <option value="{{ $dt_filter }}"
                                                    {{ $sportsType == $dt_filter ? 'selected' : '' }}>
                                                    {{ $dt_filter }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="listinputmember">
                                        <button class="tombol primary">
                                            <span class="texttombol">SUBMIT</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="exportdata">
                                    <span class="textdownload">download</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                    </svg>
                                </div>
                            </form>

                        </div>
                        <div class="tabelproses">
                            <table>
                                <tbody>
                                    <tr class="hdtable">
                                        <th class="bagno" rowspan="2">#</th>
                                        <th class="bagjenisgame" rowspan="2">Invoice Code</th>
                                        <th class="bagjenisgame" rowspan="2">jenis games</th>
                                        <th class="bagjenisgame" rowspan="2">sports type</th>
                                        <th class="bagevents" rowspan="2">events</th>
                                        <th class="bagamount" rowspan="2">amount</th>
                                        <th class="bagrerral" rowspan="2">referral</th>
                                        <th class="bagmember" colspan="2">member</th>
                                        <th class="bagcompany" colspan="2">company</th>
                                    </tr>
                                    <tr class="hdtable">
                                        <th>commision</th>
                                        <th>W/L</th>
                                        <th>commision</th>
                                        <th>W/L</th>
                                    </tr>
                                    @foreach ($data as $i => $d)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $d['refNo'] }}</td>
                                            <td>{{ $portfolio }}</td>
                                            <td>{{ $portfolio == 'SportsBook' ? $d['sportsType'] : $d['productType'] }}
                                            </td>
                                            <td>
                                                @if ($portfolio != 'Games')
                                                    <a href="/historygameds/detail/{{ $d['refNo'] }}/{{ $portfolio }}"
                                                        target="_blank" class="detailbetingan">
                                                        <span
                                                            class="texttypebet sportsType">{{ $d['subBet'][0]['marketType'] }}</span>
                                                        <span class="klikdetail">(selengkapnya)</span>
                                                    </a>
                                                @else
                                                    <span
                                                        class="texttypebet sportsType">{{ $portfolio == 'SportsBook' ? $d['sportsType'] : $d['productType'] }}</span>
                                                @endif
                                            </td>
                                            <td class="datacc" data-get="{{ $d['saldo'] }}"></td>
                                            <td class="datacc" data-get="0"></td>
                                            <td class="datacc" data-get="0"></td>
                                            <td class="datacc" data-get="{{ $d['winLost'] }}"></td>
                                            <td class="datacc" data-get="0"></td>
                                            <td class="datacc" data-get="{{ $d['winLost'] * -1 }}"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="grouppagination">
                                <div class="grouppaginationcc">
                                    <div class="trigger left">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            viewBox="0 0 24 24">
                                            <g fill="none" fill-rule="evenodd">
                                                <path
                                                    d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                <path fill="currentColor"
                                                    d="M7.94 13.06a1.5 1.5 0 0 1 0-2.12l5.656-5.658a1.5 1.5 0 1 1 2.121 2.122L11.122 12l4.596 4.596a1.5 1.5 0 1 1-2.12 2.122l-5.66-5.658Z" />
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="trigger right">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            viewBox="0 0 24 24">
                                            <g fill="none" fill-rule="evenodd">
                                                <path
                                                    d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                <path fill="currentColor"
                                                    d="M16.06 10.94a1.5 1.5 0 0 1 0 2.12l-5.656 5.658a1.5 1.5 0 1 1-2.121-2.122L12.879 12L8.283 7.404a1.5 1.5 0 0 1 2.12-2.122l5.658 5.657Z" />
                                            </g>
                                        </svg>
                                    </div>
                                    <span class="numberpage active">1</span>
                                    <span class="numberpage">2</span>
                                    <span class="numberpage">3</span>
                                    <span class="numberpage">4</span>
                                    <span class="numberpage">5</span>
                                    <span class="numberpage">...</span>
                                    <span class="numberpage">12</span>
                                </div>
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

        // print nilai td
        $(document).ready(function() {
            $('.datacc').each(function() {
                var value = parseFloat($(this).attr('data-get')).toFixed(2);
                var formattedValue = numberWithCommas(value);
                $(this).text(formattedValue);
            });
        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        //open jendela detail
        $(document).ready(function() {
            $(".detailbetingan").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 400;
                var windowHeight = $(window).height() * 0.8;
                var windowLeft = ($(window).width() - windowWidth) / 2;
                var windowTop = ($(window).height() - windowHeight) / 2;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" +
                    windowLeft + ", top=" + windowTop);
            });
        });

        $(document).ready(function() {
            $('#refNo').on('input', function() {
                var inputRefNo = $(this).val();
                if (inputRefNo.trim() !== '') {
                    $('#username').val('');
                    $('#portfolio').val('');

                    $('#startDate').val('');
                    $('#endDate').val('');

                    $('#portfolio').addClass('borderPulse');
                    $('#username').removeAttr('required');
                    $('#startDate').removeAttr('required');
                    $('#endDate').removeAttr('required');
                }
            });

            $('#username').on('input', function() {
                var inputUsername = $(this).val();
                if (inputUsername.trim() !== '') {
                    $('#refNo').val('');
                    $('#portfolio').val('');

                    $(this).removeClass('borderPulse');
                    $('#username').attr('required', 'required');
                    $('#startDate').attr('required', 'required');
                    $('#endDate').attr('required', 'required');
                }
            });

            if ($('#refNo').val() != '') {
                $('#username').removeAttr('required');
                $('#startDate').removeAttr('required');
                $('#endDate').removeAttr('required');
            }

            $('#portfolio').change(function() {
                $(this).removeClass('borderPulse');
            });
        });

        $(document).ready(function() {
            $('#form-historygameds').submit(function(event) {
                event.preventDefault();
                var today = new Date();
                var refNo = $('#refNo').val();
                var startDate = new Date($('#startDate').val());
                var timeDifferenceStart = Math.abs(today - startDate);
                var daysDifferenceStart = Math.ceil(timeDifferenceStart / (1000 * 60 * 60 *
                    24));
                if (refNo == '') {
                    if (daysDifferenceStart > 60) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: "Rentang tanggal tidak dapat lebih dari 60 hari terhitung dari hari ini"
                        });
                    } else {
                        $(this).unbind('submit').submit();
                    }
                } else {
                    $(this).unbind('submit').submit();
                }

            });
        });

        $(document).ready(function() {
            $('#endDate').change(function() {
                var startDate = new Date($('#startDate').val());
                var endDate = new Date($(this).val());

                if (endDate < startDate) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Tanggal akhir harus lebih besar atau sama dengan tanggal awal',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    $(this).val(''); // Mengosongkan nilai endDate jika tidak valid
                }
            });
        });

        // $(document).ready(function() {
        //     $('#endDate').change(function() {
        //         var startDate = new Date($('#startDate').val());
        //         var endDate = new Date($(this).val());

        //         if (endDate < startDate) {
        //             Swal.fire({
        //                 title: 'Error',
        //                 text: 'Tanggal akhir harus lebih besar dari tanggal awal',
        //                 icon: 'error',
        //                 confirmButtonColor: '#3085d6',
        //                 confirmButtonText: 'OK'
        //             });
        //             $(this).val(''); // Mengosongkan nilai endDate jika tidak valid
        //         }
        //     });
        // });

        $('#startDate').change(function() {
            var today = new Date();
            var refNo = $('#refNo').val();
            var startDate = new Date($('#startDate').val());

            // Menghitung tanggal 60 hari yang lalu
            var maxDate = new Date(today);
            maxDate.setDate(maxDate.getDate() - 60);

            if (refNo == '') {
                if (startDate < maxDate) {
                    // Format tanggal 60 hari yang lalu menjadi string
                    var maxDateString = maxDate.toLocaleDateString('en-GB');

                    Swal.fire({
                        title: 'Error',
                        text: 'Tanggal awal tidak boleh kurang dari ' + maxDateString,
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    $(this).val('');
                }
            }
        });
    </script>
@endsection
