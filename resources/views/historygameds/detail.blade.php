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
<div class="body_openwindow">
    <div class="sec_openwindow">
        <div class="groupdetailhistorygameds">
            <div class="headdetailhistorygameds">
                <div class="listheaddetail">
                    <span class="label">Nomor Invoice</span>
                    <span class="gap">:</span>
                    <span class="value refNo">{{ $data['refNo'] }}</span>
                </div>
                <div class="listheaddetail">
                    <span class="label">Username</span>
                    <span class="gap">:</span>
                    <span class="value username">{{ $data['username'] }}</span>
                </div>
                <div class="listheaddetail">
                    <span class="label">Date/Time Bet</span>
                    <span class="gap">:</span>
                    <span class="value orderTime">{{ date('d-m-Y H:i:s', strtotime($data['orderTime'])) }}</span>
                </div>
                <div class="listheaddetail">
                    <span class="label">Game Type</span>
                    <span class="gap">:</span>
                    <span class="value sportsType">
                        @if ($portfolio == 'SportsBook')
                            {{ $data['sportsType'] }}
                        @elseif($portfolio == 'SeamlessGame')
                            {{ $data['gameType'] }}
                        @else
                            {{ $data['productType'] }}
                        @endif

                    </span>
                </div>
                @if ($portfolio != 'SeamlessGame')
                    <div class="listheaddetail">
                        <span class="label">Odds Type</span>
                        <span class="gap">:</span>
                        <span class="value odds">{{ $data['oddsStyle'] }}</span>
                    </div>
                    <div class="listheaddetail">
                        <span class="label">Odds Bet</span>
                        <span class="gap">:</span>
                        <span class="value odds">{{ $data['odds'] }}</span>
                    </div>
                @endif
                <div class="listheaddetail">
                    <span class="label">Nominal Bet(IDR)</span>
                    <span class="gap">:</span>
                    <span class="valuenominal stake" data-stake="{{ $data['stake'] }}"></span>
                </div>
                <div class="listheaddetail">
                    <span class="label">Win/Lose(IDR)</span>
                    <span class="gap">:</span>
                    <div class="grouphasilpertandingan">
                        <span class="valuenominal winLost" data-winLost="{{ $data['winLost'] }}"></span>
                        <span class="statusgame status"
                            data-status="{{ $data['status'] }}">{{ $data['status'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="table_detailhistorygameds">
            <table>
                <tbody>
                    @if ($portfolio != 'SeamlessGame')
                        @foreach ($data['subBet'] as $i => $d)
                            <tr>
                                <td class="bagnomor">{{ $i + 1 }}</td>
                                <td>
                                    <div class="groupdetailmatch">
                                        @if (isset($d['league']))
                                            <span class="namaliga subBet-league">{{ $d['league'] }}</span>
                                        @endif
                                        <span class="pertandingan subBet-match">{{ $d['match'] }}</span>
                                        <div class="allscore">
                                            <div class="listscore">
                                                <span class="labelscore">HT</span>
                                                <span class="valuescore subBet-htScore">{{ $d['htScore'] }}</span>
                                            </div>
                                            <div class="listscore">
                                                <span class="labelscore">FT</span>
                                                <span class="valuescore subBet-ftScore">{{ $d['ftScore'] }}</span>
                                            </div>
                                        </div>
                                        @if (isset($d['isHalfWonLose']))
                                            <span class="detailbetting">detail bet : <span class="htft isHalfWonLose"
                                                    data-isHalfWonLose="{{ $d['isHalfWonLose'] }}"></span></span>
                                        @endif
                                        <div class="listdetailbettting">
                                            <div class="dddetailbetting">
                                                <span class="labelbet">type :</span>
                                                <span
                                                    class="valuebet subBet-marketType_sportType">{{ $d['marketType'] }}
                                                    @if (isset($d['sportType']))
                                                        ({{ $d['sportType'] }})
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="dddetailbetting">
                                                <span class="labelbet">odds :</span>
                                                <span class="valuebet subBet-odds"
                                                    data-valueodds="{{ $d['odds'] }}">{{ $d['odds'] }}</span>
                                            </div>
                                        </div>
                                        <div class="listdetailbettting">
                                            <div class="dddetailbetting">
                                                <span class="labelbet">pilihan :</span>
                                                <span class="valuebet subBet-betOption">{{ $d['betOption'] }} <span
                                                        class="subBet-hdp"
                                                        data-hdp="{{ $d['hdp'] }}">({{ $d['hdp'] }})</span></span>
                                            </div>
                                            <div class="dddetailbetting">
                                                <span class="labelbet">status :</span>
                                                <span class="valuebet subBet status"
                                                    data-statusbet="{{ $d['status'] }}">{{ $d['status'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    //format nominal odds dan stake
    $(document).ready(function() {
        $('div').each(function() {

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

    //half time dan fulltime
    $(document).ready(function() {
        $(".htft").each(function() {
            var isHalfWonLose = $(this).attr("data-isHalfWonLose");

            if (isHalfWonLose === "true") {
                $(this).text("Half Time");
            } else {
                $(this).text("Full Time");
            }
        });
    });
</script>
