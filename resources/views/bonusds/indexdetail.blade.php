<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/utama/g21-icon.ico') }}" />
    <title>Dashboard | L21</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/design.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/custom_dash.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    {{-- <script>
        $(document).ready(function() {
            adjustElementSize();
        });
    </script> --}}
</head>

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
            <div class="groupdatareportds">
                <div class="grouphistoryds memberlist">
                    <div class="groupheadhistoryds">
                        <form method="GET" action="/bonusds" class="listmembergroup">
                            <div class="listinputmember">
                                <label for="bonus">Bonus</label>
                                <select name="bonus" id="bonus" required>
                                    <option value="" selected="" place=""
                                        style="color: #838383; font-style: italic;" disabled>Pilih Bonus</option>
                                    <option value="cashback" {{ $data->jenis_bonus == 'cashback' ? 'selected' : '' }}>
                                        Cashback
                                    </option>
                                    <option value="rolingan" {{ $data->jenis_bonus == 'rolingan' ? 'selected' : '' }}>
                                        Rollingan
                                    </option>
                                </select>
                            </div>
                            <div class="listinputmember">
                                <label for="gabungdari">tanggal dari</label>
                                <input type="date" id="gabungdari" name="gabungdari"
                                    placeholder="tanggal gabung dari" value="{{ $data->periodedari }}" disabled
                                    required>
                            </div>
                            <div class="listinputmember">
                                <label for="gabunghingga">tanggal hingga</label>
                                <input type="date" id="gabunghingga" name="gabunghingga"
                                    placeholder="tanggal gabung hingga" value="{{ $data->periodesampai }}" disabled
                                    required>
                            </div>
                            <div class="listinputmember">
                                <label for="kecuali">Pengecualian</label>
                                <select name="kecuali" id="kecuali" disabled required>
                                    <option value="" selected="" place=""
                                        style="color: #838383; font-style: italic;" disabled="">Pilih pengecualian
                                    </option>
                                    @foreach ($dataBonusPengecualian as $d)
                                        <option value="{{ $d->nama }}"
                                            {{ $d->nama == $data->kecuali ? 'selected' : '' }}>{{ $d->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="listinputmember">
                                    <button class="tombol primary" disabled>
                                        <span class="texttombol">SUBMIT</span>
                                    </button>
                                </div> --}}
                            <div class="grouprightbtn">
                                <div class="listinputmember">
                                    <button type="button" id="cancelproses" class="tombol cancel"
                                        data-listbonus_id = "{{ $data->listbonus_id }}" disabled>
                                        <span class="texttombol">CANCEL BONUS</span>
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
                        </form>
                    </div>
                    <div class="totalbonus">
                        <div class="listtotalbonus">
                            <span class="textbonus">Bonus :</span>
                            <span class="countbonus">{{ ucfirst($data->jenis_bonus) }}</span>
                        </div>
                        <div class="listtotalbonus">
                            <span class="textbonus">tanggal :</span>
                            <div class="grouptgllistbonus">
                                <span class="countbonus from">{{ $data->periodedari }}</span>
                                <span>s/d</span>
                                <span class="countbonus to">{{ $data->periodesampai }}</span>
                            </div>
                        </div>
                        <div class="listtotalbonus">
                            <span class="textbonus">Pengecualian :</span>
                            <span class="countbonus">{{ $data->kecuali }}</span>
                        </div>
                        <div class="listtotalbonus">
                            <span class="textbonus">Jumlah User :</span>
                            <span class="countbonus">{{ $total_user }}</span>
                        </div>
                        <div class="listtotalbonus">
                            <span class="textbonus">total bonus :</span>
                            <span class="nominalbonus" data-bonus="{{ $total_bonus * 1000 }}"></span>
                        </div>
                    </div>
                    <div class="tabelproses">
                        <table>
                            <tbody>
                                <tr class="hdtable">
                                    <th class="bagnot" rowspan="2">#</th>
                                    <th class="check_box boxme" rowspan="2">
                                        <input type="checkbox" id="myCheckbox" name="myCheckbox" checked disabled>
                                    </th>
                                    <th class="bagusercc">username</th>
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
                                @foreach ($datadetail as $i => $d)
                                    <tr>
                                        <td>1</td>
                                        <td class="check_box">
                                            <input type="checkbox" id="myCheckbox-{{ $i }}"
                                                name="myCheckbox-{{ $i }}" checked disabled>
                                        </td>
                                        <td class="username">{{ $d->username }}</td>
                                        <td class="datacc" data-get="{{ $d->turnover }}"></td>
                                        <td class="datacc" data-get="{{ $d->winlose }}"></td>
                                        <td class="datacc" data-get="{{ $d->bonus }}"></td>
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
        $('#cancelproses').click(function() {
            Swal.fire({
                icon: 'question',
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin mengcancel data ini?',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
            }).then(function(result) {
                if (result.isConfirmed) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

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

                    var url = '/cancelbonusds';

                    var listbonus_id = $(this).data('listbonus_id');
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            listbonus_id: listbonus_id
                        },
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: 'Proses cancel bonus berhasil!',
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
</script>
