@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">

    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>

        <div class="sechistoryds">
            <div class="grouphistoryds memberlist">
                <form method="GET" action="{{ $is_old ? '/historycoindsold' : '/historycoinds' }}"
                    class="groupheadhistoryds" id="searchForm">
                    <div class="listheadhistoryds top">
                        <input type="hidden" name="jenis" id="jenis" value="{{ request('jenis') }}">
                        <button type="button" class="tombol grey {{ request('jenis') == '' ? 'active' : '' }}"
                            onclick="redirectTo('')">
                            <span class="texttombol">ALL TRANSACTION</span>
                        </button>
                        <button type="button" class="tombol grey {{ request('jenis') == 'DP' ? 'active' : '' }}"
                            onclick="redirectTo('DP')">
                            <span class="texttombol">HISTORY DEPOSIT</span>
                        </button>
                        <button type="button" class="tombol grey {{ request('jenis') == 'WD' ? 'active' : '' }}"
                            onclick="redirectTo('WD')">
                            <span class="texttombol">HISTORY WITHDRAW</span>
                        </button>
                        <button type="button" class="tombol grey {{ request('jenis') == 'M' ? 'active' : '' }}"
                            onclick="redirectTo('M')">
                            <span class="texttombol">HISTORY MANUAL</span>
                        </button>
                    </div>

                    <div class="grouplistheadhistoryds">
                        <div class="listheadhistoryds bottom one">
                            <input type="text" id="username" name="username" placeholder="User ID"
                                value="{{ request('username') }}">
                            <select name="status" id="status">
                                <option value="" style="color: #838383; font-style: italic;">Pilih Status</option>
                                <option value="accept" {{ request('status') == 'accept' ? 'selected' : '' }}>Accepted
                                </option>
                                <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                            <select name="approved_by" id="approved_by">
                                <option value="" style="color: #838383; font-style: italic;">Pilih Agent</option>
                                @foreach ($dataagent as $item)
                                    <option value="{{ $item }}"
                                        {{ request('approved_by') == $item ? 'selected' : '' }}>{{ $item }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @php
                            use Carbon\Carbon;
                            $hariIni = Carbon::now()->format('Y-m-d');
                        @endphp

                        <div class="listheadhistoryds bottom two">
                            <input type="date" id="tgldari" name="tgldari" value="{{ $tgldari }}">
                            <input type="date" id="tglsampai" name="tglsampai" value="{{ $tglsampai }}">
                            <button type="submit" class="tombol primary" id="searchbutton">
                                <span class="texttombol">SUBMIT</span>
                            </button>
                        </div>
                        @php
                            $user = auth()->user()
                        @endphp
                        @if($user->divisi === 'superadmin' || $user->divisi === 'Admin Cek')
                        <div class="exportdata">
                            <span class="textdownload">download</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                </form>

                <div class="groupmaksimaldata">
                    @if ($is_old)
                        <span class="textmaksimaldata">Data yang di tampilkan adalah data <span class="dataterakhir">lebih
                                dari 2 bulan terakhir</span>, </span>
                        <a href="/historycoinds" class="transaksilama tombol primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m22.69 18.37l1.14-1l-1-1.73l-1.45.49c-.32-.27-.68-.48-1.08-.63L20 14h-2l-.3 1.49c-.4.15-.76.36-1.08.63l-1.45-.49l-1 1.73l1.14 1c-.08.5-.08.76 0 1.26l-1.14 1l1 1.73l1.45-.49c.32.27.68.48 1.08.63L18 24h2l.3-1.49c.4-.15.76-.36 1.08-.63l1.45.49l1-1.73l-1.14-1c.08-.51.08-.77 0-1.27M19 21c-1.1 0-2-.9-2-2s.9-2 2-2s2 .9 2 2s-.9 2-2 2M11 7v5.41l2.36 2.36l1.04-1.79l-1.4-1.39V7zm10 5a9 9 0 0 0-9-9C9.17 3 6.65 4.32 5 6.36V4H3v6h6V8H6.26A7.01 7.01 0 0 1 12 5c3.86 0 7 3.14 7 7zm-10.14 6.91c-2.99-.49-5.35-2.9-5.78-5.91H3.06c.5 4.5 4.31 8 8.94 8h.07z" />
                            </svg>
                            Lihat Transaksi Baru
                        </a>
                    @else
                        <span class="textmaksimaldata">Data yang di tampilkan adalah data <span class="dataterakhir">2 bulan
                                terakhir</span>, </span>
                        <a href="/historycoindsold" class="transaksilama tombol primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m22.69 18.37l1.14-1l-1-1.73l-1.45.49c-.32-.27-.68-.48-1.08-.63L20 14h-2l-.3 1.49c-.4.15-.76.36-1.08.63l-1.45-.49l-1 1.73l1.14 1c-.08.5-.08.76 0 1.26l-1.14 1l1 1.73l1.45-.49c.32.27.68.48 1.08.63L18 24h2l.3-1.49c.4-.15.76-.36 1.08-.63l1.45.49l1-1.73l-1.14-1c.08-.51.08-.77 0-1.27M19 21c-1.1 0-2-.9-2-2s.9-2 2-2s2 .9 2 2s-.9 2-2 2M11 7v5.41l2.36 2.36l1.04-1.79l-1.4-1.39V7zm10 5a9 9 0 0 0-9-9C9.17 3 6.65 4.32 5 6.36V4H3v6h6V8H6.26A7.01 7.01 0 0 1 12 5c3.86 0 7 3.14 7 7zm-10.14 6.91c-2.99-.49-5.35-2.9-5.78-5.91H3.06c.5 4.5 4.31 8 8.94 8h.07z" />
                            </svg>
                            Lihat Transaksi Lama
                        </a>
                    @endif
                </div>

                <div class="tabelproses">
                    <table>
                        <tbody>
                            <tr class="hdtable">
                                <th class="bagno">#</th>
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
                                    <td>{{ ($data->currentPage() - 1) * $data->perPage() + 1 + $i }}</td>
                                    <td>{{ $d->username }}</td>
                                    <td class="valuenominal">
                                        <span
                                            class="koinasli {{ in_array($d->jenis, ['withdraw', 'withdraw manual', $d->jenis_temp]) ? 'debit' : '' }}">{{ $d->amount }}</span>
                                        <span class="cointorp"></span>
                                    </td>
                                    <td>{{ strtoupper($d->mbank) }}, {{ strtoupper($d->mnamarek) }},
                                        {{ strtoupper($d->mnorek) }}</td>
                                    <td>{{ $d->approved_by }}</td>
                                    <td class="texttype">{{ $is_old == false ? $d->jenis : $d->jenis_temp }}</td>
                                    <td class="hsjenistrans" data-proses="{{ $d->status == 1 ? 'accept' : 'cancel' }}">
                                        {{ $d->status == 1 ? 'accepted' : 'rejected' }}
                                    </td>
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
            // Cek nilai dari is_old
            var isOld = @json($is_old);

            // Menghitung boundary date sesuai dengan kondisi `is_old`
            var today = new Date();
            var boundaryDate;
            if (isOld) {
                // Jika is_old == true, boundary adalah tanggal terakhir bulan lalu
                boundaryDate = new Date(today.getFullYear(), today.getMonth(), 0); // Hari terakhir bulan sebelumnya
            } else {
                // Jika is_old == false, boundary adalah 60 hari yang lalu
                boundaryDate = new Date(today);
                boundaryDate.setDate(boundaryDate.getDate() - 60);
            }

            // Format boundary date ke 'yyyy-mm-dd'
            var boundaryDateString = boundaryDate.toISOString().split('T')[0];

            // Set atribut min atau max untuk `tgldari` dan `tglsampai` sesuai dengan is_old
            if (isOld) {
                // Jika `isOld` adalah `true`, atur max boundary untuk `tgldari` dan `tglsampai`
                $('#tgldari').attr('max', boundaryDateString);
                $('#tglsampai').attr('max', boundaryDateString);
            } else {
                // Jika `isOld` adalah `false`, atur min boundary untuk `tgldari` saja
                $('#tgldari').attr('min', boundaryDateString);
            }

            // Validasi `tgldari` jika `is_old == false`
            $('#tgldari').change(function() {
                var selectedDate = new Date($(this).val());

                if (!isOld && selectedDate < boundaryDate) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Tanggal awal tidak boleh kurang dari ' + boundaryDate
                            .toLocaleDateString('en-GB'),
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $(this).val(boundaryDateString);
                }
            });

            // Validasi `#tglsampai` agar tidak lebih kecil dari `#tgldari` dan tidak melebihi boundary
            $('#tglsampai').change(function() {
                var tgldari = new Date($('#tgldari').val());
                var tglsampai = new Date($(this).val());

                if (tglsampai < tgldari) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Tanggal akhir harus lebih besar atau sama dengan tanggal awal',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $(this).val('');
                }

                // Jika isOld == true, validasi agar `tglsampai` tidak melebihi boundary
                if (isOld && tglsampai > boundaryDate) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Tanggal akhir tidak boleh lebih dari ' + boundaryDate
                            .toLocaleDateString('en-GB'),
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $(this).val(boundaryDateString);
                }
            });

            // Fungsi checkbox handler dan interaksi lainnya tetap sama
            $('#myCheckbox').change(function() {
                var isChecked = $(this).is(':checked');
                $('tbody tr:not([style="display: none;"]) [id^="myCheckbox-"]').prop('checked', isChecked);
            });

            $('#myCheckbox, [id^="myCheckbox-"]').change(function() {
                var isChecked = $('#myCheckbox:checked, [id^="myCheckbox-"]:checked').length > 0;
                $('.all_act_butt').css('display', isChecked ? 'flex' : 'none');
            });

            $('.koinasli').each(function() {
                var nilaiAsli = parseFloat($(this).text());
                $(this).next('.cointorp').text(formatRupiah(Math.round(nilaiAsli * 1000)));
            });

            function formatRupiah(nilai) {
                return 'Rp' + nilai.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            }

            $('#search_username').keypress(function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    $('#searchbutton').click();
                }
            });

            $('.tombol').click(function() {
                $('.tombol').removeClass('active');
                $(this).addClass('active');
                $('#search_jenis').val($(this).data('jenis') || $('#search_jenis').val());
                $('#from-search').submit();
            });

            $('.exportdata').click(function() {
                Swal.fire({
                    icon: 'question',
                    title: 'Konfirmasi',
                    text: 'Apakah ingin mendownload data ini?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url =
                            `/historycoinds/export?jenis=${encodeURIComponent($('#jenis').val())}&username=${encodeURIComponent($('#username').val())}&status=${encodeURIComponent($('#status').val())}&approved_by=${encodeURIComponent($('#approved_by').val())}&tgldari=${encodeURIComponent($('#tgldari').val())}&tglsampai=${encodeURIComponent($('#tglsampai').val())}&is_old=${@json($is_old)}`;
                        window.location.href = url;
                    }
                });
            });

        });

        function redirectTo(jenis) {
            var params = new URLSearchParams(window.location.search);
            params.set('jenis', jenis);
            window.location.search = params.toString();
        }
    </script>
@endsection
