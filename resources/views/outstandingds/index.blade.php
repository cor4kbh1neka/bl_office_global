@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>
            <span class="countpendingdata outstanding">{{ $countOuts }}</span>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>
        <div class="secoutstandingds">
            <div class="groupoutstandingds">
                <div class="groupheadoutstandingds">
                    <form method="GET" action="/outstandingds" class="listinputmember">
                        <label for="username">username</label>
                        <input type="text" name="username" id="username" placeholder="username"
                            value="{{ $username }}">
                    </form>
                    <div class="exportdata">
                        <span class="textdownload">download</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                        </svg>
                    </div>
                </div>
                <div class="groupdataoutstanding">
                    <div class="tabelproses">
                        <table>
                            <tbody>
                                <tr class="hdtable">
                                    <th class="bagno">#</th>
                                    <th class="baguser">Username</th>
                                    <th class="bagnominal">Total Nominal (IDR)</th>
                                    <th class="bagcountoutstand">Total Invoice</th>
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
                                        <td>{{ $d['totalAmount'] }}</td>
                                        <td>
                                            <a
                                                href="/outstandingds/{{ $d['username'] }}{{ $username == '' ? '' : '?username=' . $username }}">
                                                <div class="groupcountout">
                                                    <span class="countdataout">{{ $d['count'] }}</span>
                                                    <spaCn class="selengkapnyaout">
                                                        (Lihat
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                            height="1em" viewBox="0 0 1024 1024">
                                                            <path fill="currentColor"
                                                                d="M754.752 480H160a32 32 0 1 0 0 64h594.752L521.344 777.344a32 32 0 0 0 45.312 45.312l288-288a32 32 0 0 0 0-45.312l-288-288a32 32 0 1 0-45.312 45.312z" />
                                                        </svg>)
                                                        </span>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $data->links('vendor.pagination.customdashboard2') }}
                    </div>
                    <div class="tabelproses">
                        <table>
                            <tbody>
                                <tr class="hdtable">
                                    <th class="bagno">#</th>
                                    <th class="baguser">Username</th>
                                    <th class="bagtanggal">tanggal</th>
                                    <th class="bagnomorinvoice">nomor invoice</th>
                                    <th class="bagdetail">detail</th>
                                    {{-- <th class="bagodds">odds betingan</th> --}}
                                    <th class="bagnominal">nominal (IDR)</th>
                                    <th class="bagstatusbet">status betingan</th>
                                </tr>
                                @php
                                    $currentPage = $data->currentPage();
                                    $perPage = $data->perPage();
                                    $startNumber = ($currentPage - 1) * $perPage + 1;
                                @endphp
                                @foreach ($dataouts as $i => $d)
                                    <tr>
                                        <td>{{ $startNumber + $i }}</td>
                                        <td>{{ $d->username }}</td>
                                        <td>{{ date('Y-m-d H:i:s', strtotime($d->created_at)) }}</td>
                                        <td class="data refNo">{{ $d->transactionid }}</td>
                                        <td>
                                            <a href="/historygameds/detail/{{ $d->transactionid }}/{{ $d->portfolio }}"
                                                target="_blank" class="detailbetingan">
                                                <span class="texttypebet sportsType">{{ $d->gametype }}</span>
                                                <span class="klikdetail">(selengkapnya)</span>
                                            </a>
                                        </td>
                                        {{-- <td class="valuenominal odds" data-odds="0.980"></td> --}}
                                        <td class="valuenominal stake" data-stake="{{ $d->amount }}"></td>
                                        <td class="textstatusbet" data-status="{{ $d->status }}">{{ $d->status }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="grouppaginationcc">
                            {{ $dataouts->links('vendor.pagination.customdashboard') }}
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

        $('.exportdata').click(function() {
            Swal.fire({
                icon: 'question',
                title: 'Konfirmasi',
                text: 'Apakah ingin mendownload data ini?',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
            }).then(function(result) {
                if (result.isConfirmed) {
                    var username = $('#username').val();
                    var url = '/outstandingdsexport?' +
                        '&username=' + encodeURIComponent(username);
                    window.location.href = url;
                }
            });
        });
    </script>
@endsection
