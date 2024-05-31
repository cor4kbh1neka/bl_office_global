@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>
            <div class="kembali">
                <a href="/memberlistds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                        <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"
                            d="M44 40.836c-4.893-5.973-9.238-9.362-13.036-10.168c-3.797-.805-7.412-.927-10.846-.365V41L4 23.545L20.118 7v10.167c6.349.05 11.746 2.328 16.192 6.833c4.445 4.505 7.009 10.117 7.69 16.836Z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="textkembali">Kembali</span>
                </a>
            </div>
        </div>
        <div class="secagentds">
            <div class="groupsecagentds">
                <span class="titlebankmaster">Tambah member</span>
                <form method="POST" action="/memberlistds/store" id="form-agentds" class="groupplayerinfo">
                    @csrf
                    <div class="listgroupplayerinfo left">
                        <div class="listplayerinfo">
                            <label for="username">username</label>
                            <div class="groupeditinput">
                                <input type="text" id="username" name="username" value=""
                                    placeholder="masukkan username">
                            </div>
                        </div>
                        <div class="listplayerinfo">
                            <label for="referral">referral</label>
                            <div class="groupeditinput">
                                <input type="text" id="referral" name="referral" value=""
                                    placeholder="masukkan referral">
                            </div>
                        </div>
                        <div class="listplayerinfo">
                            <label for="bank">bank</label>
                            <select id="divisi" name="divisi">
                                <option value="" class="pilihbank">Pilih Bank</option>
                                <option value="bri">bri</option>
                                <option value="bca">bca</option>
                                <option value="bca digital">bca digital</option>
                                <option value="sakuku">sakuku</option>
                                <option value="bni">bni</option>
                                <option value="mandiri">mandiri</option>
                                <option value="permata">permata</option>
                                <option value="panin">panin</option>
                                <option value="danamon">danamon</option>
                                <option value="cimb niaga">cimb niaga</option>
                                <option value="bsi">bsi</option>
                                <option value="maybank">maybank</option>
                                <option value="bank jenius">bank jenius</option>
                                <option value="bank jago">bank jago</option>
                                <option value="seabank">seabank</option>
                                <option value="dana">dana</option>
                                <option value="ovo">ovo</option>
                                <option value="gopay">gopay</option>
                                <option value="linkaja">linkaja</option>
                                <option value="shopeepay">shopeepay</option>
                                <option value="bank kalbar">bank kalbar</option>
                                <option value="bank bpd aceh">bank bpd aceh</option>
                                <option value="bank btn">bank btn</option>
                                <option value="allobank">allobank</option>
                                <option value="bank btpn">bank btpn</option>
                                <option value="bpd kalteng">bpd kalteng</option>
                                <option value="keb hana">keb hana</option>
                                <option value="shinhan bank">shinhan bank</option>
                                <option value="arta graha">arta graha</option>
                                <option value="bank aceh">bank aceh</option>
                                <option value="bank bjb">bank bjb</option>
                                <option value="bank papua">bank papua</option>
                                <option value="bank kalsel">bank kalsel</option>
                                <option value="bpd kaltim">bpd kaltim</option>
                                <option value="bank aladin">bank aladin</option>
                                <option value="bank aladin syariah">bank aladin syariah</option>
                                <option value="bank bpdm ambon">bank bpdm ambon</option>
                                <option value="bank bukopin">bank bukopin</option>
                                <option value="bank raya">bank raya</option>
                                <option value="sumsel babel">sumsel babel</option>
                                <option value="bank kalsel">bank kalsel</option>
                                <option value="ABA Bank">ABA Bank</option>
                                <option value="canadia bank">canadia bank</option>
                                <option value="phillip bank">phillip bank</option>
                                <option value="wing bank">wing bank</option>
                            </select>
                        </div>
                        <div class="listplayerinfo">
                            <label for="namarek">namarek</label>
                            <div class="groupeditinput">
                                <input type="text" id="namarek" name="namarek" value=""
                                    placeholder="masukkan namarek">
                            </div>
                        </div>
                        <div class="listplayerinfo">
                            <label for="norek">norek</label>
                            <div class="groupeditinput">
                                <input type="text" id="norek" name="norek" value=""
                                    placeholder="masukkan norek">
                            </div>
                        </div>



                    </div>
                    <div class="listgroupplayerinfo right solo">
                        <button class="tombol primary">
                            <span class="texttombol">SAVE DATA</span>
                        </button>
                    </div>
                </form>
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

        //open jendela detail
        $(document).ready(function() {
            $(".openviewport").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 700;
                var windowHeight = $(window).height() * 0.6;
                var windowLeft = ($(window).width() - windowWidth) / 2.3;
                var windowTop = ($(window).height() - windowHeight) / 1.5;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" +
                    windowLeft + ", top=" + windowTop);
            });
        });

        // print text status
        $(document).ready(function() {
            $('.statusagent').each(function() {
                var statusValue = $(this).attr('data-status');
                switch (statusValue) {
                    case '1':
                        $(this).text('Active');
                        break;
                    case '2':
                        $(this).text('Non-active');
                        break;
                    case '3':
                        $(this).text('Suspend');
                        break;
                    default:
                        break;
                }
            });
        });

        //show password
        $(document).ready(function() {
            $('.listplayerinfo svg').click(function() {
                var inputField = $(this).siblings('input');
                if (inputField.attr('type') === 'password') {
                    inputField.attr('type', 'text');
                    $(this).html(
                        '<path fill="currentColor" d="M2 5.27L3.28 4L20 20.72L18.73 22l-3.08-3.08c-1.15.38-2.37.58-3.65.58c-5 0-9.27-3.11-11-7.5c.69-1.76 1.79-3.31 3.19-4.54zM12 9a3 3 0 0 1 3 3a3 3 0 0 1-.17 1L11 9.17A3 3 0 0 1 12 9m0-4.5c5 0 9.27 3.11 11 7.5a11.8 11.8 0 0 1-4 5.19l-1.42-1.43A9.86 9.86 0 0 0 20.82 12A9.82 9.82 0 0 0 12 6.5c-1.09 0-2.16.18-3.16.5L7.3 5.47c1.44-.62 3.03-.97 4.7-.97M3.18 12A9.82 9.82 0 0 0 12 17.5c.69 0 1.37-.07 2-.21L11.72 15A3.064 3.064 0 0 1 9 12.28L5.6 8.87c-.99.85-1.82 1.91-2.42 3.13"/>'
                    );
                } else {
                    inputField.attr('type', 'password');
                    $(this).html(
                        '<path fill="currentColor" d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0"/>'
                    );
                }
            });
        });

        $(document).ready(function() {
            $('#form-agentds').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting normally

                var password = $('#password').val();
                var repassword = $('#repassword').val();

                if (password !== repassword) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Password dan Retypepassword harus sama',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    this.submit(); // If passwords match, submit the form
                }
            });
        });
    </script>
@endsection
