@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <h2>{{ $title }}</h2>
        <div class="group_act_butt">
            <div class="group_act_butt">
                <a href="/history">
                    <div class="sec_addnew">
                        <span>ALL TRANSACTION</span>
                    </div>
                </a>

                <a href="/history/DP">
                    <div class="sec_addnew">
                        <span>HISTORY DEPOSIT</span>
                    </div>
                </a>

                <a href="/history/WD">
                    <div class="sec_addnew">
                        <span>HISTORY WITHDRAW</span>
                    </div>
                </a>

                <a href="/history/M">
                    <div class="sec_addnew">
                        <span>HISTORY MANUAL</span>
                    </div>
                </a>

            </div>
        </div>
        <div class="group_act_butt">
            <form action="{{ route('history') }}" method="GET">
                @csrf
                <div class="form-group">
                    <input type="text" name="search_username" class="form-control" placeholder="User ID"
                        value="{{ $username }}">
                </div>

                <div class="form-group">
                    <select name="search_agent" class="form-control">
                        <option value="">All Agent</option>
                        <option value="adminl21" {{ $tipe == 'adminl21' ? 'selected' : '' }}>Agent 01</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="date" name="search_tgl_dari" class="form-control"
                        value="{{ $tgldari == '' ? date('Y-m-d') : $tgldari }}">
                </div>
                <div class="form-group">
                    <input type="date" name="search_tgl_sampai" class="form-control"
                        value="{{ $tglsampai == '' ? date('Y-m-d') : $tglsampai }}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <table>
            <tbody>
                <tr class="head_table">
                    <th>Jenis</th>
                    <th>Username</th>
                    <th>Bank</th>
                    <th>Nama Rek</th>
                    <th>No.Rek</th>
                    <th>Ket</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Approved By</th>
                    {{-- <th>Action</th> --}}
                </tr>

                @foreach ($data as $index => $d)
                    <tr>
                        <td><span class="name">
                                @php
                                    if ($d->jenis === 'DP') {
                                        echo '<h3>Deposit</h3>';
                                    } elseif ($d->jenis === 'WD') {
                                        echo '<h3>Withdrawal</h3>';
                                    } elseif ($d->jenis === 'DPM') {
                                        echo '<h3>Manual Deposit</h3>';
                                    } elseif ($d->jenis === 'WDM') {
                                        echo '<h3>Manual Withdrawal</h3>';
                                    }
                                @endphp
                            </span></td>
                        <td><span class="name">{{ $d->username }}</span></td>
                        <td><span class="name">{{ $d->mbank == '' ? '-' : $d->mbank }}</span></td>
                        <td><span class="name">{{ $d->mnamarek == '' ? '-' : $d->mnamarek }}</span></td>
                        <td><span class="name">{{ $d->mnorek == '' ? '-' : $d->mnorek }}</span></td>
                        <td><span class="name">{{ $d->keterangan == '' ? '-' : $d->keterangan }}</span></td>
                        <td><span class="name">
                                @php
                                    if ($d->status === 0) {
                                        echo '<button class="sec_botton btn_secondary" onclick="salinTeks("voucher24837_AOtx8urR5r")">WAITING</button>';
                                    } elseif ($d->status === 1) {
                                        echo '<button class="sec_botton btn_success" onclick="salinTeks("voucher24837_AOtx8urR5r")">ACCEPT</button>';
                                    } else {
                                        echo '<button class="sec_botton btn_danger" onclick="salinTeks("voucher24837_AOtx8urR5r")">CANCEL</button>';
                                    }
                                @endphp</span></td>

                        <td><span class="name">{{ number_format($d->amount, 3, ',', '.') }}</span></td>
                        <td><span class="name">
                                {{ $d->approved_by == '' ? '-' : $d->approved_by }}</br>
                                ({{ date('d-m-Y H:i:s', strtotime($d->updated_at)) }})
                            </span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        // $(document).ready(function() {
        //     $('.add-generatevoucher').click(function(event) {
        //         event.preventDefault();
        //         var jenis = $(this).data('jenis');
        //         var currentURL = new URL(window.location.href);
        //         var newURL = currentURL.origin + currentURL
        //             .pathname; // Mengambil origin dan path URL saat ini

        //         if (jenis) {
        //             newURL += '?jenis=' + jenis;
        //         }

        //         window.location.href = newURL;
        //     });

        //     $('button[type="submit"]').click(function(event) {
        //         event.preventDefault();
        //         var currentURL = new URL(window.location.href);
        //         var newURL = currentURL.origin + currentURL
        //             .pathname; // Mengambil origin dan path URL saat ini
        //         var jenis = currentURL.searchParams.get("jenis");
        //         var searchTipe = $('select[name="search_tipe"]').val();

        //         if (jenis) {
        //             newURL += '?jenis=' + jenis;
        //         }

        //         if (searchTipe) {
        //             if (jenis) {
        //                 newURL += '&';
        //             } else {
        //                 newURL += '?';
        //             }
        //             newURL += 'search_tipe=' + searchTipe;
        //         }

        //         window.location.href = newURL;
        //     });
        // });
    </script>
@endsection
