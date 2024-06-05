@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>

        </div>
        <div class="secagentds">
            <div class="groupsecagentds">
                <span class="titlebankmaster">Tambah member seamless</span>
                <form method="POST" action="/memberlistds/store" id="form-agentds" class="groupplayerinfo">
                    @csrf
                    <div class="listgroupplayerinfo left">
                        <div class="listplayerinfo">
                            <label for="username">username</label>
                            <div class="groupeditinput">
                                <input type="text" id="username" name="username" value=""
                                    placeholder="masukkan username" required>
                            </div>
                        </div>
                    </div>
                    <div class="listgroupplayerinfo right solo">
                        <button class="tombol primary">
                            <span class="texttombol">CREATE DATA</span>
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
