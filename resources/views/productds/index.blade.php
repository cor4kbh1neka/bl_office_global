@extends('layouts.index')

@section('container')
    <style>
        .tabelproses {
            width: 50%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z">
                    </path>
                </svg>
            </div>
        </div>
        <div class="secagentds">
            <div class="groupsecagentds">
                <div class="headgroupsecagentds">
                    <div class="listheadsecagentds bottom">
                        <a href="/productds/add" class="tombol proses">
                            <span class="texttombol">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                    <defs>
                                        <mask id="ipSAdd0">
                                            <g fill="none" stroke-linejoin="round" stroke-width="4">
                                                <rect width="36" height="36" x="6" y="6" fill="#fff"
                                                    stroke="#fff" rx="3"></rect>
                                                <path stroke="#000" stroke-linecap="round" d="M24 16v16m-8-8h16"></path>
                                            </g>
                                        </mask>
                                    </defs>
                                    <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSAdd0)"></path>
                                </svg>
                                ADD PRODUCT
                            </span>
                        </a>
                    </div>
                </div>
                <div class="groupdatasecagentds">
                    <div class="tabelproses">
                        <table>
                            <tbody>
                                <tr class="hdtable">
                                    <th class="bagno">#</th>
                                    <th class="baglogininfo">portfolio</th>
                                    <th class="baglogininfo">nama game</th>
                                    <th class="action">tools</th>
                                </tr>
                                @foreach ($data as $index => $d)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $d->portfolio }}</td>
                                        <td>{{ $d->productsname }}</td>
                                        <td>
                                            <div class="grouptools">
                                                <a href="/productds/edit/{{ $d['id'] }}" target="_blank"
                                                    class="tombol grey openviewport">
                                                    <span class="texttombol">EDIT</span>
                                                </a>
                                                <button id="delete" class="tombol cancel border"
                                                    data-id="{{ $d['id'] }}">
                                                    <span class="texttombol">REMOVE</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="padding-left:25px;padding-right:25px">

                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            // Event handler untuk checkbox dengan ID myCheckbox
            $('#myCheckbox').change(function() {
                // Mendapatkan status ceklis checkbox myCheckbox
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

                window.location.href = '/productds/edit/' + parameterString;
            });


            $(document).on('click', '#delete-user', function(event) {
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
                    "/productds/delete/";

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
                                    window.location.href = '/productds';
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
                $('.aplay_code').load('/productds/view/' + id, function() {
                    adjustElementSize();
                    localStorage.setItem('lastPage', '/productds/view/' + id);
                });
            });


            // $(document).off('click', '#edit').on('click', '#edit', function(event) {
            //     event.preventDefault();
            //     var id = $(this).data('id');
            //     $('.aplay_code').empty();
            //     $('.aplay_code').load('/productds/edit/' + id, function() {
            //         adjustElementSize();
            //         localStorage.setItem('lastPage', '/productds/edit/' + id);
            //     });
            // });

            $(document).on('click', '#delete', function(event) {
                event.preventDefault();

                var id = $(this).data('id');
                var url =
                    "/productds/delete/"; // Ubah URL sesuai dengan endpoint delete yang sesuai

                Swal.fire({
                    title: 'Apakah Anda yakin ingin menghapus Product ini?',
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
                                    window.location.href = '/productds';
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
        });
    </script>
@endsection
