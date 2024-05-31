<div class="sec_box hgi-100">
    <form action="" method="POST" enctype="multipart/form-data" id="form">
        @csrf
        {{-- <div class="sec_form">
            <div class="sec_head_form">
                <h3>{{ $title }}</h3>
                <span>Tambah {{ $title }}</span>
            </div>
            <div class="list_form">
                <span class="sec_label">Warna Judul</span>
                <input type="hidden" id="userid" name="userid" value="{{ auth()->user()->username }}">
                <select id="warna" name="warna">
                    <option value="btn_primary">Ungu</option>
                    <option value="btn_secondary">Biru</option>
                    <option value="btn_success">Hijau</option>
                    <option value="btn_danger">Merah</option>
                    <option value="btn_warning">Kuning</option>
                </select>
            </div>
            <div class="list_form">
                <span class="sec_label">Judul</span>
                <input type="text" id="judul" name="judul" required placeholder="Masukkan Judul">
            </div>
            <div class="list_form">
                <span class="sec_label">Isi</span>
                <textarea name="isi" id="isi" cols="30" rows="3" placeholder="Masukkan Isi"></textarea>
            </div>
        </div> --}}
        <div class="sec_form">
            <div class="data_notes" style="width: 100%">
                <input type="hidden" id="userid" name="userid" value="{{ auth()->user()->username }}">
                <select id="warna" name="warna">
                    <option value="btn_primary">Ungu</option>
                    <option value="btn_secondary" selected="">Biru
                    </option>
                    <option value="btn_success">Hijau</option>
                    <option value="btn_danger">Merah</option>
                    <option value="btn_warning">Kuning
                    </option>
                </select>
                <h3 class="btn_secondary headtitle">
                    <textarea name="judul" id="judul" cols="30" rows="1" style="background: transparent; border: 0px;"
                        placeholder="Masukkan Judul Note"></textarea>
                </h3>
                <textarea name="isi" id="isi" cols="30" rows="20" placeholder="Masukkan Isi Note"></textarea>
            </div>
        </div>
        <div class="sec_button_form">
            <button class="sec_botton btn_submit" type="submit" id="Contactsubmit">Submit</button>
            <a href="#" onclick="handleButtonCancelClick(this.id)" id="cancel"><button type="button"
                    class="sec_botton btn_cancel">Cancel</button></a>
        </div>


    </form>
</div>

<script>
    $(document).ready(function() {
        $('#warna').on('change', function() {
            var selectedValue = $(this).val();
            $('h3.headtitle').removeClass().addClass(selectedValue + ' headtitle');
        });

        $('#form').submit(function(event) {

            event.preventDefault();
            var formData = new FormData(this);

            if ($('#judul').val().trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Judul note tidak boleh kosong!.'
                });
                return;
            }

            if ($('#isi').val().trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Isi note tidak boleh kosong!.'
                });
                return;
            }

            $.ajax({
                url: "/notes/store",
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
