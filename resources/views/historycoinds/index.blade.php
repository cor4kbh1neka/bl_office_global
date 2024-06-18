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
        <div class="sechistoryds">
            <div class="grouphistoryds memberlist">
                <form method="GET" action="/historycoinds" class="groupheadhistoryds" id="searchForm">
                    <div class="listheadhistoryds top">
                        <input type="hidden" name="jenis" id="jenis" value="{{ request('jenis') }}">
                        <button type="button" class="tombol grey {{ request('jenis') == '' ? 'active' : '' }}"
                            id="" name="" onclick="redirectTo('')">
                            <span class="texttombol">ALL TRANSACTION</span>
                        </button>
                        <button type="button" class="tombol grey {{ request('jenis') == 'DP' ? 'active' : '' }}"
                            id="DP" name="DP" onclick="redirectTo('DP')">
                            <span class="texttombol">HISTORY DEPOSIT</span>
                        </button>
                        <button type="button" class="tombol grey {{ request('jenis') == 'WD' ? 'active' : '' }}"
                            id="WD" name="WD" onclick="redirectTo('WD')">
                            <span class="texttombol">HISTORY WITHDRAW</span>
                        </button>
                        <button type="button" class="tombol grey {{ request('jenis') == 'M' ? 'active' : '' }}"
                            id="DPM" name="DPM" onclick="redirectTo('M')">
                            <span class="texttombol">HISTORY MANUAL</span>
                        </button>
                    </div>
                    <div class="grouplistheadhistoryds">
                        <div class="listheadhistoryds bottom one">
                            <input type="text" id="username" name="username" placeholder="User ID"
                                value="{{ request('username') }}">
                            <select name="status" id="status">
                                <option value="" selected="" place=""
                                    style="color: #838383; font-style: italic;">Pilih Status</option>
                                <option value="accept" {{ request('status') == 'accept' ? 'selected' : '' }}>Accepted
                                </option>
                                <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                            <select name="approved_by" id="approved_by">
                                <option value="" selected="" place=""
                                    style="color: #838383; font-style: italic;">Pilih Agent</option>
                                <option value="gl0b4l#21" {{ request('approved_by') == 'gl0b4l#21' ? 'selected' : '' }}>
                                    gl0b4l#21</option>
                            </select>
                        </div>
                        <div class="listheadhistoryds bottom two">
                            @if (request('tgldari') && request('tglsampai') === date('Y-m-d'))
                                <input type="date" id="tgldari" name="tgldari" value="{{ request('tgldari') }}">
                                <input type="date" id="tglsampai" name="tglsampai" value="{{ request('tglsampai') }}">
                            @else
                                <input type="date" id="tgldari" name="tgldari" value="{{ date('Y-m-d') }}">
                                <input type="date" id="tglsampai" name="tglsampai" value="{{ date('Y-m-d') }}">
                            @endif
                            <button type="submit" class="tombol primary" id="searchbutton">
                                <span class="texttombol">SUBMIT</span>
                            </button>
                        </div>
                        <div class="exportdata">
                            <span class="textdownload">download</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                            </svg>
                        </div>
                    </div>
                </form>
                <div class="tabelproses">
                    <table>
                        <tbody>
                            <tr class="hdtable">
                                <th class="bagno">#</th>
                                {{-- <th class="check_box">
                                    <input type="checkbox" id="myCheckbox" name="myCheckbox">
                                </th> --}}
                                <th class="baguser">username</th>
                                <th class="bagnominal">nominal</th>
                                <th class="bagbank">bank</th>
                                <th class="agentdata">agent</th>
                                <th class="typetrans">type transaksi</th>
                                <th class="statustrans">status</th>
                                <th class="bagketerangan">keterangan</th>
                                <th class="bagtanggal">di terima</th>
                                <th class="bagtanggal">di proses</th>
                            </tr>
                            @foreach ($data as $i => $d)
                                <tr>
                                    <td>
                                        <div class="statusmember">
                                            {{ ($data->currentPage() - 1) * $data->perPage() + 1 + $i }}</div>
                                    </td>
                                    {{-- <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                        <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0"
                                            data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                    </td> --}}
                                    <td>{{ $d->username }}</td>
                                    <td class="valuenominal">
                                        <span class="koinasli">{{ $d->amount }}</span>
                                        <span class="cointorp"></span>
                                    </td>
                                    <td>{{ $d->mbank . ', ' . $d->mnamarek . ', ' . $d->mnorek }}</td>
                                    <td>{{ $d->approved_by }}</td>
                                    <td class="texttype">{{ $d->jenis }}</td>
                                    <td class="hsjenistrans" data-proses="{{ $d->status == 1 ? 'accept' : 'cancel' }}">
                                        {{ $d->status == 1 ? 'accepted' : 'rejected' }}</td>
                                    <td>{{ $d->keterangan }}</td>
                                    <td>{{ $d->created_at }}</td>
                                    <td>{{ $d->updated_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="padding: 25px">
                        {{ $data->links('vendor.pagination.customdashboard') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('gagalTarikData'))
        <script>
            Swal.fire({
                text: '{{ session('gagalTarikData') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

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

         // convert nominal
         $(document).ready(function() {
            $('.koinasli').each(function() {
                var nilaiAsli = parseFloat($(this).text());
                var nilaiKonversi = Math.round(nilaiAsli * 1000);
                var nilaiFormat = formatRupiah(nilaiKonversi);
                $(this).next('.cointorp').text(nilaiFormat);
            });

            function formatRupiah(nilai) {
                var bilangan = nilai.toString().replace(/[^,\d]/g, '');
                var bilanganSplit = bilangan.split(',');
                var sisa = bilanganSplit[0].length % 3;
                var rupiah = bilanganSplit[0].substr(0, sisa);
                var ribuan = bilanganSplit[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    var separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = bilanganSplit[1] !== undefined ? rupiah + ',' + bilanganSplit[1] : rupiah;
                return 'Rp' + rupiah;
            }
        });


        $(document).ready(function() {
            $('#search_username').keypress(function(event) {

                if (event.keyCode === 13) {
                    event.preventDefault();
                    $('#searchbutton').click();
                }
            });
        });

        $(document).ready(function() {
            $('.tombol').click(function() {
                var jenis = $('#search_jenis').val();
                $('.tombol').removeClass('active');
                $(this).addClass('active');
                var jenis = typeof $(this).data('jenis') == 'undefined' ? jenis : $(this).data('jenis');
                $('#search_jenis').val(jenis);
                // Submit form
                $('#from-search').submit();
            });
        });

        $(document).ready(function() {
            $('#tglsampai').change(function() {
                var tgldari = new Date($('#tgldari').val());
                var tglsampai = new Date($(this).val());

                if (tglsampai < tgldari) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Tanggal akhir harus lebih besar atau sama dengan tanggal awal',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    $(this).val(''); // Mengosongkan nilai tglsampai jika tidak valid
                }
            });
        });

        $('#tgldari').change(function() {
            var today = new Date();
            var refNo = $('#refNo').val();
            var tgldari = new Date($('#tgldari').val());

            // Menghitung tanggal 60 hari yang lalu
            var maxDate = new Date(today);
            maxDate.setDate(maxDate.getDate() - 60);

            if (refNo == '') {
                if (tgldari < maxDate) {
                    // Format tanggal 60 hari yang lalu menjadi string
                    var maxDateString = maxDate.toLocaleDateString('en-GB');

                    Swal.fire({
                        title: 'Error',
                        text: 'Tanggal awal tidak boleh kurang dari ' + maxDateString,
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    $(this).val('');
                }
            }
        });

        function redirectTo(jenis) {
            var params = new URLSearchParams(window.location.search);
            params.set('jenis', jenis);
            window.location.search = params.toString();
        }

        document.getElementById('searchForm').addEventListener('submit', function(event) {
            const jenisElement = document.getElementById('jenis');
            const inputs = [
                'username',
                'status',
                'approved_by',
                'tgldari',
                'tglsampai',
            ];

            inputs.forEach(id => {
                const inputElement = document.getElementById(id);
                if (!inputElement.value) {
                    inputElement.disabled = true; // Untuk menonaktifkan input jika tidak ada filter
                }
            });

            jenisElement.value = jenisElement.value || ''; // Pastikan jenis tidak kosong
        });

        // $('.exportdata').click(function() {
        //     Swal.fire({
        //         icon: 'question',
        //         title: 'Konfirmasi',
        //         text: 'Apakah ingin mendownload data ini?',
        //         showCancelButton: true,
        //         confirmButtonText: 'Ya',
        //         cancelButtonText: 'Batal',
        //     }).then(function(result) {
        //         if (result.isConfirmed) {
        //             var url = '/historycoinds/export';
        //             window.location.href = url;
        //         }
        //     });
        // });
        $('.exportdata').click(function() {
            Swal.fire({
                icon: 'question',
                title: 'Konfirmasi',
                text: 'Apakah ingin mendownload data ini?',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
            }).then(function(result) {
                if (result.isConfirmed) {
                    // Mendapatkan nilai dari input
                    var jenis = $('#jenis').val(); // Asumsi ada elemen dengan id 'jenis'
                    var username = $('#username').val(); // Asumsi ada elemen dengan id 'username'
                    var status = $('#status').val(); // Asumsi ada elemen dengan id 'status'
                    var approved_by = $('#approved_by').val(); // Asumsi ada elemen dengan id 'approved_by'
                    var tgldari = $('#tgldari').val(); // Asumsi ada elemen dengan id 'tgldari'
                    var tglsampai = $('#tglsampai').val(); // Asumsi ada elemen dengan id 'tglsampai'

                    // Membuat URL dengan parameter dinamis
                    var url = '/historycoinds/export?jenis=' + encodeURIComponent(jenis) +
                        '&username=' + encodeURIComponent(username) +
                        '&status=' + encodeURIComponent(status) +
                        '&approved_by=' + encodeURIComponent(approved_by) +
                        '&tgldari=' + encodeURIComponent(tgldari) +
                        '&tglsampai=' + encodeURIComponent(tglsampai);

                    // Redirect ke URL
                    window.location.href = url;
                }
            });
        });
    </script>
@endsection
