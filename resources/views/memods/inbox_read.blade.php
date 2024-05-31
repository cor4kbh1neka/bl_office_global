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
                <span class="namauser">Feedback - thanos989898</span>
            </div>
            <div class="datainbox">
                <div class="detailfeedback">
                    <div class="listdetailfeedback">
                        <div class="labeldetail">ID message</div>
                        <span class="gap">:</span>
                        <div class="valuedetail">MS000001</div>
                    </div>
                    <div class="listdetailfeedback">
                        <div class="labeldetail">tanggal message</div>
                        <span class="gap">:</span>
                        <div class="valuedetail">2024-04-03 13:29:37</div>
                    </div>
                    <div class="listdetailfeedback">
                        <div class="labeldetail">username</div>
                        <span class="gap">:</span>
                        <div class="valuedetail">thanos989898</div> <!-- maksimal 20 karakter -->
                    </div>
                    <div class="listdetailfeedback">
                        <div class="labeldetail">kontak</div>
                        <span class="gap">:</span>
                        <div class="groupvaluedetail" data-jeniskontak="wa" data-nomorkontak="628123456789"> <!-- data-jeniskontak "dropdown" wa atau tele, data-nomorkontak dimulai dengan kode negara tanpa symbol "+" maksimal 16 karakter -->
                            <div class="valuedetail"></div>
                            <a href="" target="_blank" class="hubungi"></a>
                        </div>
                    </div>
                    <div class="listdetailfeedback">
                        <div class="labeldetail">berkendala di</div>
                        <span class="gap">:</span>
                        <div class="valuedetail">akun</div> <!-- "dropdown" akun, deposit, withdraw, games, lainnya. -->
                    </div>
                    <div class="listdetailfeedback">
                        <div class="labeldetail">tanggal kejadian</div>
                        <span class="gap">:</span>
                        <div class="valuedetail">2024-04-03</div>
                    </div>
                    <div class="listdetailfeedback top">
                        <div class="labeldetail">kendala/kronologi</div>
                        <span class="gap">:</span>
                        <div class="valuedetail">saya baru saja deposit lalu tiba tiba akun saya tidak bisa dibuka, muncul keterangan akun di blokir</div> <!-- maksimal 120 karakter, dilarang input menggunakan tipe tag html -->
                    </div>
                    <div class="listdetailfeedback top">
                        <div class="labeldetail">kritik dan saran</div>
                        <span class="gap">:</span>
                        <div class="valuedetail">jangan sembarangan memblokir akun</div> <!-- maksimal 120 karakter, dilarang input menggunakan tipe tag html -->
                    </div>
                    <div class="listdetailfeedback">
                        <div class="labeldetail">beri penilaian</div>
                        <span class="gap">:</span>
                        <div class="valuedetail">Sangat Buruk</div> <!-- "dropdown" Sangat Buruk, Buruk, Cukup, Baik, Sangat Baik -->
                    </div>
                    <div class="listdetailfeedback top">
                        <div class="labeldetail">bukti gambar</div>
                        <span class="gap">:</span>
                        <a href="https://mediakonsumen.com/files/2022/06/WhatsApp-Image-2022-06-20-at-13.52.12.jpeg" target="_blank">
                            <img class="valuedetail" src="https://mediakonsumen.com/files/2022/06/WhatsApp-Image-2022-06-20-at-13.52.12.jpeg"> <!-- maksimal size upload image adalah 2mb -->
                        </a>
                    </div>
                </div>
                <div class="grouphandlepesan">
                    <button class="tombol proses">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 6h10M7 9h10m-8 8h6" />
                                <path d="M3 12h-.4a.6.6 0 0 0-.6.6v8.8a.6.6 0 0 0 .6.6h18.8a.6.6 0 0 0 .6-.6v-8.8a.6.6 0 0 0-.6-.6H21M3 12V2.6a.6.6 0 0 1 .6-.6h16.8a.6.6 0 0 1 .6.6V12M3 12h18" />
                            </g>
                        </svg>
                        <span class="texttombol">ARCHIVE</span>
                    </button>
                    <button class="tombol cancel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
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