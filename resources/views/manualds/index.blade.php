@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }} </h2>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>
        <div class="secmanualds">
            <div class="groupsecmanualds">
                <form action="/manual/add" method="POST" enctype="multipart/form-data" id="form"
                    class="groupformmanual">
                    @csrf
                    <div class="groupform head">
                        <label for="username">username</label>
                        <label for="saldo">saldo sekarang</label>
                        <label for="keterangan">keterangan</label>
                        <label for="jenis">jenis transaksi</label>
                        <label for="nominal">nominal</label>
                        <label for="button"></label>
                    </div>
                    <div class="groupform input">
                        <input type="text" name="username" id="username" placeholder="masukan username" autofocus
                            required>
                        <input type="number" name="saldo" id="saldo" placeholder="-" readonly>
                        <input type="text" name="keterangan" id="keterangan" placeholder="masukan keterangan">
                        <select name="jenis" id="jenis" required>
                            <option value="" selected="" place="" style="color: #838383; font-style: italic;"
                                disabled>Pilih Transaksi</option>
                            <option value="DPM">Deposit Manual</option>
                            <option value="WDM">Withdraw Manual</option>
                        </select>
                        <input type="number" name="amount" id="nominal" placeholder="masukan nominal" required>
                        <button class="tombol proses" type="submit">
                            <span class="texttombol">PROSES</span>
                        </button>
                    </div>
                </form>
                <div class="groupnoted">
                    <div class="listcatatan">
                        <input type="checkbox" id="readCheckbox" name="readCheckbox">
                        <label for="readCheckbox">Pastikan data yang di masukan sudah VALID DAN SESUAI</label>
                    </div>
                    <div class="generatenominal">
                        <span class="textgenerate">Nominal yang akan di proses adalah</span>
                        <span class="nominalproses">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>
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

        $(document).ready(function() {
            $('input[id="nominal"]').on('input', function() {
                var nominal = $(this).val();
                if (nominal === '') {
                    $('.nominalproses').text('Rp 0');
                    return;
                }

                var nominalFloat = parseFloat(nominal.replace(/[^\d.-]/g, ''));
                if (!isNaN(nominalFloat)) {
                    var hasil = nominalFloat * 1000;
                    var hasilFormatted = 'Rp ' + hasil.toLocaleString('id-ID');
                    $('.nominalproses').text(hasilFormatted);
                } else {
                    $('.nominalproses').text('');
                }
            });
        });

        $(document).ready(function() {
            $('#form').on('submit', function(event) {
                // if (!$('#readCheckbox').prop('checked')) {
                //     Swal.fire({
                //         icon: 'warning',
                //         title: 'Anda harus melakukan check "Pastikan data yang dimasukkan sudah VALID DAN SESUAI" terlebih dahulu!',
                //         showConfirmButton: false,
                //         timer: 1500
                //     });
                //     event.preventDefault();
                // }

                let isSubmitted = false;

                $('#form').on('submit', function() {
                    if (isSubmitted) {
                        return false; // Mencegah submit ulang jika sudah disubmit
                    }
                    isSubmitted = true;
                    const submitBtn = $('#submitBtn');
                    submitBtn.prop('disabled', true);
                    submitBtn.find('.texttombol').text(
                        'Processing...'); // Optional: Ubah teks tombol saat sedang diproses
                    return true; // Pastikan form tetap dikirim
                });

                if ($('#jenis').val() == 'WDM') {
                    if (parseFloat($('#saldo').val()) < parseFloat($('#nominal').val())) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Saldo tidak mencukupi',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        event.preventDefault();
                    }
                }



            });
        });

        $('#username').on('blur', function() {
            var username = $(this).val();
            if (username != '') {
                // Swal.fire({
                //     icon: 'info',
                //     title: 'Please wait ...',
                //     text: "Username sedang dalam pengecekan",
                //     showConfirmButton: false,
                //     allowOutsideClick: false
                // });

                $.ajax({
                    url: '/getbalance/' + username,
                    method: 'GET',
                    data: {
                        username: username
                    },
                    success: function(response) {
                        swal.close();
                        $('#saldo').val(response);
                    },
                    error: function(xhr, status, error) {
                        // console.error(xhr.responseText);
                        // swal.close();
                        // Swal.fire({
                        //     icon: 'warning',
                        //     title: 'Username tidak terdaftar',
                        //     showConfirmButton: false,
                        //     timer: 1500
                        // });
                        $('#saldo').val(0);
                    }
                });
            } else {
                $('#saldo').val(0);
            }
        });
    </script>
@endsection
