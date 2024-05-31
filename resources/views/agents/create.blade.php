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
                    <span class="sec_label">Currency</span>
                    <select id="currency" name="currency">
                        @foreach ($modelCurrency as $detailCurrency)
                            <option value="{{ $detailCurrency->currency }}">{{ $detailCurrency->currency }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="list_form">
                    <span class="sec_label">Min</span>
                    <input type="number" id="min" name="min" min="0" placeholder="0" value=1 required>
                </div>
                <div class="list_form">
                    <span class="sec_label">Max</span>
                    <input type="number" id="max" name="max" min="0" placeholder="0" value=5000 required>
                </div>
                <div class="list_form">
                    <span class="sec_label">Max Per Match</span>
                    <input type="number" id="maxpermatch" name="maxpermatch" min="0" placeholder="0" value=20000
                        required>
                </div>
                <div class="list_form">
                    <span class="sec_label">Casino Table Limit</span>
                    <input type="number" id="casinotablelimit" name="casinotablelimit" min="0" placeholder="0"
                        value=1 required>
                </div>
                <div class="list_form">
                    <span class="sec_label">Company Key</span>
                    <select id="companykey" name="companykey">
                        @foreach ($modelCompany as $detailCompany)
                            <option value="{{ $detailCompany->companykey }}">{{ $detailCompany->companykey }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="list_form">
                    <span class="sec_label">Server Id</span>
                    <input type="text" id="serverid" name="serverid" min="0" placeholder="Masukkan Server Id"
                        value="YY-TEST" required>
                </div>

            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="Contactsubmit">Submit</button>
                <a href="/agents" id="cancel"><button type="button" class="sec_botton btn_cancel">Cancel</button></a>
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
                url: "/agents/store",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(result) {
                    $('.alert-danger').hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Agent berhasil dikirim!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        $('.aplay_code').load('/agents', function() {
                            adjustElementSize();
                            localStorage.setItem('lastPage',
                                '/agents');
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
            $('.aplay_code').load('/agents', function() {
                adjustElementSize();
                localStorage.setItem('lastPage', '/agents');
            });
        });
    });
</script>
