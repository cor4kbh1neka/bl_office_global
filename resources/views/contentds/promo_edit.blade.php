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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="sec_table newwindow">
    <div class="secgrouptitle">
        <h2>{{ $title }} </h2>
    </div>
    <div class="seceditmemberds updateagent">
        <div class="groupseceditmemberds">
            <spann class="titleeditmemberds">edit promo</spann>
            <form action="/contentds/promo/{{ $data->idctprm }}" method="POST">
                @method('put')
                @csrf
                <div class="groupplayerinfo editpromo">
                    <div class="listgroupplayerinfo left">
                        <div class="listplayerinfo">
                            <label for="titlepromo">title promo</label>
                            <div class="groupeditinput">
                                <input type="text" readonly id="titlepromo" name="titlepromo"
                                    value="{{ $data->ttlectprm }}" placeholder="isi judul promo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                </svg>
                            </div>
                        </div>
                        <div class="listplayerinfo">
                            <label for="imgurl">image promo url</label>
                            <div class="groupeditinput">
                                <input type="text" readonly id="imgurl" name="imgurl"
                                    value="{{ $data->ctprmur }}"
                                    placeholder="ukuran 392x141 contoh: https://via.placeholder.com/392x141">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                </svg>
                            </div>
                        </div>
                        <div class="listplayerinfo ssimage">
                            <label for=""></label>
                            <img class="showimage" src="" alt="image">
                            <!-- value src tidak perlu di isi, sudah di handle pada javascript -->
                        </div>
                        <div class="listplayerinfo">
                            <label for="description">promo description</label>
                            <div class="groupeditinput">
                                <textarea id="description" name="description" cols="30" rows="10" placeholder="isi deksripsi promo">{{ $data->dskprm }}</textarea>
                            </div>
                        </div>
                        <div class="listplayerinfo">
                            <label for="targeturl">target url</label>
                            <div class="groupeditinput">
                                <input type="text" readonly id="targeturl" name="targeturl"
                                    value="{{ $data->trgturctprm }}" placeholder="isi link target promo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                </svg>
                            </div>
                        </div>
                        <div class="listplayerinfo">
                            <label for="urutanpromo">urutan promo</label>
                            <div class="groupeditinput">
                                <input style="color:#ffffff" type="text" id="urutanpromoss" readonly
                                    name="urutanpromo" placeholder="{{ $data->pssprm }}">
                                <svg id="ccc" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                </svg>
                            </div>
                        </div>
                        <div class="listplayerinfo">
                            <span class="labelbetpl">STATUS</span>
                            <div class="groupradiooption" data-chekced="{{ $data->statusctprm }}">
                                <div class="listgrpstatusbank">
                                    <input class="status_online" type="radio" id="active" name="statuspromo"
                                        value="1">
                                    <label for="active">active</label>
                                </div>
                                <div class="listgrpstatusbank">
                                    <input class="status_offline" type="radio" id="inactive" name="statuspromo"
                                        value="2">
                                    <label for="inactive">in-active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="listgroupplayerinfo right solo">
                        <button class="tombol primary">
                            <span class="texttombol">SAVE DATA</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.groupeditinput svg').click(function() {
            $(this).closest('.groupeditinput').toggleClass('edit');
            $(this).siblings('input').prop('readonly', function(_, val) {
                return !val;
            });
        });
    });

    // checked radio button berdasarkan value dari status 1, 2
    $(document).ready(function() {
        $('.groupradiooption[data-chekced]').each(function() {
            var checkedBankValue = $(this).attr('data-chekced');
            $(this).find('.listgrpstatusbank input[type="radio"][value="' + checkedBankValue + '"]')
                .prop('checked', true);
        });
    });

    // show image
    $(document).ready(function() {
        var imgUrl = $('#imgurl').val();
        if (imgUrl !== '') {
            $('.showimage').attr('src', imgUrl);
        } else {
            $('.showimage').remove();
            $('.ssimage').append('<span class="imagekosong">Gambar akan tampil di sini</span>');
        }

        $('#imgurl').on('blur', function() {
            var imgUrl = $(this).val();
            if (imgUrl !== '') {
                $('.imagekosong').remove();
                $('.ssimage').append('<img class="showimage" src="' + imgUrl + '" alt="image">');
            } else {
                $('.showimage').remove();
                $('.ssimage').append('<span class="imagekosong">Gambar akan tampil di sini</span>');
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const svgButton = document.getElementById('ccc');
        const inputField = document.getElementById('urutanpromoss');
        let isBlack = false;

        svgButton.addEventListener('click', function() {
            if (isBlack) {
                inputField.style.color = '#ffffff';
                Swal.fire({
                    title: 'Pastikan tidak ada urutan yang sama!',
                    showDenyButton: true,
                    confirmButtonText: 'Setuju',
                    denyButtonText: 'Tidak setuju',
                }).then((result) => {
                    if (result.isDenied) {
                        inputField.style.color = '#000000';
                        isBlack = true;
                        Swal.fire('Perubahan dibatalkan', '', 'info');
                    }
                });
            } else {
                inputField.style.color = '#000000';
            }
            isBlack = !isBlack;
        });
    });
</script>
