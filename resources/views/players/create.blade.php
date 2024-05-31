@extends('layouts.index')

@section('container')
    <div class="sec_box hgi-100">
        <form action="" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            <div class="sec_form">
                <div class="sec_head_form">
                    <h3>{{ $title }}</h3>
                    <span>Tambah {{ $title }}</span>
                </div>
                <div class="list_form">
                    <span class="sec_label">Username</span>
                    <input type="text" id="username" name="username" placeholder="Masukkan Username" required>
                </div>
                <div class="list_form">
                    <span class="sec_label">Password</span>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                </div>
                <div class="list_form">
                    <span class="sec_label">User Group</span>
                    <input type="text" id="usergroup" name="usergroup" placeholder="Masukkan User Group" value="B"
                        required>
                </div>
                <div class="list_form">
                    <span class="sec_label">Agent</span>
                    <select id="agentid" name="agentid">
                        @foreach ($modelAgent as $detailAgent)
                            <option value="{{ $detailAgent->id }}">{{ $detailAgent->username }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="Contactsubmit">Submit</button>
                <a href="/players" id="cancel"><button type="button" class="sec_botton btn_cancel">Cancel</button></a>
            </div>
        </form>
    </div>
@endsection
<script>
    $(document).ready(function() {
        $('#form').submit(function(event) {
            event.preventDefault();

            var formData = new FormData(this);
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            formData.append('_token', csrfToken);

            $.ajax({
                url: "/players/store",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(result) {
                    console.log(result);
                    $('.alert-danger').hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Agent berhasil dikirim!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        $('.aplay_code').load('/players', function() {
                            adjustElementSize();
                            localStorage.setItem('lastPage',
                                '/players');
                        });
                    });
                },
                error: function(xhr) {
                    var response = JSON.parse(xhr.responseText);
                    var errorMessage = response.errors[0];

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            });

        });

        $(document).off('click', '#cancel').on('click', '#cancel', function(event) {
            event.preventDefault();
            var namabo = $(this).data('namabo');
            $('.aplay_code').load('/players', function() {
                adjustElementSize();
                localStorage.setItem('lastPage', '/players');
            });
        });
    });
</script>
