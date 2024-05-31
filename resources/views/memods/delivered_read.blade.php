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

    <script>
        $(document).ready(function() {
            adjustElementSize();
        });
    </script>
</head>
<div class="body_openwindow feedback">
    <div class="sec_openwindow">
        <div class="headfeedback">
            <span class="namauser">Message - DV{{ sprintf('%06d', $data['idmemo']) }}</span>
        </div>
        <div class="datainbox">
            <div class="detailfeedback">
                <div class="listdetailfeedback">
                    <div class="labeldetail">pengirim</div>
                    <span class="gap">:</span>
                    <div class="valuedetail">ADMIN GLOBAL BOLA</div>
                </div>
                <div class="listdetailfeedback">
                    <div class="labeldetail">penerima</div>
                    <span class="gap">:</span>
                    <div class="valuedetail">{{ $data['statuspriority'] == 1 ? 'All Member' : 'Only VIP' }}</div>
                </div>
                <div class="listdetailfeedback">
                    <div class="labeldetail">tanggal message</div>
                    <span class="gap">:</span>
                    <div class="valuedetail">2024-04-03 13:29:37</div>
                </div>
                <div class="listdetailfeedback">
                    <div class="labeldetail">subject</div>
                    <span class="gap">:</span>
                    <div class="valuedetail">{{ $data['subject'] }}</div>
                </div>
                <div class="listdetailfeedback top">
                    <div class="labeldetail">memo</div>
                    <span class="gap">:</span>
                    <div class="valuedetail">{{ $data['memo'] }}</div>
                </div>
            </div>
            <div class="grouphandlepesan">
                <button class="tombol cancel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                    </svg>
                    <span class="texttombol">DELETE</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".groupvaluedetail").each(function() {
            var jeniskontak = $(this).attr("data-jeniskontak");
            var nomorkontak = $(this).attr("data-nomorkontak");
            var valuedetailElement = $(this).find(".valuedetail");
            var hubungiElement = $(this).find(".hubungi");
            var link;

            if (jeniskontak === "wa") {
                link = "https://wa.me/" + nomorkontak;
            } else if (jeniskontak === "tele") {
                link = "https://t.me/" + nomorkontak;
            }

            hubungiElement.text("Hubungi " + jeniskontak);
            hubungiElement.attr("href", link);
            valuedetailElement.text(nomorkontak);
        });
    });
</script>
