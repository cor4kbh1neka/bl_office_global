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
    <div class="body_openwindow feedback agentinfo">
        <div class="sec_openwindow">
            <div class="groupdetailhistorygameds">
                <span class="titleinfo">Agent Profile - AdminIT</span>
                <div class="headdetailhistorygameds">
                    <div class="listheaddetail">
                        <span class="label">cash balance</span>
                        <span class="gap">:</span>
                        <span class="value refNo">200,000.15</span>
                    </div>
                    <div class="listheaddetail">
                        <span class="label">ember balance</span>
                        <span class="gap">:</span>
                        <span class="value refNo">60,564.69</span>
                    </div>
                    <div class="listheaddetail">
                        <span class="label">total balance</span>
                        <span class="gap">:</span>
                        <span class="value refNo">260,564.30</span>
                    </div>
                    <div class="listheaddetail">
                        <span class="label">total outstanding</span>
                        <span class="gap">:</span>
                        <span class="value refNo">763(20 bets)</span>
                    </div>
                    <div class="listheaddetail">
                        <span class="label">currency</span>
                        <span class="gap">:</span>
                        <span class="value refNo">IDR</span>
                    </div>
                    <div class="listheaddetail">
                        <span class="label">total member</span>
                        <span class="gap">:</span>
                        <span class="value refNo">1,230</span>
                    </div>
                </div>
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