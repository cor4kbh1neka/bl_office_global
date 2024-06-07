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

        <div class="secmemberlist">
            <div class="grouphistoryds memberlist">
                <form id="searchForm" class="groupheadhistoryds" method="GET" action="/memberlistds">
                    <div class="listmembergroup">
                        <div class="listinputmember">
                            <label for="username">
                                username
                                <div class="check_box">
                                    <input type="checkbox" id="checkusername" name="checkusername"
                                        {{ request('checkusername') == 'on' ? 'checked' : '' }}>
                                </div>
                            </label>
                            <input type="text" id="username" name="username" placeholder="username"
                                value="{{ request('username') }}">
                        </div>
                        <div class="listinputmember">
                            <label for="norek">nomor rekening</label>
                            <input type="text" id="norek" name="norek" placeholder="nomor rekening"
                                value="{{ request('norek') }}">
                        </div>
                        <div class="listinputmember">
                            <label for="namarek">nama rekening</label>
                            <input type="text" id="namarek" name="namarek" placeholder="nama rekening"
                                value="{{ request('namarek') }}">
                        </div>
                        <div class="listinputmember">
                            <label for="bank">bank</label>
                            <select name="bank" id="bank">
                                <option value="" selected="" place=""
                                    style="color: #838383; font-style: italic;">Pilih Bank</option>
                                <option value="BCA" {{ request('bank') == 'BCA' ? 'selected' : '' }}>BCA</option>
                                <option value="BNI" {{ request('bank') == 'BNI' ? 'selected' : '' }}>BNI</option>
                                <option value="BRI" {{ request('bank') == 'BRI' ? 'selected' : '' }}>BRI</option>
                                <option value="BSI" {{ request('bank') == 'BSI' ? 'selected' : '' }}>BSI</option>
                                <option value="CIMB" {{ request('bank') == 'CIMB' ? 'selected' : '' }}>CIMB</option>
                                <option value="DANA" {{ request('bank') == 'DANA' ? 'selected' : '' }}>DANA</option>
                                <option value="DANAMON" {{ request('bank') == 'DANAMON' ? 'selected' : '' }}>DANAMON
                                </option>
                                <option value="GOPAY" {{ request('bank') == 'GOPAY' ? 'selected' : '' }}>GOPAY</option>
                                <option value="LINKAJA" {{ request('bank') == 'LINKAJA' ? 'selected' : '' }}>LINKAJA
                                </option>
                                <option value="MANDIRI" {{ request('bank') == 'MANDIRI' ? 'selected' : '' }}>MANDIRI
                                </option>
                                <option value="OVO" {{ request('bank') == 'OVO' ? 'selected' : '' }}>OVO</option>
                                <option value="PANIN" {{ request('bank') == 'PANIN' ? 'selected' : '' }}>PANIN</option>
                                <option value="PERMATA" {{ request('bank') == 'PERMATA' ? 'selected' : '' }}>PERMATA
                                </option>
                                <option value="PULSA" {{ request('bank') == 'PULSA' ? 'selected' : '' }}>PULSA</option>
                                <option value="QRIS" {{ request('bank') == 'QRIS' ? 'selected' : '' }}>PULSA</option>
                            </select>
                            {{-- <input type="text" id="bank" name="bank" placeholder="bank"
                                value="{{ request('bank') }}"> --}}
                        </div>
                        <div class="listinputmember">
                            <label for="nohp">nomor handphone</label>
                            <input type="text" id="nohp" name="nohp" placeholder="nomor handphone"
                                value="{{ request('nohp') }}">
                        </div>
                    </div>
                    <div class="listmembergroup">
                        <div class="listinputmember">
                            <label for="referral">referral</label>
                            <input type="text" id="referral" name="referral" placeholder="referral"
                                value="{{ request('referral') }}">
                        </div>
                        <div class="listinputmember">
                            <label for="gabungdari">tanggal gabung dari</label>
                            <input type="date" id="gabungdari" name="gabungdari" placeholder="tanggal gabung dari"
                                value="{{ request('gabungdari') }}">
                        </div>
                        <div class="listinputmember">
                            <label for="gabunghingga">tanggal gabung hingga</label>
                            <input type="date" id="gabunghingga" name="gabunghingga" placeholder="tanggal gabung hingga"
                                value="{{ request('gabunghingga') }}">
                        </div>
                        <div class="listinputmember">
                            <label for="status">Status</label>
                            <select name="status" id="status">
                                <option value="" selected="" place=""
                                    style="color: #838383; font-style: italic;">Pilih status</option>
                                <option value="9" {{ request('status') == 9 ? 'selected' : '' }}>new member</option>
                                <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>default</option>
                                <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>VVIP</option>
                                <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>bandar</option>
                                <option value="4" {{ request('status') == 4 ? 'selected' : '' }}>warning</option>
                                <option value="5" {{ request('status') == 5 ? 'selected' : '' }}>suspend</option>
                            </select>
                        </div>
                        <div class="listinputmember">
                            <button class="tombol primary" type="submit">
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
                                <th class="baguser">Username</th>
                                <th class="baguser">referral</th>
                                <th class="bagbank">bank</th>
                                <th class="bagnominal">balance</th>
                                <th class="statusakun">status</th>
                                <th class="bagketerangan">information</th>
                                <th class="bagtanggal">tanggal gabung</th>
                                <th class="bagtanggal">last login</th>
                                <th class="action">tools</th>
                            </tr>
                            @php
                                $currentPage = $data->currentPage();
                                $perPage = $data->perPage();
                                $startNumber = ($currentPage - 1) * $perPage + 1;
                            @endphp
                            @foreach ($data as $index => $d)
                                <tr>
                                    <td>
                                        <span>{{ $startNumber + $index }}</span>
                                    </td>
                                    <td>
                                        <span class="userpending">
                                            {{ $d->username }}
                                            <a href="/memberlistds/winloseyear/{{ $d->username }}"
                                                class="iconprofile detailbetingan" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                    </td>
                                    <td>{{ $d->referral }}</td>
                                    <td>{{ $d->bank }}, {{ $d->namarek }}, {{ $d->norek }}</td>
                                    <td class="valuenominal">
                                        <span class="koinasli">{{ $d->amount }}</span>
                                        <span class="cointorp"></span>
                                    </td>
                                    <td class="hsjenisakun" data-statusakun="{{ $d->status }}"></td>
                                    <td>{{ $d->keterangan }}</td>
                                    <td>{{ $d->created_at }}</td>
                                    <td>{{ $d->lastlogin }}</td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/memberlistds/edit/{{ $d->id }}"
                                                class="tombol grey openviewport" target="_blank">
                                                <span class="texttombol">EDIT</span>
                                            </a>
                                            <a href="/memberlistds/history/{{ $d->username }}"
                                                class="tombol grey openviewport">
                                                <span class="texttombol">HISTORY BANK</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="grouppagination" style="padding: 25px;">
                        {{ $data->links('vendor.pagination.customdashboard') }}
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
                            <span class="numberpage">1</span>
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

    @if (session('success'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 3000
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    timer: 3000
                });
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
            $('.hsjenisakun').each(function() {
                var status = $(this).data('statusakun');
                var text = '';

                switch (status) {
                    case 1:
                        text = 'default';
                        break;
                    case 2:
                        text = 'vvip';
                        break;
                    case 3:
                        text = 'bandar';
                        break;
                    case 4:
                        text = 'warning';
                        break;
                    case 5:
                        text = 'suspend';
                        break;
                    case 9:
                        text = 'new member';
                        break;
                    default:
                        text = 'unknown';
                        break;
                }

                $(this).text(text);
            });
        });

        $(document).ready(function() {
            // Menambahkan kelas active ke nomor halaman saat ini
            var currentPage = getCurrentPageNumber();
            // $(".numberpage").eq(currentPage - 1).addClass("active");

            // $(".numberpage").click(function() {
            //     $(".numberpage").removeClass("active");
            //     $(this).addClass("active");
            //     var pageNumber = $(this).text();
            //     updateUrlWithPage(pageNumber);
            // });

            // $(".trigger.left").click(function() {
            //     var currentPage = getCurrentPageNumber();
            //     var prevPage = currentPage - 1;
            //     if (prevPage >= 1) {
            //         updateUrlWithPage(prevPage);
            //     }
            // });

            // $(".trigger.right").click(function() {
            //     var currentPage = getCurrentPageNumber();
            //     var nextPage = currentPage + 1;
            //     updateUrlWithPage(nextPage);
            // });

            function getCurrentPageNumber() {
                var url = window.location.href;
                var pageNumber = url.match(/[?&]page=(\d+)/);
                return pageNumber ? parseInt(pageNumber[1]) : 1;
            }

            // function updateUrlWithPage(pageNumber) {
            //     var username = $("#username").val();
            //     var norek = $("#norek").val();
            //     var namerek = $("#namerek").val();
            //     var bank = $("#bank").val();
            //     var nope = $("#nope").val();
            //     var referral = $("#referral").val();
            //     var gabungdari = $("#gabungdari").val();
            //     var gabunghingga = $("#gabunghingga").val();
            //     var status = $("#status").val();

            //     var newUrl = "/memberlistds?";
            //     newUrl += "username=" + username + "&";
            //     newUrl += "norek=" + norek + "&";
            //     newUrl += "namerek=" + namerek + "&";
            //     newUrl += "bank=" + bank + "&";
            //     newUrl += "nope=" + nope + "&";
            //     newUrl += "referral=" + referral + "&";
            //     newUrl += "gabungdari=" + gabungdari + "&";
            //     newUrl += "gabunghingga=" + gabunghingga + "&";
            //     newUrl += "status=" + status + "&";
            //     newUrl += "page=" + pageNumber;

            //     window.location.href = newUrl;
            // }
        });

        //open jendela detail
        $(document).ready(function() {
            $(".openviewport").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 700;
                var windowHeight = $(window).height() * 0.6;
                var windowLeft = ($(window).width() - windowWidth) / 1.5;
                var windowTop = ($(window).height() - windowHeight) / 1.5;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" +
                    windowLeft + ", top=" + windowTop);
            });
        });

        //open jendela detail
        $(document).ready(function() {
            $(".detailbetingan").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 500;
                var windowHeight = $(window).height() * 0.3;
                var windowLeft = ($(window).width() - windowWidth) / 3;
                var windowTop = ($(window).height() - windowHeight) / 1.8;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" +
                    windowLeft + ", top=" + windowTop);
            });
        });
        // Tinggal isi aja array inputs nya dengan apapun yang mau dicari via form dengan id searchForm
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            const inputs = [
                'checkusername',
                'username',
                'norek',
                'namarek',
                'bank',
                'nohp',
                'referral',
                'gabungdari',
                'gabunghingga',
                'status',
            ];
            inputs.forEach(id => {
                const inputElement = document.getElementById(id);
                if (!inputElement.value) {
                    inputElement.disabled = true; // Untuk disabled input kalau tidak ada filter :D
                }
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
                    // Mendapatkan nilai dari input
                    var username = $('#username').val(); // Asumsi ada elemen dengan id 'username'
                    var norek = $('#norek').val(); // Asumsi ada elemen dengan id 'norek'
                    var namarek = $('#namarek').val(); // Asumsi ada elemen dengan id 'namarek'
                    var bank = $('#bank').val(); // Asumsi ada elemen dengan id 'bank'
                    var nohp = $('#nohp').val(); // Asumsi ada elemen dengan id 'nohp'
                    var referral = $('#referral').val(); // Asumsi ada elemen dengan id 'referral'
                    var gabungdari = $('#gabungdari').val(); // Asumsi ada elemen dengan id 'gabungdari'
                    var gabunghingga = $('#gabunghingga')
                        .val(); // Asumsi ada elemen dengan id 'gabunghingga'
                    var status = $('#status').val(); // Asumsi ada elemen dengan id 'status'

                    // Membuat URL dengan parameter dinamis
                    var url = '/memberlistds/export?' +
                        '&username=' + encodeURIComponent(username) +
                        '&norek=' + encodeURIComponent(norek) +
                        '&namarek=' + encodeURIComponent(namarek) +
                        '&bank=' + encodeURIComponent(bank) +
                        '&nohp=' + encodeURIComponent(nohp) +
                        '&referral=' + encodeURIComponent(referral);
                    '&gabungdari=' + encodeURIComponent(gabungdari);
                    '&gabunghingga=' + encodeURIComponent(gabunghingga);
                    '&status=' + encodeURIComponent(status);

                    // Redirect ke URL
                    window.location.href = url;
                }
            });
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            });
        </script>
    @endif
@endsection
