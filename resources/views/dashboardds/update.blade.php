@extends('layouts.index')

@section('container')
    <div class="sec_box hgi-100">
        <form action="/dashboardds/update" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            @foreach ($data as $index => $item)
                <div class="sec_form">
                    <div class="sec_head_form">
                        <h3>{{ $title }}</h3>
                        <span>Edit {{ $title }}</span>
                        <input type="hidden" name="id[]" value="{{ $item->id }}" {{ $disabled }}>
                    </div>
                    <div class="list_form">
                        <span class="sec_label">Nama</span>
                        <input type="text" id="nama" name="nama[]" placeholder="Masukkan Nama" {{ $disabled }}
                            value="{{ $item->nama }}" required>
                    </div>

                </div>
            @endforeach
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="Contactsubmit" {{ $disabled }}>Submit</button>
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
                $('[name="password[]"]').each(function(index) {
                    var password = $(this).val();
                    var cpassword = $('[name="cpassword[]"]').eq(index).val();

                    if (password !== cpassword) {
                        valid = false;
                        alert('Password dan Konfirmasi Password tidak sama');
                        return false;
                    }
                });

                // Validasi PIN
                $('[name="pin[]"]').each(function(index) {
                    var pin = $(this).val();
                    var cpin = $('[name="cpin[]"]').eq(index).val();

                    if (pin !== cpin) {
                        valid = false;
                        alert('PIN dan Konfirmasi PIN tidak sama');
                        return false;
                    }
                });

                if (!valid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
