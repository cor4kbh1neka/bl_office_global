@extends('layouts.index')

@section('container')
    <style>
        .red-text {
            color: var(--red-color);
    }
    </style>
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
                    <a href="/reportds/winlosematch" class="tombol grey">
                        <span class="texttombol">WIN LOSE MATCH</span>
                    </a>
                    <a href="/reportds/towl" class="tombol grey active">
                        <span class="texttombol">TURN OVER & WIN LOSE</span>
                    </a>
                    {{-- <a href="/reportds/memberstatement" class="tombol grey">
                        <span class="texttombol">STATEMENT</span>
                    </a> --}}
                </div>
                <div class="groupdatareportds">
                    <div class="grouphistoryds memberlist">
                        <div class="groupheadhistoryds">
                            <form method="GET" action="/reportds/towl" class="listmembergroup">
                                <div class="listinputmember">
                                    <label for="username">username</label>
                                    <input type="input" id="username" name="username"
                                        placeholder="username" value="{{ $username }}">
                                </div>
                                <div class="listinputmember">
                                    <label for="portfolio">Portfolio</label>
                                    <select name="portfolio" id="portfolio">
                                        <option value="">Pilih semua</option>
                                        <option value="Sportsbook" {{ $portfolio == 'Sportsbook' ? 'selected' : '' }}>Sportsbook
                                        </option>
                                        <option value="VirtualSports" {{ $portfolio == 'VirtualSports' ? 'selected' : '' }}>VirtualSports
                                        </option>
                                        <option value="Games" {{ $portfolio == 'Games' ? 'selected' : '' }}>Games
                                        </option>
                                        <option value="SeamlessGame" {{ $portfolio == 'SeamlessGame' ? 'selected' : '' }}>SeamlessGame
                                        </option>
                                    </select>
                                </div>
                                <div class="listinputmember">
                                    <label for="gabungdari">tanggal dari <span class="required">*</span></label>
                                    <input type="date" id="gabungdari" name="gabungdari"
                                        placeholder="tanggal gabung dari" value="{{ $gabungdari }}" required>
                                </div>
                                <div class="listinputmember">
                                    <label for="gabunghingga">tanggal hingga <span class="required">*</span></label>
                                    <input type="date" id="gabunghingga" name="gabunghingga"
                                        placeholder="tanggal gabung hingga" value="{{ $gabunghingga }}" required>
                                </div>
                            
                                <div class="listinputmember">
                                    <button class="tombol primary">
                                        <span class="texttombol">SUBMIT</span>
                                    </button>
                                </div>
                                <div class="grouprightbtn">
                                    {{-- <div class="listinputmember">
                                        <button type="button" id="prosesbonus" class="tombol primary"
                                            {{ $isproses == true ? '' : 'disabled' }}>
                                            <span class="texttombol">PROSES BONUS</span>
                                        </button>
                                    </div> --}}
                                    {{-- <div class="exportdata">
                                        <span class="textdownload">download</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                        </svg>
                                    </div> --}}
                                </div>
                            </form>
                        </div>
                        <div class="totalbonus">
                            <div class="listtotalbonus">
                                <span class="textbonus">Portfolio :</span>
                                <span class="countbonus">{{ ucfirst($portfolio) == '' ? 'All' : ucfirst($portfolio) }}</span>
                            </div>
                            <div class="listtotalbonus">
                                <span class="textbonus">tanggal :</span>
                                <div class="grouptgllistbonus">
                                    <span class="countbonus from">{{ $gabungdari }}</span>
                                    <span>s/d</span>
                                    <span class="countbonus to">{{ $gabunghingga }}</span>
                                </div>
                            </div>
                            <div class="listtotalbonus">
                                <span class="textbonus">Member Online :</span>
                                <span class="countbonus">{{ $totaluser }}</span>
                            </div>
                            <div class="listtotalbonus">
                                <span class="textbonus">Total TO :</span>
                                <span class="nominalbonus" data-bonus="{{ $total_to }}"></span>
                            </div>
                            <div class="listtotalbonus">
                                <span class="textbonus">Total W/L :</span>
                                <span class="nominalbonus2 {{ $total_wl < 0 ? 'red-text' : '' }}" data-bonus="{{ $total_wl }}"></span>
                            </div>
                        </div>
                        <div class="tabelproses">
                            <table>
                                <tbody>
                                    <tr class="hdtable">
                                        <th class="bagnot" rowspan="2">#</th>
                                        {{-- <th class="check_box boxme" rowspan="2">
                                            <input type="checkbox" id="myCheckbox" name="myCheckbox">
                                        </th> --}}
                                        <th class="bagusercc">username</th>
                                        <th class="bagturnover" rowspan="2">turnover</th>
                                        <th class="bagwinlose" rowspan="2">win/lose</th>
                                        {{-- <th class="bagnominalbonus" rowspan="2">nominal bonus (IDR)</th> --}}
                                    </tr>
                                    <tr class="hdtable search">
                                        <th class="tdsearch">
                                            <div class="grubsearchtable">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24"
                                                    stroke-width="1.5" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                    <path d="M21 21l-6 -6"></path>
                                                </svg>
                                                <input type="text" placeholder="Cari data..." id="searchData-username"
                                                    class="searchData-username">
                                            </div>
                                        </th>
                                    </tr>
                                    @foreach ($data as $i => $d)
                                        <tr>
                                            <td>1</td>
                                            {{-- <td class="check_box">
                                                <input type="checkbox" id="myCheckbox-{{ $i }}"
                                                    name="myCheckbox-{{ $i }}"
                                                    data-username="{{ $d->username }}"
                                                    data-bonus = "{{ $d->totalbonus }}"
                                                    data-stake= "{{ $d->totalstake }}"
                                                    data-winloss= "{{ $d->totalwinloss }}">
                                            </td> --}}
                                            <td class="username">{{ $d->username }}</td>
                                            <td class="datacc" data-get="{{ $d->totalstake }}"></td>
                                            <td class="datacc" data-get="{{ $d->totalwinloss }}"></td>
                                            {{-- <td class="datacc" data-get="{{ $d->totalbonus }}"></td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

        // print total bonus
        $(document).ready(function() {
            var value = parseFloat($('.nominalbonus').attr('data-bonus'));
            var formattedValue = formatCurrency(value);
            $('.nominalbonus').text(formattedValue);
        });

        $(document).ready(function() {
            var value = parseFloat($('.nominalbonus2').attr('data-bonus'));
            var formattedValue = formatCurrency(value);
            $('.nominalbonus2').text(formattedValue);
        });


        function formatCurrency(amount) {
            var parts = amount.toFixed(2).split('.');
            // If the decimal part is '00', we don't include it
            if (parts[1] === '00') {
                parts.pop();
            }
            return parts.join('.').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        $(document).ready(function() {
            $('#searchData-username').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('tr.hdtable.search').nextAll('tr').each(function() {
                    var username = $(this).find('.username').text().toLowerCase();
                    if (username.includes(value)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#prosesbonus').click(function() {
                var isChecked = $('#myCheckbox:checked, [id^="myCheckbox-"]:checked').length > 0;

                if (!isChecked) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Mohon cek kembali data yang ingin Anda proses!',
                    });
                    return;
                }

                Swal.fire({
                    icon: 'question',
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin memproses data ini?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then(function(result) {
                    if (result.isConfirmed) {
                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        var data = [];

                        var bonusVal = $('#bonus').val();
                        var gabungdariVal = $('#gabungdari').val();
                        var gabunghinggaVal = $('#gabunghingga').val();
                        var kecualiVal = $('#kecuali').val();

                        $('input[type="checkbox"]:checked').not('#myCheckbox').each(function() {
                            var username = $(this).data('username');
                            var bonus = $(this).data('bonus');
                            var stake = $(this).data('stake');
                            var winloss = $(this).data('winloss');

                            if (username !== '') {
                                data.push({
                                    username: username,
                                    bonus: bonus,
                                    stake: stake,
                                    winloss: winloss
                                });
                            }
                        });

                        if (data.length === 0) {
                            Swal.fire({
                                icon: 'warning',
                                text: 'Tidak ada data yang valid untuk diproses!',
                            });
                            return;
                        }

                        Swal.fire({
                            icon: 'info',
                            title: 'Mohon tunggu...',
                            text: 'Proses sedang berlangsung, mohon untuk tidak diclose!',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        var url = '/storebonusds/' + encodeURIComponent(bonusVal) + '/' +
                            encodeURIComponent(gabungdariVal) + '/' + encodeURIComponent(
                                gabunghinggaVal) + '/' + encodeURIComponent(kecualiVal);;

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: JSON.stringify(data),
                            contentType: 'application/json',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: 'Proses data bonus berhasil!',
                                    timer: 2000,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Oke',
                                    didClose: () => {
                                        // window.location.href =
                                        //     '/bonuslistds';
                                    }
                                });
                            },
                            error: function(error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal diproses!',
                                    text: 'Kesalahan: ' + error.statusText,
                                });
                            },
                            complete: function() {
                                Swal.hideLoading();
                            }
                        });
                    }
                });
            });
        });

        // $('.exportdata').click(function() {
        //     Swal.fire({
        //         icon: 'question',
        //         title: 'Konfirmasi',
        //         text: 'Apakah ingin mendownload data ini?',
        //         showCancelButton: true,
        //         confirmButtonText: 'Ya',
        //         cancelButtonText: 'Batal',
        //     }).then(function(result) {
        //         if (result.isConfirmed) {
        //             var bonus = $('#bonus').val();
        //             var gabungdari = $('#gabungdari').val();
        //             var gabunghingga = $('#gabunghingga').val();
        //             var kecuali = $('#kecuali').val();

        //             var url = '/reportds/towl/export?bonus=' + encodeURIComponent(bonus) +
        //                 '&gabungdari=' + encodeURIComponent(gabungdari) +
        //                 '&gabunghingga=' + encodeURIComponent(gabunghingga) +
        //                 '&kecuali=' + encodeURIComponent(kecuali);

        //             // Redirect ke URL
        //             window.location.href = url;
        //         }
        //     });
        // });
    </script>
@endsection
