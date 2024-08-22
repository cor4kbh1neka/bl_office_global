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
                        d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z">
                    </path>
                </svg>
            </div>
        </div>
        <div class="secagentds">
            <div class="groupsecagentds">
                <div class="headgroupsecagentds">


                    <div class="listheadsecagentds bottom">
                        <a href="/linkalternatifds/create" class="tombol proses">
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
                                ADD LINK
                            </span>
                        </a>
                        <form action="/linkalternatifds" method="GET" class="groupsearchagentds">
                            <div class="grubsearchnav">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14">
                                    </path>
                                </svg>
                                <input type="text" placeholder="Cari Link ..." id="searchTabel" name="search"
                                    value="{{ $search }}">
                            </div>
                            <button class="tombol primary">
                                <span class="texttombol">search</span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="groupdatasecagentds">
                    <div class="tabelproses">
                        <table>
                            <tbody>
                                <tr class="hdtable">
                                    <th class="bagno">#</th>
                                    <th class="baglogininfo">Link</th>
                                    <th class="bagiplogin">Tanggal Buat</th>
                                    <th class="bagno">Tools</th>
                                </tr>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['created_on'] }}</td>
                                        <td>
                                            <div class="grouptools">
                                                <a href="/linkalternatifds/edit/{{ $item['id'] }}"
                                                    class="tombol grey openviewport">
                                                    <span class="texttombol">EDIT</span>
                                                </a>
                                                <button class="tombol cancel border"
                                                    onclick="removeFunction('{{ $item['id'] }}', '{{ $item['name'] }}')">
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

            var status = "<?php echo session('status'); ?>";

            if (status == 'fail') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('message') }}',
                    showConfirmButton: false,
                    timer: 2500 // Durasi pesan sukses
                });
            } else if (status == 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('message') }}',
                    showConfirmButton: false,
                    timer: 2500 // Durasi pesan sukses
                });
            }
        });

        function removeFunction(itemId, Link) {
            const pinServer = "{{ $pin }}";
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan aksi ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan prompt untuk PIN dengan input tipe password dan background khusus
                    Swal.fire({
                        title: 'Masukkan PIN',
                        input: 'password', // Tipe input password
                        inputPlaceholder: 'Masukkan PIN Anda',
                        inputAttributes: {
                            maxlength: 10,
                            autocapitalize: 'off',
                            autocorrect: 'off',
                            style: 'color: black; font-size: 1.25em; text-align: center;'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Kirim',
                        cancelButtonText: 'Batal',
                        preConfirm: (pin) => {
                            if (!pin) {
                                Swal.showValidationMessage('PIN tidak boleh kosong');
                            }
                            if (pin !== pinServer) {
                                Swal.showValidationMessage('PIN salah, coba lagi');
                            }
                            return pin;
                        }
                    }).then((pinResult) => {
                        if (pinResult.isConfirmed) {
                            $.ajax({
                                url: '/linkalternatifds/remove/' + itemId + '/' + Link,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}' // Pastikan Anda menyertakan CSRF token untuk keamanan
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Berhasil!',
                                        'Data berhasil dihapus.',
                                        'success'
                                    ).then(() => {
                                        location
                                            .reload(); // Reload halaman setelah berhasil
                                    });
                                },
                                error: function(xhr) {
                                    Swal.fire(
                                        'Gagal!',
                                        'Terjadi kesalahan saat menghapus data.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection
