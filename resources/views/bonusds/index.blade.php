@extends('layouts.index')

@section('container')
    <style>
        .select-box {
            position: relative;
        }

        .select-box input {
            width: 57%;
            box-sizing: border-box;
            cursor: pointer;
        }

        .options-container {
            width: 20%;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: rgba(var(--rgba-primary-bg-color));
            border: 1px solid rgba(var(--rgba-primary), 0.2);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
            max-height: 200px;
            overflow-y: auto;
            padding: 10px;
        }

        .option-item {
            padding: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .option-item:hover {
            /* background-color: #f0f0f0; */
        }

        .option-item input {
            margin-right: 8px;
            width: 15px;
            height: 15px;
        }

        .groupheadhistoryds .listmembergroup {
            grid-template-columns: 0.5fr 1fr;
        }

        .groupheadhistoryds.downss {
            display: grid;
            grid-template-columns: 70% 30%;
        }

        .downsgroup {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>
            <div class="kembali" style="margin-right: 40px">
                <a href="/bonuslistds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                        <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"
                            d="M44 40.836c-4.893-5.973-9.238-9.362-13.036-10.168c-3.797-.805-7.412-.927-10.846-.365V41L4 23.545L20.118 7v10.167c6.349.05 11.746 2.328 16.192 6.833c4.445 4.505 7.009 10.117 7.69 16.836Z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="textkembali">Kembali</span>
                </a>
            </div>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>
        <div class="secreportds">
            <form method="GET" action="/bonusds" class="groupsecreportds">
                <div class="groupdatareportds">
                    <div class="grouphistoryds memberlist">
                        <div class="groupheadhistoryds">
                            <div class="listmembergroup">
                                <div class="listinputmember">
                                    <label for="bonus">Bonus</label>
                                    <select name="bonus" id="bonus" required>
                                        <option value="" selected="" place=""
                                            style="color: #838383; font-style: italic;" disabled="">Pilih Bonus</option>
                                        <option value="cashback" {{ $bonus == 'cashback' ? 'selected' : '' }}>Cashback
                                        </option>
                                        <option value="rollingan" {{ $bonus == 'rollingan' ? 'selected' : '' }}>Rollingan
                                        </option>
                                    </select>
                                    <input type="hidden" id="detail_bonus" name="detail_bonus" placeholder="pilih game"
                                        value="{{ $detail_bonus }}" readonly>
                                </div>
                                <div class="listinputmember">
                                    <label for="select-input">Select Bonus</label>
                                    <div class="select-box">
                                        <input type="text" id="select-input" placeholder="pilih game"
                                            value="{{ $detail_bonus }}" readonly>
                                        <div class="options-container">
                                            @if (!empty($detail_bonus_array))
                                                @foreach ($detail_bonus_array as $index => $item)
                                                    <div class="option-item">
                                                        <input type="checkbox" id="option{{ $index }}"
                                                            value="{{ $item['productsname'] }}"
                                                            {{ $item['ischeck'] == true ? 'checked' : '' }}>
                                                        <label
                                                            for="option{{ $index }}">{{ $item['productsname'] }}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <!-- Tambahkan lebih banyak opsi jika diperlukan -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="groupheadhistoryds downss">
                            <div class="downsgroup">
                                <div class="listinputmember">
                                    <label for="gabungdari">tanggal dari</label>
                                    <input type="date" id="gabungdari" name="gabungdari"
                                        placeholder="tanggal gabung dari" value="{{ $gabungdari }}" required>
                                </div>
                                <div class="listinputmember">
                                    <label for="gabunghingga">tanggal hingga</label>
                                    <input type="date" id="gabunghingga" name="gabunghingga"
                                        placeholder="tanggal gabung hingga" value="{{ $gabunghingga }}" required>
                                </div>
                                <div class="listinputmember">
                                    <label for="kecuali">Pengecualian</label>
                                    <select name="kecuali" id="kecuali" required>
                                        <option value="" selected="" place=""
                                            style="color: #838383; font-style: italic;" disabled="">Pilih pengecualian
                                        </option>
                                        @foreach ($dataBonusPengecualian as $d)
                                            <option value="{{ $d->nama }}"
                                                {{ $d->nama == $pengecualian ? 'selected' : '' }}>{{ $d->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="listinputmember">
                                    <button class="tombol primary">
                                        <span class="texttombol">SUBMIT</span>
                                    </button>
                                </div>
                                <div class="grouprightbtn">
                                    <div class="listinputmember">
                                        <button type="button" id="prosesbonus" class="tombol primary"
                                            {{ $isproses == true ? '' : 'disabled' }}>
                                            <span class="texttombol">PROSES BONUS</span>
                                        </button>
                                    </div>
                                    <div class="exportdata">
                                        <span class="textdownload">download</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="totalbonus">
                            <div class="listtotalbonus">
                                <span class="textbonus">Bonus :</span>
                                <span class="countbonus">{{ ucfirst($bonus) }}</span>
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
                                <span class="textbonus">Pengecualian :</span>
                                <span class="countbonus">{{ $pengecualian }}</span>
                            </div>
                            <div class="listtotalbonus">
                                <span class="textbonus">Jumlah User :</span>
                                <span class="countbonus">{{ $totaluser }}</span>
                            </div>
                            <div class="listtotalbonus">
                                <span class="textbonus">total bonus :</span>
                                <span class="nominalbonus" data-bonus="{{ $nominalbonus }}"></span>
                            </div>
                        </div>
                        <div class="tabelproses">
                            <table>
                                <tbody>
                                    <tr class="hdtable">
                                        <th class="bagnot" rowspan="2">#</th>
                                        <th class="check_box boxme" rowspan="2">
                                            <input type="checkbox" id="myCheckbox" name="myCheckbox">
                                        </th>
                                        <th class="bagusercc">username</th>
                                        <th class="bagusercc" rowspan="2">jenis bonus</th>
                                        <th class="bagturnover" rowspan="2">turnover</th>
                                        <th class="bagwinlose" rowspan="2">win/lose</th>
                                        <th class="bagnominalbonus" rowspan="2">nominal bonus (IDR)</th>
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
                                            <td>{{ $i + 1 }}</td>
                                            <td class="check_box">
                                                <input type="checkbox" id="myCheckbox-{{ $i }}"
                                                    name="myCheckbox-{{ $i }}"
                                                    data-username="{{ $d->username }}"
                                                    data-bonus = "{{ $d->totalbonus }}"
                                                    data-stake= "{{ $d->totalstake }}"
                                                    data-winloss= "{{ $d->totalwinloss }}"
                                                    data-portfolio= "{{ $d->portfolio }}"
                                                    data-productsname= "{{ $d->productsname }}">
                                            </td>
                                            <td class="username">{{ $d->username }}</td>
                                            <td class="username">{{ $d->productsname }}</td>
                                            <td class="datacc" data-get="{{ $d->totalstake }}"></td>
                                            <td class="datacc" data-get="{{ $d->totalwinloss }}"></td>
                                            <td class="datacc" data-get="{{ $d->totalbonus }}"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
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
            var value = parseFloat($('.nominalbonus').attr('data-bonus')).toFixed(2);
            var formattedValue = formatCurrency(value);
            $('.nominalbonus').text(formattedValue);
        });

        function formatCurrency(amount) {
            return 'IDR ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").replace('.00', '.');
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
                        var detailBonus = $('#select-input').val();

                        $('input[type="checkbox"]:checked').not('#myCheckbox').each(function() {
                            var username = $(this).data('username');
                            var bonus = $(this).data('bonus');
                            var stake = $(this).data('stake');
                            var winloss = $(this).data('winloss');
                            var portfolio = $(this).data('portfolio');
                            var productsname = $(this).data('productsname');

                            if (username !== '') {
                                data.push({
                                    username,
                                    bonus,
                                    stake,
                                    winloss,
                                    portfolio,
                                    productsname
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
                                gabunghinggaVal) + '/' + encodeURIComponent(kecualiVal) + '/' +
                            encodeURIComponent(detailBonus);

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: JSON.stringify({
                                data: data
                            }),
                            contentType: 'application/json',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(response) {
                                var id = response.id;
                                // Display failed usernames if any
                                if (response.failedUsernames.length > 0) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal Diproses',
                                        html: 'Username berikut gagal diproses:<ul>' +
                                            response.failedUsernames.map(
                                                username =>
                                                `<li>${username}</li>`).join(
                                                '') +
                                            '</ul>',
                                        didClose: () => {
                                            window.open('/bonusdetailds/' +
                                                id, '_blank');
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses',
                                        text: 'Proses data bonus berhasil!',
                                        timer: 2000,
                                        showConfirmButton: true,
                                        confirmButtonText: 'Oke',
                                        didClose: () => {
                                            window.open('/bonusdetailds/' +
                                                id, '_blank');
                                        }
                                    });
                                }
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
                    var bonus = $('#bonus').val();
                    var gabungdari = $('#gabungdari').val();
                    var gabunghingga = $('#gabunghingga').val();
                    var kecuali = $('#kecuali').val();
                    var detail_bonus = $('#detail_bonus').val();

                    var url = '/bonusds/export?bonus=' + encodeURIComponent(bonus) +
                        '&gabungdari=' + encodeURIComponent(gabungdari) +
                        '&gabunghingga=' + encodeURIComponent(gabunghingga) +
                        '&kecuali=' + encodeURIComponent(kecuali) +
                        '&detail_bonus=' + encodeURIComponent(detail_bonus);


                    // Redirect ke URL
                    window.location.href = url;
                }
            });
        });

        $(document).ready(function() {
            $('#select-input').on('click', function() {
                $('.options-container').toggle();
            });

            $(document).on('change', '.option-item input', function() {
                const selectedOptions = $('.option-item input:checked').map(function() {
                    return this.value;
                }).get();

                const selectedValueString = selectedOptions.join(', ') || 'Pilih game';
                $('#select-input').val(selectedValueString);
                $('#detail_bonus').val(selectedValueString);
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('.select-box').length) {
                    $('.options-container').hide();
                }
            });

            $('#bonus').on('change', function() {
                const selectedValue = $(this).val();

                Swal.fire({
                    title: 'Loading...',
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });

                $.ajax({
                    url: '/bonusds/getdataproduct/' + selectedValue,
                    type: 'GET',
                    success: function(response) {
                        let optionsHTML = '';
                        const checkedValues = [];

                        response.forEach(function(item, index) {
                            const isChecked = 'checked';
                            optionsHTML += `
                        <div class="option-item">
                            <input type="checkbox" id="option${index}" value="${item.productsname}" ${isChecked}>
                            <label for="option${index}">${item.productsname}</label>
                        </div>
                    `;
                            checkedValues.push(item.productsname);
                        });

                        $('.options-container').html(optionsHTML);

                        const checkedValuesString = checkedValues.join(', ') || 'Pilih game';
                        $('#select-input').val(checkedValuesString);
                        $('#detail_bonus').val(
                            checkedValuesString);

                        Swal.close();
                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan: ' + error);

                        Swal.close();

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat mengambil data.'
                        });
                    }
                });
            });
        });
    </script>
@endsection
