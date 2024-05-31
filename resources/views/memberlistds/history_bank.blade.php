<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/utama/g21-icon.ico') }}" />
    <title>Dashboard | L21</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/design.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/custom_dash.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>

    {{-- <script>
        $(document).ready(function() {
            adjustElementSize();
        });
    </script> --}}
</head>
<div class="sec_table">
    <div class="seceditmemberds historybetcc">
        <div class="groupseceditmemberds">
            <div class="datahistory">
                <span class="titlemodalhistory">HISTORY COIN USER : {{ $username }}</span>
                <div class="tabelproses">
                    <table>
                        <tbody>
                            <tr class="hdtable">
                                <th class="bagno">#</th>
                                <th class="bagtanggal coin">tanggal</th>
                                <th class="bagstatustrans">status</th>
                                <th class="bagagent">agent</th>
                                <th class="bagnominal">coin</th>
                                <th class="bagnominal">last coin</th>
                            </tr>
                            @php
                                if($data != null){
                                    $currentPage = $data->currentPage();
                                    $perPage = $data->perPage();
                                    $startNumber = ($currentPage - 1) * $perPage + 1;
                                }
                            @endphp
                            @foreach ($data as $i => $d)
                                <tr>
                                    <td>{{ $startNumber + $i }}</td>
                                    <td class="hsjenistrans">{{ $d->updated_at }}</td>
                                    <td class="hsjenistrans" data-proses="{{ $d->status == 1 ? 'accept' : 'cancel' }}">
                                        @if ($d->jenis == 'DP' || $d->jenis == 'WD')
                                            {{ $d->status == 1 ? 'accept' : 'reject' }}
                                            {{ $d->jenis == 'DP' ? 'deposit' : 'withdraw' }}
                                        @else
                                            manual
                                            {{ $d->jenis == 'DP' ? 'deposit' : 'withdraw' }}
                                        @endif
                                    </td>
                                    <td>{{ $d->approved_by }}</td>
                                    <td>{{ $d->amount }}</td>
                                    <td>{{ $d->balance }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links('vendor.pagination.customdashboard') }}
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
                    <div class="informasihistorycoin">
                        <span>*data yang di tampilkan saat ini, selengkapnya di menu <span
                                class="texthistory">history</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.groupeditinput svg').click(function() {
            $(this).closest('.groupeditinput').toggleClass('edit');
            $(this).siblings('input').prop('readonly', function(_, val) {
                return !val;
            });
        });
    });
</script>
