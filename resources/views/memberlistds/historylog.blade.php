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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            adjustElementSize();
        });
    </script>
</head>
<div class="body_openwindow datawinlose">
    <div class="sec_openwindow">
        <div class="table_detailhistorygameds">
            <span class="titlewinloseuser">{{ $title }}</span>
            <table>
                <tbody>
                    <tr>
                        <th class="bagxdate">username</th>
                        <th class="bagxdate">jenis</th>
                        <th class="bagxdate">ipaddress</th>
                        <th class="bagxdate">tanggal</th>
                    </tr>
                    @if (!empty($data) && count($data) > 0)
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ $d['username'] }}</td>
                                <td>{{ $d['jenis'] }}</td>
                                <td>
                                    <a href="https://ipinfo.io/{{ $d['ipaddress'] }}"
                                        target="_blank">{{ $d['ipaddress'] }}
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img"
                                            class="iconify iconify--fluent-mdl2" width="1em" height="1em"
                                            viewBox="0 0 2048 2048">
                                            <path fill="currentColor"
                                                d="M2048 0v1664h-384v384H0V384h384V0zm-128 1536V128H512v256h256v128H128v1408h1408v-640h128v256zm-979-339l-90-90l594-595h-421V384h640v640h-128V603z">
                                            </path>
                                        </svg>
                                    </a>
                                </td>
                                <td>
                                    @php
                                        $date = new DateTime($d['updated_at']);
                                        $newFormat = $date->format('Y-m-d H:i:s');
                                        echo $newFormat;
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">Tidak ada aktifitas akun</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // print nilai statusdeposit
    $(document).ready(function() {
        var countdownValue = $('.statusdepo').attr('data-countdownline');
        var jenisGames = getUrlParameter('games');
        var statusValue = getUrlParameter('statusdp');
        var tanggalFrom = getUrlParameter('datefrom');
        var tanggalTo = getUrlParameter('dateto');
        var combinedValue = countdownValue;
        $('.jenisgames').text(jenisGames);
        $('.statusdepo').text(combinedValue);
        $('.textdepo').text(statusValue);
        $('.tangfrom').text(tanggalFrom);
        $('.tangto').text(tanggalTo);

        if (statusValue.toLowerCase() === 'all') {
            $('.jumlahdownline').remove();
        }
    });

    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        if (results === null) {
            return '';
        } else {
            var value = decodeURIComponent(results[1].replace(/\+/g, ' '));
            return value.split('?')[0];
        }
    }

    $(document).ready(function() {
        // Format nominal
        $(".nominal").each(function() {
            var nominal = $(this).attr("data-value");
            var formattedNominal = parseFloat(nominal).toLocaleString('en', {
                maximumFractionDigits: 2
            });
            $(this).text(formattedNominal);
        });

        // Hitung winlose untuk setiap baris
        $("tr").each(function() {
            var depositValue = parseFloat($(this).find(".deposit").attr("data-value"));
            var withdrawValue = parseFloat($(this).find(".withdraw").attr("data-value"));
            var totalValue = depositValue - withdrawValue;
            $(this).find(".total").attr("data-value", totalValue);
            $(this).find(".total").text(totalValue.toLocaleString('en', {
                maximumFractionDigits: 2
            }));
        });

        // Jumlahkan semua nilai deposit
        var totalDeposit = 0;
        $(".deposit").each(function() {
            totalDeposit += parseFloat($(this).attr("data-value"));
        });
        $(".subdeposit").attr("data-value", totalDeposit);
        $(".subdeposit").text(totalDeposit.toLocaleString('en', {
            maximumFractionDigits: 2
        }));

        // Jumlahkan semua nilai withdraw
        var totalWithdraw = 0;
        $(".withdraw").each(function() {
            totalWithdraw += parseFloat($(this).attr("data-value"));
        });
        $(".subwithdraw").attr("data-value", totalWithdraw);
        $(".subwithdraw").text(totalWithdraw.toLocaleString('en', {
            maximumFractionDigits: 2
        }));

        // Jumlahkan semua nilai total
        var totalTotal = 0;
        $(".total").each(function() {
            totalTotal += parseFloat($(this).attr("data-value"));
        });
        $(".subtotal").attr("data-value", totalTotal);
        $(".subtotal").text(totalTotal.toLocaleString('en', {
            maximumFractionDigits: 2
        }));
    });
</script>
