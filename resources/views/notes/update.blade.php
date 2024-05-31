<div class="sec_box hgi-100">
    <form action="" method="POST" enctype="multipart/form-data" id="form">
        @csrf
        @foreach ($data as $index => $item)
            {{-- <div class="sec_form">
                <div class="sec_head_form">
                    <h3>{{ $title }}</h3>
                    <span>Tambah {{ $title }}</span>
                </div>
                <div class="list_form">
                    <span class="sec_label">Warna Judul</span>
                    <input type="hidden" id="id" name="id" {{ $disabled }} value="{{ $item->id }}">
                    <input type="hidden" id="userid" name="userid" {{ $disabled }} value="{{ $item->userid }}">
                    <select id="warna" name="warna" {{ $disabled }}>
                        <option value="btn_primary" {{ $item->warna == 'btn_primary' ? 'selected' : '' }}>Ungu</option>
                        <option value="btn_secondary" {{ $item->warna == 'btn_secondary' ? 'selected' : '' }}>Biru
                        </option>
                        <option value="btn_success" {{ $item->warna == 'btn_success' ? 'selected' : '' }}>Hijau</option>
                        <option value="btn_danger" {{ $item->warna == 'btn_danger' ? 'selected' : '' }}>Merah</option>
                        <option value="btn_warning" {{ $item->warna == 'btn_warning' ? 'selected' : '' }}>Kuning
                        </option>
                    </select>
                </div>
                <div class="list_form">
                    <span class="sec_label">Judul</span>
                    <input type="text" id="judul" name="judul" required placeholder="Masukkan Judul"
                        value="{{ $item->judul }}" {{ $disabled }}>
                </div>
                <div class="list_form">
                    <span class="sec_label">Isi</span>
                    <textarea name="isi" id="isi" cols="30" rows="3" placeholder="Masukkan Isi" {{ $disabled }}>{{ $item->isi }}</textarea>
                </div>
            </div> --}}
            <div class="sec_form">
                <div class="data_notes" style="width: 100%">
                    <input type="hidden" id="id" name="id" {{ $disabled }} value="{{ $item->id }}">
                    <input type="hidden" id="userid" name="userid" {{ $disabled }} value="{{ $item->userid }}">
                    <select id="warna" name="warna" {{ $disabled }}>
                        <option value="btn_primary" {{ $item->warna == 'btn_primary' ? 'selected' : '' }}>Ungu</option>
                        <option value="btn_secondary" {{ $item->warna == 'btn_secondary' ? 'selected' : '' }}>Biru
                        </option>
                        <option value="btn_success" {{ $item->warna == 'btn_success' ? 'selected' : '' }}>Hijau</option>
                        <option value="btn_danger" {{ $item->warna == 'btn_danger' ? 'selected' : '' }}>Merah</option>
                        <option value="btn_warning" {{ $item->warna == 'btn_warning' ? 'selected' : '' }}>Kuning
                        </option>
                    </select>
                    <h3 class="{{ $item->warna }} headtitle">
                        <textarea name="judul" id="judul" cols="30" rows="1" style="background: transparent; border: 0px;"
                            placeholder="Masukkan Judul Note">{{ $item->judul }}</textarea>
                    </h3>
                    <textarea name="isi" id="isi" cols="30" rows="20" placeholder="Masukkan Isi Note">{{ $item->isi }}</textarea>
                </div>
            </div>
        @endforeach
        <div class="sec_button_form">
            <button class="sec_botton btn_submit" type="submit" id="Contactsubmit" {{ $disabled }}>Submit</button>
            <a href="#" onclick="handleButtonCancelClick(this.id)" id="cancel"><button type="button"
                    class="sec_botton btn_cancel">Cancel</button></a>
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
                url: "/notes/update",
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
                            $('.aplay_code').load('/notes',
                                function() {
                                    adjustElementSize();
                                    localStorage.setItem('lastPage',
                                        '/notes');
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
            $('.aplay_code').load('/notes', function() {
                adjustElementSize();
                localStorage.setItem('lastPage', '/notes');
            });
        });
    });
</script>
