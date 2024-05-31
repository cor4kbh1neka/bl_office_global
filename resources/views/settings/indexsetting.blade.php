@extends('layouts.index')

@section('container')
    <div class="sec_box hgi-100">
        <form action="" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            <div class="sec_form">
                <div class="sec_head_form">
                    <h3>{{ $title }}</h3>
                    <span>Update {{ $title }}</span>
                </div>
                <div class="list_form">
                    <span class="sec_label">Version</span>
                    <input type="text" id="version" name="version" required placeholder="Masukkan Version"
                        value="{{ $data['version'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Home</span>
                    <input type="text" id="home" name="home" required placeholder="Masukkan Home"
                        value="{{ $data['home'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Deposit</span>
                    <input type="text" id="deposit" name="deposit" required placeholder="Masukkan Deposit"
                        value="{{ $data['deposit'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Server 1</span>
                    <input type="text" id="server1" name="server1" required placeholder="Masukkan Server 1"
                        value="{{ $data['server1'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Server 2</span>
                    <input type="text" id="server2" name="server2" required placeholder="Masukkan Server 2"
                        value="{{ $data['server2'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Server 3</span>
                    <input type="text" id="server3" name="server3" required placeholder="Masukkan Server 3"
                        value="{{ $data['server3'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Update</span>
                    <input type="text" id="update" name="update" required placeholder="Masukkan Update"
                        value="{{ $data['update'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Peraturan</span>
                    <input type="text" id="peraturan" name="peraturan" required placeholder="Masukkan Peraturan"
                        value="{{ $data['peraturan'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Klasemen</span>
                    <input type="text" id="klasemen" name="klasemen" required placeholder="Masukkan Klasemen"
                        value="{{ $data['klasemen'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Promosi</span>
                    <input type="text" id="promosi" name="promosi" required placeholder="Masukkan Promosi"
                        value="{{ $data['promosi'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">LiveScore</span>
                    <input type="text" id="livescore" name="livescore" required placeholder="Masukkan LiveScore"
                        value="{{ $data['livescore'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">LiveChat</span>
                    <input type="text" id="livechat" name="livechat" required placeholder="Masukkan LiveChat"
                        value="{{ $data['livechat'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Whatsapp 1</span>
                    <input type="text" id="whatsapp1" name="whatsapp1" required placeholder="Masukkan Whatsapp 1"
                        value="{{ $data['whatsapp1'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Whatsapp 2</span>
                    <input type="text" id="whatsapp2" name="whatsapp2" required placeholder="Masukkan Whatsapp 2"
                        value="{{ $data['whatsapp2'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Facebook</span>
                    <input type="text" id="facebook" name="facebook" required placeholder="Masukkan Facebook"
                        value="{{ $data['facebook'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Instagram</span>
                    <input type="text" id="instagram" name="instagram" required placeholder="Masukkan Instagram"
                        value="{{ $data['instagram'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Telegram</span>
                    <input type="text" id="telegram" name="telegram" required placeholder="Masukkan Telegram"
                        value="{{ $data['telegram'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Prediksi</span>
                    <input type="text" id="prediksi" name="prediksi" required placeholder="Masukkan Prediksi"
                        value="{{ $data['prediksi'] }}">
                </div>
            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="Contactsubmit">Submit</button>

            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#warna').on('change', function() {
                var selectedValue = $(this).val();
                changeWarna(selectedValue);
            });

            function changeWarna(warna) {
                $('h3.headtitle').removeClass().addClass(warna + ' headtitle');
            }
        });
        $(document).ready(function() {
            $('#form').submit(function(event) {
                event.preventDefault();

                var formData = new FormData(this);
                $('input[type="checkbox"]', this).each(function() {
                    var isChecked = $(this).is(':checked') ? 1 : 0;
                    formData.append($(this).attr('name'), isChecked);
                });

                $.ajax({
                    url: "/settings/update",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(result) {
                        if (result.errors) {
                            $('.alert-danger').html('');

                            $.each(result.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<li>' + value + '</li>');
                            });
                        } else {
                            $('.alert-danger').hide();

                            Swal.fire({
                                icon: 'success',
                                title: 'Contactikasi berhasil dikirim!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                $('.aplay_code').load('/settings',
                                    function() {
                                        adjustElementSize();
                                        localStorage.setItem('lastPage',
                                            '/settings');
                                    });
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan saat mengirim contact.'
                        });

                        console.log(xhr.responseText);
                    }
                });
            });

            $(document).off('click', '#cancel').on('click', '#cancel', function(event) {
                event.preventDefault();
                var namabo = $(this).data('namabo');
                $('.aplay_code').load('/settings', function() {
                    adjustElementSize();
                    localStorage.setItem('lastPage', '/settings');
                });
            });
        });
    </script>
@endsection
