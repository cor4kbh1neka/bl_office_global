@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }} </h2>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>
        <div class="sechistorygame">
            <div class="groupsechistorygame">
                <form method="GET" action="/historygameds" id="form-historygameds" class="groupheadhistorygame">
                    <div class="headhistorygame one">
                        <div class="listinputmember">
                            <label for="username">username <span class="required">*</span></label>
                            <input type="text" name="username" id="username" placeholder="username (wajib di isi)"
                                value="{{ request('username') }}" required>
                        </div>
                        <div class="listinputmember">
                            <label for="portfolio">jenis game <span class="required">*</span></label>
                            <select name="portfolio" id="portfolio" required>
                                <option value="" style="color: #838383; font-style: italic;" disabled="" selected>
                                    pilih
                                    jenis</option>
                                <option value="SportsBook" {{ request('portfolio') == 'SportsBook' ? 'selected' : '' }}>SportsBook
                                </option>
                                <option value="VirtualSports" {{ request('portfolio') == 'VirtualSports' ? 'selected' : '' }}>
                                    VirtualSports
                                </option>
                                <option value="Games" {{ request('portfolio') == 'Games' ? 'selected' : '' }}>Games</option>
                                <option value="SeamlessGame" {{ request('portfolio') == 'SeamlessGame' ? 'selected' : '' }}>
                                    SeamlessGame</option>

                            </select>
                        </div>
                        <div class="listinputmember">
                            <label for="startDate">dari <span class="required">*</span></label>
                            <input type="date" name="startDate" id="startDate" value="{{ request('startDate') }}" required>
                        </div>
                        <div class="listinputmember">
                            <label for="endDate">hingga <span class="required">*</span></label>
                            <input type="date" name="endDate" id="endDate" value="{{ request('endDate') }}" required>
                        </div>
                    </div>
                    <div class="headhistorygame two">
                        <div class="listinputmember">
                            <label for="refNo">invoice bet</label>
                            <input type="text" name="refNo" id="refNo" value="{{ request('refNo') }}"
                                placeholder="nomor invoice">
                        </div>
                        <div class="listinputmember">
                            <label for="sportsType">type bet</label>
                            <select name="sportsType" id="sportsType">
                                <option value="">show all</option>
                                @foreach ($data_filter_sportsTypes as $dt_filter)
                                    <option value="{{ $dt_filter }}" {{ $sportsType == $dt_filter ? 'selected' : '' }}>
                                        {{ $dt_filter }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="listinputmember">
                            <label for="status">pilih status</label>
                            <select name="status" id="status">
                                <option value="">show all</option>
                                {{-- <option value="running">running</option> --}}
                                <option value="won">won</option>
                                <option value="lose">lose</option>
                                <option value="draw">draw</option>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                        </svg>
                    </div>
                </form>
                <div class="tabelproses">
                    <table>
                        <tbody>
                            <tr class="hdtable">
                                <th class="bagno">#</th>
                                <th class="baguser">Username</th>
                                <th class="bagtanggal">tanggal</th>
                                <th class="bagnomorinvoice">nomor invoice</th>
                                <th class="bagdetail">detail</th>
                                <th class="bagodds">odds betingan</th>
                                <th class="bagnominal">nominal bet (IDR)</th>
                                <th class="bagnominal">win/lose (IDR)</th>
                                <th class="bagstatusbet">status betingan</th>
                            </tr>
                            @php
                                $currentPage = $data->currentPage();
                                $perPage = $data->perPage();
                                $startNumber = ($currentPage - 1) * $perPage + 1;
                            @endphp
                            @foreach ($data as $i => $d)
                                <tr>
                                    <td>{{ $startNumber + $i }}</td>
                                    <td>{{ $d['username'] }}</td>
                                    <td>{{ date('d-m-Y H:i:s', strtotime($d['orderTime'])) }}</td>
                                    <td class="data refNo">{{ $d['refNo'] }}</td>
                                    <td>
                                        @if ($portfolio != 'Games')
                                            <a href="/historygameds/detail/{{ $d['refNo'] }}/{{ $portfolio }}"
                                                target="_blank" class="detailbetingan">
                                                <span
                                                    class="texttypebet sportsType">{{ $portfolio == 'SportsBook' ? $d['sportsType'] : $d['productType'] }}</span>
                                                <span class="klikdetail">(selengkapnya)</span>
                                            </a>
                                        @else
                                            <span
                                                class="texttypebet sportsType">{{ $portfolio == 'SportsBook' ? $d['sportsType'] : $d['productType'] }}</span>
                                        @endif
                                    </td>
                                    <td class="valuenominal odds"
                                        data-odds="{{ $portfolio !== 'Games' ? $d['odds'] : 0.1 }}"></td>
                                    <td class="valuenominal stake" data-stake="{{ $d['stake'] }}"></td>
                                    <td class="valuenominal winLost" data-winLost="{{ $d['winLost'] }}"
                                        data-status="{{ $d['status'] }}"></td>
                                    <td class="textstatusbet" data-status="{{ $d['status'] }}">{{ $d['status'] }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="grouppagination" style="padding: 25px;">
                        {{ $data->links('vendor.pagination.customdashboard') }}
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

        // convert nominal
        $(document).ready(function() {
            $('.koinasli').each(function() {
                var nilaiAsli = parseFloat($(this).text());
                var nilaiKonversi = nilaiAsli * 1000;
                var nilaiFormat = formatRupiah(nilaiKonversi);
                $(this).next('.cointorp').text(nilaiFormat);
            });

            function formatRupiah(nilai) {
                var bilangan = nilai.toString().replace(/[^,\d]/g, '');
                var bilanganSplit = bilangan.split(',');
                var sisa = bilanganSplit[0].length % 3;
                var rupiah = bilanganSplit[0].substr(0, sisa);
                var ribuan = bilanganSplit[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    var separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = bilanganSplit[1] !== undefined ? rupiah + ',' + bilanganSplit[1] : rupiah;
                return 'Rp' + rupiah;
            }
        });

        $(document).ready(function() {
            $('.hsjenisakun').each(function() {
                var status = $(this).data('statusakun');
                var text = '';

                switch (status) {
                    case 1:
                        text = 'default';
                        break;
                    case 2:
                        text = 'vvip';
                        break;
                    case 3:
                        text = 'bandar';
                        break;
                    case 4:
                        text = 'warning';
                        break;
                    case 5:
                        text = 'suspend';
                        break;
                    case 9:
                        text = 'new member';
                        break;
                    default:
                        text = 'unknown';
                        break;
                }

                $(this).text(text);
            });
        });

        //format nominal odds dan stake
        $(document).ready(function() {
            $('tr').each(function() {

                var odds = $(this).find('.valuenominal.odds').attr('data-odds');
                odds = (parseFloat(odds) * 10).toFixed(2);
                $(this).find('.valuenominal.odds').text(odds);

                var stake = $(this).find('.valuenominal.stake').attr('data-stake');
                stake = parseFloat(stake).toFixed(2);
                $(this).find('.valuenominal.stake').text(stake);

                var winLost = $(this).find('.valuenominal.winLost').attr('data-winLost');
                winLost = parseFloat(winLost).toFixed(2);

                if (winLost === "0.00") {
                    $(this).find('.valuenominal.winLost').text("-");
                } else {
                    $(this).find('.valuenominal.winLost').text(winLost);
                }
            });
        });

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
            var Message = "{{ $Message }}";

            if (Message != '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: Message
                });
            }
        });


        // $(document).ready(function() {
        //     $('#refNo').on('input', function() {
        //         var inputRefNo = $(this).val();
        //         if (inputRefNo.trim() !== '') {
        //             $('#username').val('');
        //             $('#portfolio').val('');

        //             $('#startDate').val('');
        //             $('#endDate').val('');

        //             $('#portfolio').addClass('borderPulse');
        //             $('#username').removeAttr('required');
        //             $('#startDate').removeAttr('required');
        //             $('#endDate').removeAttr('required');
        //         }
        //     });

        //     $('#username').on('input', function() {
        //         var inputUsername = $(this).val();
        //         if (inputUsername.trim() !== '') {
        //             $('#refNo').val('');
        //             $('#portfolio').val('');

        //             $(this).removeClass('borderPulse');
        //             $('#username').attr('required', 'required');
        //             $('#startDate').attr('required', 'required');
        //             $('#endDate').attr('required', 'required');
        //         }
        //     });

        //     if ($('#refNo').val() != '') {
        //         $('#username').removeAttr('required');
        //         $('#startDate').removeAttr('required');
        //         $('#endDate').removeAttr('required');
        //     }

        //     $('#portfolio').change(function() {
        //         $(this).removeClass('borderPulse');
        //     });
        // });

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
        document.getElementById('form-historygameds').addEventListener('submit', function(event) {
        const inputs = [
            'username',
            'portfolio',
            'startDate',
            'endDate',
            'refNo',
            'sportsType',
            'status',
        ];
            inputs.forEach(id => {
                const inputElement = document.getElementById(id);
                if (!inputElement.value) {
                    inputElement.disabled = true; // Untuk disabled input kalau tidak ada filter :D
                }
            });
        });
    </script>
@endsection
