@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <h2>{{ $title }}</h2>
        <div class="group_act_butt">
            <div class="search-jenis">
                <select id="jenis" name="jenis">
                    <option value="">ALL</option>
                    <option value="DPM">BCA 1 (0)</option>
                    <option value="WDM">BCA 2 (0)</option>
                    <option value="WDM">BNI 1 (0)</option>
                    <option value="WDM">BNI 2 (0)</option>
                    <option value="WDM">MANDIRI 1 (0)</option>
                    <option value="WDM">MANDIRI 2 (0)</option>
                    <option value="WDM">GOJEK 1 (0)</option>
                    <option value="WDM">GOJEK 2 (0)</option>
                    <option value="WDM">DANA 1 (0)</option>
                    <option value="WDM">DANA 1 (0)</option>
                </select>
            </div>
            <div class="all_act_butt">
                <a href="#" id="approve">
                    <div class="sec_edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l5 5l10 -10" />
                        </svg>
                        <span>Accept</span>
                    </div>
                </a>
                <a href="#" id="reject">
                    <div class="sec_delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                        <span>Reject</span>
                    </div>
                </a>
            </div>
        </div>
        <table>
            <tbody>
                <tr class="head_table">
                    <th class="check_box">
                        <input type="checkbox" id="myCheckbox" name="myCheckbox">
                    </th>
                    <th>Username</th>
                    <th>Bank</th>
                    <th>Nama Rek</th>
                    <th>No.Rek</th>
                    <th>Ket</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Date</th>
                    {{-- <th>Action</th> --}}
                </tr>
                <tr class="filter_row">
                    <td></td>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" placeholder="Cari data..." id="searchData-name">
                        </div>
                    </td>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" placeholder="Cari data..." id="searchData-name">
                        </div>
                    </td>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" placeholder="Cari data..." id="searchData-name">
                        </div>
                    </td>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" placeholder="Cari data..." id="searchData-name">
                        </div>
                    </td>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" placeholder="Cari data..." id="searchData-name">
                        </div>
                    </td>
                    <td></td>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" placeholder="Cari data..." id="searchData-name">
                        </div>
                    </td>
                    <td></td>
                </tr>

                @foreach ($data as $index => $d)
                    <tr>
                        <td class="check_box" onclick="toggleCheckbox('myCheckbox-{{ $index }}')">
                            <input type="checkbox" id="myCheckbox-{{ $index }}"
                                name="myCheckbox-{{ $index }}" data-id=" {{ $d->id }}">
                        </td>
                        <td><span class="name">{{ $d->username }}</span></td>
                        <td><span class="name">{{ $d->mbank }}</span></td>
                        <td><span class="name">{{ $d->mnamarek }}</span></td>
                        <td><span class="name">{{ $d->mnorek }}</span></td>
                        <td><span class="name">{{ $d->keterangan }}</span></td>
                        <td><span class="name">
                                @php
                                    if ($d->status === 0) {
                                        echo '<button class="sec_botton btn_secondary" onclick="salinTeks("voucher24837_AOtx8urR5r")">WAITING</button>';
                                    } elseif ($d->status === 1) {
                                        echo '<button class="sec_botton btn_secondary" onclick="salinTeks("voucher24837_AOtx8urR5r")">ACCEPT</button>';
                                    } else {
                                        echo '<button class="sec_botton btn_secondary" onclick="salinTeks("voucher24837_AOtx8urR5r")">CANCEL</button>';
                                    }
                                @endphp</span></td>

                        <td><span class="name">{{ number_format($d->amount, 3, ',', '.') }}</span></td>
                        <td><span class="name">{{ date('d-m-Y H:i:s', strtotime($d->created_at)) }}</span></td>
                        {{-- <td><span class="name">{{ date('d-m-Y H:i:s', strtotime($d->tgl_berita)) }}</span></td> --}}

                        {{-- <td class="kolom_action">
                        <div class="dot_action">
                            <span>•</span>
                            <span>•</span>
                            <span>•</span>
                        </div>
                        <div class="action_crud" id="1" style="display: none;">
                            <a href="#" id="view" data-id="{{ $d['id'] }}">
                                <div class="list_action">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye"
                                        viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6">
                                        </path>
                                    </svg>
                                    <span>View</span>
                                </div>
                            </a>
                            <a href="#" id="edit" data-id="{{ $d['id'] }}">
                                <div class="list_action">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-edit-circle" viewBox="0 0 24 24"
                                        stroke-width="1.5" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z">
                                        </path>
                                        <path d="M16 5l3 3"></path>
                                        <path d="M9 7.07a7 7 0 0 0 1 13.93a7 7 0 0 0 6.929 -6"></path>
                                    </svg>
                                    <span>Edit</span>
                                </div>
                            </a>
                            <a href="#" id="delete" data-id="{{ $d['id'] }}">
                                <div class="list_action">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash"
                                        viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 7l16 0"></path>
                                        <path d="M10 11l0 6"></path>
                                        <path d="M14 11l0 6"></path>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                    </svg>
                                    <span>Delete</span>
                                </div>
                            </a>
                        </div>
                    </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
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

            $(document).on('click', '#approve', function(event) {
                event.preventDefault();

                var approveButton = $(this);
                approveButton.prop('disabled', true);

                var checkedValues = [];
                $('input[id^="myCheckbox-"]:checked').each(function() {
                    var value = $(this).data('id');
                    checkedValues.push(value);
                });

                if (checkedValues.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Silahkan centang list dibawah terlebih dahulu!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    approveButton.prop('disabled', false);
                    return;
                }

                var parameterString = $.param({
                    'values[]': checkedValues
                }, true);
                var url =
                    "/approve";

                Swal.fire({
                    title: 'ACCEPT',
                    text: "Apakah Anda yakin ingin meng-accept data ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Accept!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: checkedValues
                            },
                            success: function(result) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data berhasil di-accept!',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    window.location.href = "/deposit";
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan saat meng-accept data.'
                                });
                            },
                            complete: function() {
                                approveButton.prop('disabled', false);
                            }
                        });
                    } else {
                        approveButton.prop('disabled', false);
                    }
                });
            });

            $(document).on('click', '#reject', function(event) {
                event.preventDefault();

                var approveButton = $(this);
                approveButton.prop('disabled', true);

                var checkedValues = [];
                $('input[id^="myCheckbox-"]:checked').each(function() {
                    var value = $(this).data('id');
                    checkedValues.push(value);
                });

                if (checkedValues.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Silahkan centang list dibawah terlebih dahulu!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    approveButton.prop('disabled', false);
                    return;
                }

                var parameterString = $.param({
                    'values[]': checkedValues
                }, true);
                var url =
                    "/reject";

                Swal.fire({
                    title: 'REJECT',
                    text: "Apakah Anda yakin ingin me-reject data ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Reject!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: checkedValues
                            },
                            success: function(result) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data berhasil di-reject!',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    window.location.href = "/deposit";
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan saat meng-accept data.'
                                });
                            },
                            complete: function() {
                                approveButton.prop('disabled', false);
                            }
                        });
                    } else {
                        approveButton.prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
