@extends('layouts.index')

@section('container')
    <div class="sec_box hgi-100">
        <form action="" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            @foreach ($data as $index => $item)
                <div class="sec_form">
                    <div class="sec_head_form">
                        <h3>{{ $title }}</h3>
                        <span>Edit {{ $title }}</span>
                        <input type="hidden" name="id[]" value="{{ $item->id }}" {{ $disabled }}>
                    </div>
                    <div class="list_form">
                        <span class="sec_label">IP Address</span>
                        <input type="text" id="ip_address" name="ip_address[]" placeholder="Masukkan IP Address"
                            {{ $disabled }} value={{ $item->ip_address }} required>
                    </div>
                </div>
            @endforeach
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="Contactsubmit" {{ $disabled }}>Submit</button>
                <a href="#" id="cancel"><button type="button" class="sec_botton btn_cancel">Cancel</button></a>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {

            $('#form').submit(function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                var passwordsMatch = true;

                $('input[name^="password"]').each(function(index, element) {
                    var password = $(element).val();
                    var confirmPassword = $('input[name="cpassword[]"]').eq(index).val();

                    if (password !== '' && password !== confirmPassword) {
                        passwordsMatch = false;
                        return false; // Hentikan perulangan jika password tidak cocok
                    }
                });

                if (!passwordsMatch) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Password dan Konfirmasi Password tidak sama !'
                    });
                    return;
                }
                $.ajax({
                    url: "/allowedip/update",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(result) {
                        if (result.errors) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: result.errors
                            });
                        } else {
                            $('.alert-danger').hide();

                            Swal.fire({
                                icon: 'success',
                                title: 'Contactikasi berhasil dikirim!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                $('.aplay_code').load('/allowedip',
                                    function() {
                                        adjustElementSize();
                                        localStorage.setItem('lastPage',
                                            '/allowedip');
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
                $('.aplay_code').load('/allowedip', function() {
                    adjustElementSize();
                    localStorage.setItem('lastPage', '/allowedip');
                });
            });
        });
    </script>
@endsection
