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
            <div class="grouphistoryds">
                <div class="groupheadhistoryds">
                    <form id="searchForm" method="GET"
                        action="{{ $is_old ? '/historytransaksidsold' : '/historytransaksids' }}"
                        class="listmembergroup historytransds">
                        <!-- Username Input -->
                        <div class="listinputmember">
                            <label for="username">Username<span class="required">*</span></label>
                            <input type="text" id="username" name="username" placeholder="username"
                                value="{{ request('username') }}" required>
                        </div>

                        <!-- Invoice Input -->
                        <div class="listinputmember">
                            <label for="invoice">
                                Periode/Invoice
                                <div class="check_box">
                                    <input type="checkbox" id="checkinvoice" name="checkinvoice"
                                        {{ request('checkinvoice') == 'on' ? 'checked' : '' }}>
                                </div>
                            </label>
                            <input type="text" id="invoice" name="invoice" placeholder="invoice"
                                value="{{ request('invoice') }}">
                        </div>

                        <!-- Status Select -->
                        <div class="listinputmember">
                            <label for="status">
                                Status
                                <div class="check_box">
                                    <input type="checkbox" id="checkstatus" name="checkstatus"
                                        {{ request('checkstatus') == 'on' ? 'checked' : '' }}>
                                </div>
                            </label>
                            <select name="status" id="status">
                                <option value="" disabled selected style="color: #838383; font-style: italic;">Status
                                </option>
                                <option value="deposit" {{ request('status') == 'deposit' ? 'selected' : '' }}>Deposit
                                </option>
                                <option value="withdraw" {{ request('status') == 'withdraw' ? 'selected' : '' }}>Withdraw
                                </option>
                                <option value="manual" {{ request('status') == 'manual' ? 'selected' : '' }}>Manual</option>
                                <option value="pemasangan" {{ request('status') == 'pemasangan' ? 'selected' : '' }}>
                                    Pemasangan</option>
                                <option value="menang" {{ request('status') == 'menang' ? 'selected' : '' }}>Menang
                                </option>
                                <option value="referral" {{ request('status') == 'referral' ? 'selected' : '' }}>Referral
                                </option>
                            </select>
                        </div>

                        <!-- Date Inputs -->
                        <div class="listinputmember">
                            <label for="transdari">
                                Transaksi Dari
                                <div class="check_box">
                                    <input type="checkbox" id="checktransdari" name="checktransdari"
                                        {{ request('checktransdari') == 'on' ? 'checked' : '' }}>
                                </div>
                            </label>
                            <input type="datetime-local" id="transdari" name="transdari" value="{{ $transdari }}">
                        </div>

                        <div class="listinputmember">
                            <label for="transhingga">
                                Transaksi Hingga
                                <div class="check_box">
                                    <input type="checkbox" id="checktranshingga" name="checktranshingga"
                                        {{ request('checktranshingga') == 'on' ? 'checked' : '' }}>
                                </div>
                            </label>
                            <input type="datetime-local" id="transhingga" name="transhingga" value="{{ $transhingga }}">
                        </div>

                        <!-- Check All Checkbox -->
                        <div class="listinputmember">
                            <label for="checkall">
                                Check All
                                <div class="check_box">
                                    <input type="checkbox" id="checkall" name="checkall"
                                        {{ request('checkall') == 'on' ? 'checked' : '' }}>
                                </div>
                            </label>
                            <button class="tombol primary">
                                <span class="texttombol">SUBMIT</span>
                            </button>
                        </div>

                        @php
                            $user = auth()->user();
                        @endphp
                        @if($user->divisi === 'superadmin' || $user->divisi === 'Admin Cek')
                        <div class="exportdata">
                            <span class="textdownload">Download</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                            </svg>
                        </div>
                        @endif
                    </form>

                    <!-- Group Maksimal Data -->
                    <div class="groupmaksimaldata">
                        <span class="textmaksimaldata">Data yang di tampilkan adalah data <span
                                class="dataterakhir">{{ $is_old ? 'lebih dari 2 bulan terakhir' : '2 bulan terakhir' }}</span>,</span>
                        <a href="{{ $is_old ? '/historytransaksids' : '/historytransaksidsold' }}"
                            class="transaksilama tombol primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m22.69 18.37l1.14-1l-1-1.73l-1.45.49c-.32-.27-.68-.48-1.08-.63L20 14h-2l-.3 1.49c-.4.15-.76.36-1.08.63l-1.45-.49l-1 1.73l1.14 1c-.08.5-.08.76 0 1.26l-1.14 1l1 1.73l1.45-.49c.32.27.68.48 1.08.63L18 24h2l.3-1.49c.4-.15.76-.36 1.08-.63l1.45.49l1-1.73l-1.14-1c.08-.51.08-.77 0-1.27M19 21c-1.1 0-2-.9-2-2s.9-2 2-2s2 .9 2 2s-.9 2-2 2M11 7v5.41l2.36 2.36l1.04-1.79l-1.4-1.39V7zm10 5a9 9 0 0 0-9-9C9.17 3 6.65 4.32 5 6.36V4H3v6h6V8H6.26A7.01 7.01 0 0 1 12 5c3.86 0 7 3.14 7 7zm-10.14 6.91c-2.99-.49-5.35-2.9-5.78-5.91H3.06c.5 4.5 4.31 8 8.94 8h.07z" />
                            </svg>
                            {{ $is_old ? 'Lihat Transaksi Baru' : 'Lihat Transaksi Lama' }}
                        </a>
                    </div>
                </div>

                <!-- Table -->
                <div class="tabelproses">
                    <table>
                        <tbody>
                            <tr class="hdtable">
                                <th class="bagno">#</th>
                                <th class="bagperiode">Periode / Invoice</th>
                                <th class="bagtanggal">Tanggal</th>
                                <th class="bagketdetail">Keterangan</th>
                                <th class="statustrans">Status</th>
                                <th class="bagnominalhs">Debit (IDR)</th>
                                <th class="bagnominalhs">Credit (IDR)</th>
                                <th class="bagnominalhs">Balance (IDR)</th>
                            </tr>
                            @php
                                if ($data != null) {
                                    $currentPage = $data->currentPage();
                                    $perPage = $data->perPage();
                                    $startNumber = ($currentPage - 1) * $perPage + 1;
                                }
                            @endphp
                            @foreach ($data as $index => $d)
                                <tr class="statusketerangan" data-status="{{ $d->status }}">
                                    <td>
                                        <div class="statusmember">{{ $startNumber + $index }}</div>
                                    </td>
                                    <td class="refnodetail">{{ $d->refno == '' ? $d->invoice : $d->refno }}</td>
                                    <td>{{ $d->created_at }}</td>
                                    <td>
                                        @if (in_array($d->status, ['menang', 'pemasangan', 'cashout', 'rollback', 'cancel']))
                                            <a href="/historygameds/detail/{{ $d->refno }}/{{ $d->portfolio }}"
                                                target="_blank" class="detailbetingan">
                                                <span class="texttypebet sportsType">{{ $d->keterangan }}</span>
                                                <span class="klikdetail"> - <span class="statustransaksi"></span></span>
                                            </a>
                                        @else
                                            {{ $d->keterangan }}
                                        @endif
                                    </td>
                                    <td>{{ $d->status }}</td>
                                    <td class="debit nominal" data-value="{{ $d->debit }}"></td>
                                    <td class="credit nominal" data-value="{{ $d->kredit }}"></td>
                                    <td class="ttlbalance nominal" data-value="{{ $d->balance }}"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="grouppagination" style="padding: 25px;">
                        @if ($data !== [])
                            {{ $data->links('vendor.pagination.customdashboard') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            $('#myCheckbox').change(function() {
                var isChecked = $(this).is(':checked');
                $('tbody tr:not([style="display: none;"]) [id^="myCheckbox-"]').prop('checked', isChecked);
            });

            $('#myCheckbox, [id^="myCheckbox-"]').change(function() {
                var isChecked = $('#myCheckbox:checked, [id^="myCheckbox-"]:checked').length > 0;
                $('.all_act_butt').css('display', isChecked ? 'flex' : 'none');
            });

            // Format nominal
            $(".nominal").each(function() {
                var nominal = $(this).attr("data-value");
                var formattedNominal = parseFloat(nominal).toLocaleString('en', {
                    maximumFractionDigits: 2
                });
                $(this).text(formattedNominal);
            });

            // Open betting details in a new window
            $(".detailbetingan").click(function(event) {
                event.preventDefault();
                var url = $(this).attr("href");
                var windowWidth = 400;
                var windowHeight = $(window).height() * 0.8;
                var windowLeft = ($(window).width() - windowWidth) / 2;
                var windowTop = ($(window).height() - windowHeight) / 2;
                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" +
                    windowLeft + ", top=" + windowTop);
            });

            // Print status in the table
            $('.statusketerangan').each(function() {
                var status = $(this).data('status');
                $(this).find('.statustransaksi').text(status);
            });

            // Export data functionality
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
                        var url = '/historytransaksids/export?';
                        // Append necessary query parameters here...
                        window.location.href = url;
                    }
                });
            });

            var isOld = @json($is_old);
            var today = new Date();
            var boundaryDate;

            if (isOld) {
                boundaryDate = new Date(today.getFullYear(), today.getMonth(), 0); // Last day of the previous month
            } else {
                boundaryDate = new Date(today);
                boundaryDate.setDate(boundaryDate.getDate() - 60); // 60 days before today
            }

            var boundaryDateString = boundaryDate.toISOString().split('T')[0];

            if (isOld) {
                $('#transdari, #transhingga').attr('max', boundaryDateString);
            } else {
                $('#transdari').attr('min', boundaryDateString);
            }

            $('#transdari').change(function() {
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

            $('#transhingga').change(function() {
                var transdari = new Date($('#transdari').val());
                var transhingga = new Date($(this).val());

                if (transhingga < transdari) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Tanggal akhir harus lebih besar atau sama dengan tanggal awal',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $(this).val('');
                }

                if (isOld && transhingga > boundaryDate) {
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
        });

        // Check all checkboxes
        document.addEventListener('DOMContentLoaded', (event) => {
            const checkAll = document.getElementById('checkall');
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#checkall)');

            checkAll.addEventListener('change', (e) => {
                const isChecked = e.target.checked;
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = isChecked;
                });
            });
        });
    </script>
@endsection
