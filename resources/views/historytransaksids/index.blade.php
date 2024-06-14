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
            <div class="grouphistoryds">
                <div class="groupheadhistoryds">
                    <form id="searchForm" method="GET" action="/historytransaksids"
                        class="listmembergroup historytransds">
                        <div class="listinputmember">
                            <label for="username">username<span class="required">*</span></label>
                            <input type="text" id="username" name="username" placeholder="username"
                                value="{{ request('username') }}" required>
                        </div>
                        <div class="listinputmember">
                            <label for="invoice">
                                periode/invoice
                                <div class="check_box">
                                    <input type="checkbox" id="checkinvoice" name="checkinvoice"
                                        {{ request('checkinvoice') == 'on' ? 'checked' : '' }}>
                                </div>
                            </label>
                            <input type="text" id="invoice" name="invoice" placeholder="invoice"
                                value="{{ request('invoice') }}">
                        </div>
                        <div class="listinputmember">
                            <label for="status">
                                status
                                <div class="check_box">
                                    <input type="checkbox" id="checkstatus" name="checkstatus"
                                        {{ request('checkstatus') == 'on' ? 'checked' : '' }}>
                                </div>
                            </label>
                            <select name="status" id="status">
                                <option value="" selected="" place=""
                                    style="color: #838383; font-style: italic;" disabled="">Status</option>
                                <option value="deposit" {{ request('status') == 'deposit' ? 'selected' : '' }}>deposit
                                </option>
                                <option value="withdraw" {{ request('status') == 'withdraw' ? 'selected' : '' }}>withdraw
                                </option>
                                <option value="manual" {{ request('status') == 'manual' ? 'selected' : '' }}>manual</option>
                                <option value="pemasangan" {{ request('status') == 'pemasangan' ? 'selected' : '' }}>
                                    pemasangan
                                </option>
                                <option value="menang" {{ request('status') == 'menang' ? 'selected' : '' }}>menang</option>
                                <option value="referral" {{ request('status') == 'referral' ? 'selected' : '' }}>referral
                                </option>
                            </select>
                        </div>
                        <div class="listinputmember">
                            <label for="transdari">
                                transaksi dari
                                <div class="check_box">
                                    <input type="checkbox" id="checktransdari" name="checktransdari"
                                        {{ request('checktransdari') == 'on' ? 'checked' : '' }}>
                                </div>
                            </label>
                            <input type="datetime-local" id="transdari" name="transdari"
                                value="{{ request('transdari') }}">
                        </div>
                        <div class="listinputmember">
                            <label for="transhingga">
                                transaksi hingga
                                <div class="check_box">
                                    <input type="checkbox" id="checktranshingga" name="checktranshingga"
                                        {{ request('checktranshingga') == 'on' ? 'checked' : '' }}>
                                </div>
                            </label>
                            <input type="datetime-local" id="transhingga" name="transhingga"
                                value="{{ request('transhingga') }}">
                        </div>
                        <div class="listinputmember">
                            <label for="transdari">
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
                        <div class="exportdata">
                            <span class="textdownload">download</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                            </svg>
                        </div>
                    </form>
                    <div class="groupmaksimaldata">
                        <span class="textmaksimaldata">Data yang di tampilkan adalah data <span class="dataterakhir">5
                                minggu terakhir</span>, </span>
                        <a href="/historytransaksids/transaksilama" {{-- <a href="/historytransaksids/transaksilama{{ $query != '' ? '?' . $query : '' }}" --}}
                            class="transaksilama tombol primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m22.69 18.37l1.14-1l-1-1.73l-1.45.49c-.32-.27-.68-.48-1.08-.63L20 14h-2l-.3 1.49c-.4.15-.76.36-1.08.63l-1.45-.49l-1 1.73l1.14 1c-.08.5-.08.76 0 1.26l-1.14 1l1 1.73l1.45-.49c.32.27.68.48 1.08.63L18 24h2l.3-1.49c.4-.15.76-.36 1.08-.63l1.45.49l1-1.73l-1.14-1c.08-.51.08-.77 0-1.27M19 21c-1.1 0-2-.9-2-2s.9-2 2-2s2 .9 2 2s-.9 2-2 2M11 7v5.41l2.36 2.36l1.04-1.79l-1.4-1.39V7zm10 5a9 9 0 0 0-9-9C9.17 3 6.65 4.32 5 6.36V4H3v6h6V8H6.26A7.01 7.01 0 0 1 12 5c3.86 0 7 3.14 7 7zm-10.14 6.91c-2.99-.49-5.35-2.9-5.78-5.91H3.06c.5 4.5 4.31 8 8.94 8h.07z" />
                            </svg>
                            Lihat Transaksi Lama
                        </a>
                    </div>
                </div>
                <div class="tabelproses">
                    <table>
                        <tbody>
                            <tr class="hdtable">
                                <th class="bagno">#</th>
                                <th class="bagperiode">periode / invoice</th>
                                <th class="bagtanggal">tanggal</th>
                                <th class="bagketdetail">keterangan</th>
                                <th class="statustrans">status</th>
                                <th class="bagnominalhs">debit (IDR)</th>
                                <th class="bagnominalhs">credit (IDR)</th>
                                <th class="bagnominalhs">balance (IDR)</th>
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
                                    <td class="refnodetail">{{ $d->refno }}</td>
                                    <td>{{ $d->created_at }}</td>
                                    <td>
                                        @if ($d->status == 'menang' || $d->status == 'pemasangan' || $d->status == 'cashout')
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

                    <div class="grouppagination" style="padding: 25px;">
                        @if ($data !== [])
                            {{ $data->links('vendor.pagination.customdashboard') }}
                        @endif
                    </div>

                    {{-- <div class="grouppagination">
                        <div class="grouppaginationcc">
                            <div class="trigger left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <g fill="none" fill-rule="evenodd">
                                        <path
                                            d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                        <path fill="currentColor"
                                            d="M7.94 13.06a1.5 1.5 0 0 1 0-2.12l5.656-5.658a1.5 1.5 0 1 1 2.121 2.122L11.122 12l4.596 4.596a1.5 1.5 0 1 1-2.12 2.122l-5.66-5.658Z" />
                                    </g>
                                </svg>
                            </div>
                            <div class="trigger right">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <g fill="none" fill-rule="evenodd">
                                        <path
                                            d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                        <path fill="currentColor"
                                            d="M16.06 10.94a1.5 1.5 0 0 1 0 2.12l-5.656 5.658a1.5 1.5 0 1 1-2.121-2.122L12.879 12L8.283 7.404a1.5 1.5 0 0 1 2.12-2.122l5.658 5.657Z" />
                                    </g>
                                </svg>
                            </div>
                            <span class="numberpage active">1</span>
                            <span class="numberpage">2</span>
                            <span class="numberpage">3</span>
                            <span class="numberpage">4</span>
                            <span class="numberpage">5</span>
                            <span class="numberpage">...</span>
                            <span class="numberpage">12</span>
                        </div>
                    </div> --}}
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

        //format nominal
        $(document).ready(function() {
            $(".nominal").each(function() {
                var nominal = $(this).attr("data-value");
                var formattedNominal = parseFloat(nominal).toLocaleString('en', {
                    maximumFractionDigits: 2
                });
                $(this).text(formattedNominal);
            });
        });

        //open jendela detail
        $(document).ready(function() {
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
        });

        // print data status
        $(document).ready(function() {
            $('.statusketerangan').each(function() {
                var status = $(this).data('status');
                $(this).find('.statustransaksi').text(status);
            });
        });

        document.getElementById('searchForm').addEventListener('submit', function(event) {
            const inputs = [
                'username',
                'invoice',
                'status',
                'transdari',
                'transhingga',
                'checkinvoice',
                'checkstatus',
                'checktransdari',
                'checktranshingga',
                'checkall',
            ];
            inputs.forEach(id => {
                const inputElement = document.getElementById(id);
                if (!inputElement.value) {
                    inputElement.disabled = true; // Untuk disabled input kalau tidak ada filter :D
                }
            });
        });

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

                    var username = $('#username').val();

                    var checkinvoice = $('#checkinvoice').val();
                    var invoice = $('#invoice').val();

                    var checkstatus = $('#checkstatus').val();
                    var status = $('#status').val();

                    var checktransdari = $('#checktransdari').val();
                    var transdari = $('#transdari').val();

                    var checktranshingga = $('#checktranshingga').val();
                    var transhingga = $('#transhingga').val();

                    var checkall = $('#checkall').val();

                    // Membuat URL dengan parameter dinamis
                    var url = '/historytransaksids/export?username=' + encodeURIComponent(username) +
                        '&checkinvoice=' + encodeURIComponent(checkinvoice) +
                        '&invoice=' + encodeURIComponent(invoice) +
                        '&checkstatus=' + encodeURIComponent(checkstatus) +
                        '&status=' + encodeURIComponent(status) +
                        '&checktransdari=' + encodeURIComponent(checktransdari) +
                        '&transdari=' + encodeURIComponent(transdari) +
                        '&checktranshingga=' + encodeURIComponent(checktranshingga) +
                        '&transhingga=' + encodeURIComponent(transhingga) +
                        '&checkall=' + encodeURIComponent(checkall);

                    window.location.href = url;
                }
            });
        });
    </script>
@endsection
