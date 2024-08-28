@extends('layouts.index')

@section('container')
    <style>
        .swal2-input.custom-input {
            color: black;
            border-color: #d33;
        }

        .bagno {
            width: 5%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <h2>{{ $title }}</h2>
        <div class="group_act_butt">
            <a href="/linkalternatifds/create/{{ $dashboard_id }}" id="add-user">
                <div class="sec_addnew">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-square-plus"
                        viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path>
                        <path d="M9 12l6 0"></path>
                        <path d="M12 9l0 6"></path>
                    </svg>
                    <span>Add New</span>
                </div>
            </a>
            <div class="all_act_butt" style="display: flex">
                <select id="jenis_event" name="jenis_event">
                    @foreach ($data_dashboard as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $dashboard_id ? 'selected' : '' }}>
                            {{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <table>
            <tbody>
                <tr class="hdtable">
                    <th>Dashboard</th>
                    <th>Link</th>
                    <th>Tanggal Buat</th>
                    <th class="bagno">Tools</th>
                </tr>
                @foreach ($data as $index => $d)
                    <tr>
                        <td><span class="name">{{ $dashboard }}</span></td>
                        <td><span class="name">{{ $d['name'] }}</span></td>
                        <td><span class="name">{{ $d['created_on'] }}</span></td>
                        {{-- <td><span class="name">{{ date('d-m-Y H:i:s', strtotime($d->tgl_berita)) }}</span></td> --}}

                        <td class="kolom_action">
                            <div class="dot_action">
                                <span>•</span>
                                <span>•</span>
                                <span>•</span>
                            </div>
                            <div class="action_crud" id="1" style="display: none;">
                                <a href="/linkalternatifds/edit/{{ $d['id'] }}" id="edit">
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
                                <a href="#" id="delete" data-id="{{ $d['id'] }}"
                                    data-link="{{ $d['name'] }}">
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (auth()->user()->divisi == 'superadmin')
            <table>
                <tbody>
                    <tr class="hdtable">
                        <th class="bagno">#</th>
                        <th class="baglogininfo">IP</th>
                        <th class="bagno">Tools</th>
                    </tr>
                    @foreach ($dataIP as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td id="ip-{{ $item->id }}">{{ $item->ip }}</td>
                            <td>
                                <div class="grouptools">
                                    <button class="sec_botton btn_warning edit-btn" data-id="{{ $item->id }}">
                                        EDIT
                                    </button>
                                </div>
                                <div class="grouptools
                                        save-cancel-group"
                                    id="save-cancel-{{ $item->id }}" style="display: none">
                                    <button class="sec_botton btn_success save-new" data-id="{{ $item->id }}">
                                        SAVE
                                    </button>
                                    <button class="sec_botton btn_danger cancel" data-id="{{ $item->id }}">
                                        CANCEL
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
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
            $('#update-user').off('click').click(function(event) {
                event.preventDefault();

                var checkedValues = [];
                $('input[id^="myCheckbox-"]:checked').each(function() {
                    var value = $(this).data('id');
                    checkedValues.push(value);
                });
                if (checkedValues == 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Silahkan pilih Data!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }


                var parameterString = $.param({
                    'values[]': checkedValues
                }, true);

                window.location.href = '/linkalternatifds/edit/' + parameterString;
            });


            $(document).on('click', '#delete-linkalternatif', function(event) {
                event.preventDefault();

                var checkedValues = [];
                $('input[id^="myCheckbox-"]:checked').each(function() {
                    var value = $(this).data('id');
                    checkedValues.push(value);
                });

                if (checkedValues.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Silahkan pilih Data!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return; // Menghentikan eksekusi jika tidak ada item yang dipilih
                }

                var parameterString = $.param({
                    'values[]': checkedValues
                }, true);
                var url =
                    "/linkalternatifds/delete/";

                Swal.fire({
                    title: 'Apakah Anda yakin ingin menghapus user ini ?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                                values: checkedValues
                            },
                            success: function(result) {
                                // Tampilkan SweetAlert untuk sukses
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data berhasil dihapus!',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    // Lakukan perubahan halaman atau tindakan lainnya setelah data berhasil dihapus
                                    window.location.href =
                                        '/linkalternatifds/index';
                                });
                            },
                            error: function(xhr) {
                                // Tampilkan SweetAlert untuk kesalahan
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan saat menghapus data.'
                                });

                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            });
            $(document).off('click', '#view').on('click', '#view', function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                $('.aplay_code').empty();
                $('.aplay_code').load('/linkalternatifds/view/' + id, function() {
                    adjustElementSize();
                    localStorage.setItem('lastPage', '/linkalternatifds/view/' + id);
                });
            });


            // $(document).off('click', '#edit').on('click', '#edit', function(event) {
            //     event.preventDefault();
            //     var id = $(this).data('id');
            //     $('.aplay_code').empty();
            //     $('.aplay_code').load('/linkalternatifds/edit/' + id, function() {
            //         adjustElementSize();
            //         localStorage.setItem('lastPage', '/linkalternatifds/edit/' + id);
            //     });
            // });

            $(document).on('click', '#delete', function(event) {
                event.preventDefault();

                var id = $(this).data('id');
                var link = $(this).data('link');
                var url =
                    `/linkalternatifds/remove/${id}/${link}`; // Ubah URL sesuai dengan endpoint delete yang sesuai
                const correctPin = '464646'; // PIN yang benar

                // Tampilkan konfirmasi penghapusan
                Swal.fire({
                    title: 'Apakah Anda yakin ingin menghapus User ini?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan dialog untuk memasukkan PIN
                        Swal.fire({
                            title: 'Masukkan PIN untuk konfirmasi',
                            input: 'password',
                            inputLabel: 'PIN Anda',
                            inputPlaceholder: 'Masukkan PIN',
                            inputAttributes: {
                                maxlength: 6,
                                autocapitalize: 'off',
                                autocorrect: 'off'
                            },
                            customClass: {
                                input: 'custom-input' // Terapkan kelas CSS kustom pada input
                            },
                            confirmButtonText: 'Konfirmasi',
                            showCancelButton: true,
                            cancelButtonText: 'Batal'
                        }).then((pinResult) => {
                            if (pinResult.isConfirmed) {
                                const pin = pinResult.value;

                                // Periksa apakah PIN yang dimasukkan benar
                                if (pin === correctPin) {
                                    // Lakukan permintaan penghapusan setelah PIN dikonfirmasi
                                    $.ajax({
                                        url: url,
                                        method: 'DELETE',
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            values: id
                                        },
                                        success: function(result) {
                                            // Tampilkan SweetAlert untuk sukses
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Data berhasil dihapus!',
                                                showConfirmButton: false,
                                                timer: 1500
                                            }).then(function() {
                                                // Lakukan perubahan halaman atau tindakan lainnya setelah data berhasil dihapus
                                                window.location.href =
                                                    '/linkalternatifds/index';
                                            });
                                        },
                                        error: function(xhr) {
                                            // Tampilkan SweetAlert untuk kesalahan
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: 'Terjadi kesalahan saat menghapus data.'
                                            });

                                            console.log(xhr.responseText);
                                        }
                                    });
                                } else {
                                    // Tampilkan pesan kesalahan jika PIN salah
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'PIN Salah',
                                        text: 'PIN yang Anda masukkan tidak benar.'
                                    });
                                }
                            }
                        });
                    }
                });
            });

        });

        $(document).ready(function() {
            $('.edit-btn').on('click', function() {
                var id = $(this).data('id');
                var ipTd = $('#ip-' + id);
                var currentIp = ipTd.text();

                ipTd.html('<div class="list_form"><input type="text" id="input-ip-' + id + '" value="' +
                    currentIp + '" /></div>');

                var inputField = $('#input-ip-' + id);
                inputField.focus();
                var tempVal = inputField.val();
                inputField.val('').val(tempVal);

                $(this).parent().hide();
                $('#save-cancel-' + id).show();
            });

            $('.save-new').on('click', function() {
                var id = $(this).data('id');
                var newIp = $('#input-ip-' + id).val();

                $.ajax({
                    url: '/linkalternatifds/updateip/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ip: newIp
                    },
                    success: function(response) {
                        Swal.fire(
                            'Berhasil!',
                            'IP berhasil diubah.',
                            'success'
                        ).then(() => {
                            location
                                .reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat mengupdate IP.',
                            'error'
                        );
                    }
                });
            });

            $('.cancel').on('click', function() {
                var id = $(this).data('id');
                var originalIp = $('#input-ip-' + id).attr('value');

                $('#ip-' + id).text(originalIp);

                $('#save-cancel-' + id).hide();
                $('#save-cancel-' + id).siblings('.grouptools').show();
            });
        });

        $(document).ready(function() {
            $('#jenis_event').change(function() {
                var selectedOption = $(this).find('option:selected');
                var selectedValue = selectedOption.val();
                window.location.href = '/linkalternatifds/index/' + selectedValue;
            });
        });
    </script>
@endsection
