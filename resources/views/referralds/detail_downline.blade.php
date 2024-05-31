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
<div class="body_openwindow datadownline">
    <div class="sec_openwindow">
        <div class="groupdetailhistorygameds">
            <div class="headdetailhistorygameds">
                <div class="listheaddetail">
                    <span class="label">Upline</span>
                    <span class="gap">:</span>
                    <span class="value username"><span class="valueall">{{ $upline }}</span></span>
                </div>
                <div class="listheaddetail">
                    <span class="label">Tanggal Dari</span>
                    <span class="gap">:</span>
                    <span class="value orderTime">{{ $gabungdari }}<span
                            class="tangfrom">{{ $gabungdari }}</span></span>
                </div>
                <div class="listheaddetail">
                    <span class="label">Tanggal Hingga</span>
                    <span class="gap">:</span>
                    <span class="value orderTime">{{ $gabungdari }}<span
                            class="tangto">{{ $gabungdari }}</span></span>
                </div>
                <div class="listheaddetail">
                    <span class="label">Total All Downline</span>
                    <span class="gap">:</span>
                    <span class="value orderTime"><span class="valueall">{{ $total_referral }}</span> (all)</span>
                </div>
                <div class="listheaddetail jumlahdownline">
                    <span class="label">Jumlah Downline</span>
                    <span class="gap">:</span>
                    <span class="value sportsType"><span class="statusdepo"
                            data-countdownline="{{ $total_referral }}"></span> ({{ $countdata }})</span>
                </div>
                <div class="listheaddetail">
                    <span class="label">Total Balance (IDR)</span>
                    <span class="gap">:</span>
                    <span class="value sportsType nominalreff" data-bonusreff="{{ $total_downline }}"></span>
                </div>
                <div class="filterdata">
                    <div class="listfilterdata">
                        <label for="typedata">type data</label>
                        <select name="typedata" id="filterdata">
                            <option value="all">all data</option>
                            <option value="kurangdari">kurang dari</option>
                            <option value="lebihdari">lebih dari</option>
                        </select>
                    </div>
                    <div class="listfilterdata">
                        <label for="valuenominal">value balance/bonus</label>
                        <input type="number" name="valuenominal" id="valuenominal" placeholder="tanpa koma atau titik">
                    </div>
                    <button id="filterButton">
                        <span class="texttombol">FILTER</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="table_detailhistorygameds">
            <table>
                <tbody>
                    <tr>
                        <th class="bagno">#</th>
                        <th class="baguser">username</th>
                        <th class="bagbons">balance (IDR)</th>
                    </tr>
                    @foreach ($data as $i => $d)
                        <tr>
                            <td class="nmr">{{ $i + 1 }}</td>
                            <td>{{ $d->downline }}</td>
                            <td class="nominalbonus" data-bonusreff="{{ $d->total_amount_referral }}">
                                {{ $d->total_amount_referral }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // print nominal bonus reff
    $(document).ready(function() {
        var value = parseFloat($('.nominalreff').attr('data-bonusreff')).toFixed(2);
        var formattedValue = formatCurrency(value);
        $('.nominalreff').text(formattedValue);
    });

    $(document).ready(function() {
        $('.nominalbonus').each(function() {
            var value = parseFloat($(this).attr('data-bonusreff')).toFixed(2);
            var formattedValue = value;
            $(this).text(formattedValue);
        });
    });

    function formatCurrency(amount) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // print nilai statusdeposit
    $(document).ready(function() {
        var countdownValue = $('.statusdepo').attr('data-countdownline');
        var statusValue = getUrlParameter('statusdp');
        var tanggalFrom = getUrlParameter('datefrom');
        var tanggalTo = getUrlParameter('dateto');
        var combinedValue = countdownValue;
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
        function filterData() {
            var filterType = $('#filterdata').val();
            var valueNominal = $('#valuenominal').val();

            if (!filterType) {
                alert('Pilih type data terlebih dahulu');
                return;
            }

            if (!valueNominal) {
                alert('Value Balance/Bonus tidak boleh kosong');
                return;
            }

            valueNominal = parseFloat(valueNominal);
            $('table tbody tr').show().filter(function() {
                var balance = parseFloat($(this).find('.nominalbonus').data('bonusreff'));

                if (filterType === 'all') {
                    return false;
                } else if (filterType === 'kurangdari') {
                    return balance >= valueNominal || balance == valueNominal;
                } else if (filterType === 'lebihdari') {
                    return balance <= valueNominal || balance == valueNominal;
                }


            }).hide();

        }

        $('#filterButton').click(filterData);

        $('#valuenominal').keydown(function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                filterData();
            }
        });
    });
</script>
