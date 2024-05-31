@extends('layouts.index')

@section('container')
    <div class="sec_box hgi-100">
        <form action="/manual/add" method="POST" enctype="multipart/form-data" id="form">
            @csrf

            <div class="sec_form">
                <div class="sec_head_form">
                    <h3>{{ $title }}</h3>
                    <span>DEPO / WD</span>
                </div>
                <div class="list_form">
                    <span class="sec_label">Username</span>
                    <input type="text" id="username" name="username" placeholder="Masukkan Username" required>
                </div>
                <div class="list_form">
                    <span class="sec_label">Jenis</span>
                    <select id="jenis" name="jenis">
                        <option value="DPM" {{ $jenis == 'DPM' ? 'selected' : '' }}>Deposit</option>
                        <option value="WDM" {{ $jenis == 'WDM' ? 'selected' : '' }}>Withdrawal</option>
                    </select>
                </div>
                <div class="list_form">
                    <span class="sec_label">Amount</span>
                    <input type="number" id="amount" name="amount" placeholder="0" min=0>
                </div>
                <div class="list_form">
                    <span class="sec_label">Keterangan</span>
                    <textarea name="keterangan" id="keterangan" cols="30" rows="1" placeholder="Masukkan Keterangan"></textarea>
                </div>
            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="Contactsubmit">Process</button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            var errorCode = "{{ $errorCode }}";
            var message = "{{ $message }}";
            if (errorCode == 200) {
                Swal.fire({
                    icon: 'success',
                    title: message,
                    showConfirmButton: false,
                    timer: 1500
                });
            } else if (errorCode == 500) {
                Swal.fire({
                    icon: 'error',
                    title: message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    </script>
@endsection
