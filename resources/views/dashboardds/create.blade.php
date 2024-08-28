@extends('layouts.index')

@section('container')
    <div class="sec_box hgi-100">
        <form action="/dashboardds/store" method="POST" enctype="multipart/form-data" id="form">
            @csrf

            <div class="sec_form">
                <div class="sec_head_form">
                    <h3>{{ $title }}</h3>
                    <span>Tambah {{ $title }}</span>
                </div>
                <div class="list_form">
                    <span class="sec_label">Nama</span>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan Nama" required>
                </div>
            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="Contactsubmit">Submit</button>
                <a href="/dashboardds" id="cancel"><button type="button"
                        class="sec_botton btn_cancel">Cancel</button></a>
            </div>
        </form>
    </div>
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan:',
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('#form').on('submit', function(e) {
                var valid = true;
                var password = $('#password').val();
                var cpassword = $('#cpassword').val();
                var pin = $('#pin').val();
                var cpin = $('#cpin').val();

                // Validasi password
                if (password !== cpassword) {
                    valid = false;
                    alert('Password dan Konfirmasi Password tidak sama');
                }

                // Validasi PIN
                if (pin !== cpin) {
                    valid = false;
                    alert('PIN dan Konfirmasi PIN tidak sama');
                }

                if (!valid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
