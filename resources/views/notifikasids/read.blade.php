@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle notifds">
            <h2>{{ $title }} </h2>
            <div class="kembali">
                <a href="/notifikasids">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                        <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4" d="M44 40.836c-4.893-5.973-9.238-9.362-13.036-10.168c-3.797-.805-7.412-.927-10.846-.365V41L4 23.545L20.118 7v10.167c6.349.05 11.746 2.328 16.192 6.833c4.445 4.505 7.009 10.117 7.69 16.836Z" clip-rule="evenodd" />
                    </svg>
                    <span class="textkembali">Kembali</span>
                </a>
            </div>
        </div>
        <div class="secnotifikasids">
            <div class="groupsecnotifikasids">
                <div class="datainbox">
                    <div class="detailfeedback">
                        <div class="listdetailfeedback">
                            <div class="labeldetail">pengirim</div>
                            <span class="gap">:</span>
                            <div class="valuedetail">TEAM IT</div>
                        </div>
                        <div class="listdetailfeedback">
                            <div class="labeldetail">tanggal message</div>
                            <span class="gap">:</span>
                            <div class="valuedetail">2024-04-03 13:29:37</div>
                        </div>
                        <div class="listdetailfeedback">
                            <div class="labeldetail">subject</div>
                            <span class="gap">:</span>
                            <div class="valuedetail">INFORMASI UPDATE</div>
                        </div>
                        <div class="listdetailfeedback top">
                            <div class="labeldetail">memo</div>
                            <span class="gap">:</span>
                            <div class="valuedetail">
                                <p style="white-space: pre-line">📢 Pengumuman Penting: Update Informasi 📢

                                    Halo semua,

                                    Kami ingin memberikan pengumuman penting terkait dengan pembaruan informasi terbaru. Adapun rincian pembaruan tersebut adalah sebagai berikut:

                                    Jadwal Acara: Terjadi perubahan pada jadwal acara yang sebelumnya telah diumumkan. Mohon untuk memperhatikan jadwal yang baru yang telah kami publikasikan.
                                    Pembayaran Tagihan: Untuk memudahkan proses pembayaran, kami telah menambahkan opsi pembayaran baru melalui platform online. Silakan kunjungi situs web kami untuk informasi lebih lanjut.
                                    Perubahan Layanan: Beberapa perubahan telah dilakukan dalam layanan kami untuk meningkatkan kualitas dan kenyamanan pengguna. Mohon untuk membaca panduan yang telah kami sediakan agar dapat mengakses layanan dengan lancar.
                                    Kontak Darurat: Kami telah memperbarui daftar kontak darurat untuk memastikan respons yang cepat dan efisien dalam situasi darurat. Harap simpan nomor-nomor tersebut dengan baik.
                                    Mohon untuk selalu memperhatikan pembaruan informasi terbaru yang kami berikan. Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi tim kami melalui kontak yang telah tersedia.

                                    Terima kasih atas perhatiannya.

                                    Hormat kami,
                                    [Tim Manajemen]
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#myCheckbox').change(function() {
                var isChecked = $(this).is(':checked');

                $('tbody tr:not([style="display: none;"]) [id^="myCheckbox-"]').prop('checked', isChecked);
            });
        });

        $(document).ready(function() {
            $('#myCheckbox, [id^="myCheckbox-"]').change(function() {
                var isChecked = $('#myCheckbox:checked, [id^="myCheckbox-"]:checked').length > 0;
                if (isChecked) {
                    $('.all_act_butt').css('display', 'flex');
                } else {
                    $('.all_act_butt').hide();
                }
            });

        });

    </script>
@endsection
