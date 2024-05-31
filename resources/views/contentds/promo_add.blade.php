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
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }} </h2>
        </div>
        <div class="seceditmemberds updateagent">
            <div class="groupseceditmemberds">
                <spann class="titleeditmemberds">add promo</spann>
                <form action="/contentds/promo" method="POST">
                    @csrf
                    <div class="groupplayerinfo editpromo">
                        <div class="listgroupplayerinfo left">
                            <div class="listplayerinfo">
                                <label for="titlepromo">title promo</label>
                                <div class="groupeditinput">
                                    <input type="text" id="titlepromo" name="titlepromo" value="" placeholder="isi judul promo">
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="imgurl">image promo url</label>
                                <div class="groupeditinput">
                                    <input type="text" id="imgurl" name="imgurl" value="" placeholder="ukuran 392x141 contoh: https://via.placeholder.com/392x141">
                                </div>
                            </div>
                            <div class="listplayerinfo ssimage">
                                <label for=""></label>
                                <img class="showimage" src="" alt="image"> <!-- value src tidak perlu di isi, sudah di handle pada javascript -->
                            </div>
                            <div class="listplayerinfo">
                                <label for="description">promo description</label>
                                <div class="groupeditinput">
                                    <textarea id="description" name="description" cols="30" rows="10" placeholder="isi deksripsi promo"></textarea>
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="targeturl">target url</label>
                                <div class="groupeditinput">
                                    <input type="text" id="targeturl" name="targeturl" value="" placeholder="isi link target promo">
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="urutanpromo">urutan promo</label>
                                <div class="groupeditinput">
                                    <input type="text" id="urutanpromo" name="urutanpromo" value="1" placeholder="default menjadi urutan 1">
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <span class="labelbetpl">STATUS</span>
                                <div class="groupradiooption" data-chekced="1">
                                    <div class="listgrpstatusbank">
                                        <input class="status_online" type="radio" id="active" name="statuspromo" value="1">
                                        <label for="active">active</label>
                                    </div>
                                    <div class="listgrpstatusbank">
                                        <input class="status_offline" type="radio" id="inactive" name="statuspromo" value="2">
                                        <label for="inactive">in-active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="listgroupplayerinfo right solo">
                            <button class="tombol primary" type="submit">
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
        $(document).ready(function(){
            $('.groupradiooption[data-chekced]').each(function(){
                var checkedBankValue = $(this).attr('data-chekced');
                $(this).find('.listgrpstatusbank input[type="radio"][value="' + checkedBankValue + '"]').prop('checked', true);
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
    </script>