@extends('layouts.index')

@section('container')
    <style>
        .labelhttps {
            width: 10%;
        }

        .div-right {
            width: 100%
        }

        .div-right a {
            display: flex;
            justify-content: flex-end;
        }

        .sec_botton {
            display: flex;
            align-items: center;
            /* Menyelaraskan elemen anak secara vertikal */
            gap: 8px;
            /* Jarak antara SVG dan teks */
            padding: 8px 16px;
            /* Sesuaikan padding jika perlu */
        }

        .icon-tabler-arrow-left {
            height: 1em;
            /* Sesuaikan ukuran ikon relatif terhadap teks */
            width: 1em;
            /* Sesuaikan ukuran ikon relatif terhadap teks */
        }

        form {
            padding-bottom: 20px;
        }

        svg {
            width: 20px;
            stroke: var(--primary-color);
        }

        .copyButton {
            color: var(--primary-color);
        }

        .tooltip {
            visibility: hidden;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            /* Posisi tooltip di sebelah kanan tombol */
            left: 105%;
            /* Menempatkan tooltip di sebelah kanan tombol */
            top: 50%;
            /* Menyelaraskan tooltip secara vertikal di tengah tombol */
            transform: translateY(-50%);
            /* Mengatur posisi vertikal untuk menyesuaikan */
            white-space: nowrap;
            /* Mencegah teks tooltip membungkus ke baris berikutnya */
        }

        .copyButton:hover .tooltip {
            visibility: visible;
        }


        .grouptools {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .grouptools button span {
            font-weight: 500
        }

        .td-action {
            width: 10%;
        }

        .hapusKolom {
            width: 55%;
        }

        .content_body {
            overflow-y: unset;
            /* Menghapus pengaturan overflow-y khusus */
            padding: 20px
        }

        .kolom_action {
            gap: 5px
        }

        .save {
            display: none;
        }

        .bt-cancel {
            display: none;
        }
    </style>
    <div class="sec_box hgi-100">
        <form action="/linkalternatifds/store" method="POST" enctype="multipart/form-data" id="form-linkalternatifds">
            @csrf
            <div class="sec_form">
                <div class="sec_head_form">
                    <h3>{{ $title }}</h3>
                    <span>Tambah {{ $title }}</span>
                    <div class="div-right">
                        <a href="/linkalternatifds/index" id="cancel">
                            <button type="button" class="sec_botton btn_cancel">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l14 0" />
                                    <path d="M5 12l6 6" />
                                    <path d="M5 12l6 -6" />
                                </svg>
                                Back
                            </button>
                        </a>
                    </div>

                </div>
                <div class="list_form">
                    <span class="sec_label">Link</span>
                    <span class="sec_label labelhttps">https://</span>
                    <input type="hidden" name="dashboard_id" id="dashboard_id" value={{ $dashboard_id }}>
                    <input type="text" id="link" name="link" placeholder="Masukkan Link" required
                        {{ $step == 'create' ? '' : 'disabled' }} value="{{ $link }}">
                </div>
            </div>
            @if ($step == 'create')
                <div class="sec_button_form">
                    <button class="sec_botton btn_submit" type="submit" id="Contactsubmit">Submit</button>
                </div>
            @endif
        </form>
    </div>
    @if ($step == 'edit')
        <div class="sec_box hgi-100">
            <div class="sec_head_form">
                <h3>CLOUDFLARE NAMESERVER</h3>
            </div>
            <table>
                <tbody>
                    <tr class="hdtable">
                        <th>Type</th>
                        <th>Value</th>
                    </tr>
                    @foreach ($datans['name_servers'] as $index => $item)
                        <tr>
                            <td><span class="name">NS</span></td>
                            <td><span class="name domainvalue" data-value={{ $item }}>
                                    {{ $item }}
                                    <button class="copyButton"
                                        style="border: none; background: none; cursor: pointer; padding-left: 5px; position: relative;">
                                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img"
                                            width="1em" height="1em" viewBox="0 0 2048 2048">
                                            <path fill="currentColor"
                                                d="M2048 0v1664h-384v384H0V384h384V0zm-128 1536V128H512v256h256v128H128v1408h1408v-640h128v256zm-979-339l-90-90l594-595h-421V384h640v640h-128V603z">
                                            </path>
                                        </svg>
                                        <span class="tooltip"
                                            style="visibility: hidden; color: #fff; text-align: center; border-radius: 5px; padding: 5px; position: absolute; z-index: 1; bottom: 125%; left: 50%; transform: translateX(-50%); white-space: nowrap;">Copied!</span>
                                    </button>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="sec_box hgi-100">
            <div class="sec_head_form">
                <h3>DNS MANAGEMENT</h3>
            </div>
            <table id="table-DNS" class="table-dns">
                <tbody>
                    <tr class="hdtable">
                        <th>Type</th>
                        <th>Name</th>
                        <th>Content</th>
                        <th class="td-action">
                            <button class="sec_botton btn_success" id="addRowButton">
                                ADD </button>
                        </th>
                    </tr>
                    @foreach ($datadns as $index => $item)
                        <tr>
                            <td id="verificationType{{ $index }}"><span class="name">{{ $item['type'] }}</span>
                            </td>
                            <td id="verificationName{{ $index }}"><span class="name"
                                    colspan="2">{{ $item['name'] }}</span></td>
                            <td id="verificationText{{ $index }}"><span class="name"
                                    colspan="2">{{ $item['content'] }}</span></td>
                            <td class="kolom_action">
                                <button class="sec_botton btn_warning edit" data-index="{{ $index }}">
                                    EDIT
                                </button>
                                <button class="sec_botton btn_danger delete" data-zoneid="{{ $item['zone_id'] }}"
                                    data-id="{{ $item['id'] }}">
                                    DELETE
                                </button>
                                <button class="sec_botton btn_success save" data-index="{{ $index }}"
                                    data-zoneid="{{ $item['zone_id'] }}" data-id="{{ $item['id'] }}"
                                    data-name="{{ $item['name'] }}">
                                    SAVE
                                </button>
                                <button class="sec_botton btn_warning bt-cancel" data-index="{{ $index }}">
                                    CANCEL
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <script>
        $(document).ready(function() {
            // Show validation errors, success, and error messages
            @if ($errors->any())
                let errorMessages = '';
                @foreach ($errors->all() as $error)
                    errorMessages += '{{ $error }}<br>';
                @endforeach

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMessages,
                    confirmButtonText: 'OK'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
            @endif

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            @endif

            // Handle form submission
            $('#form-linkalternatifds').on('submit', function(e) {
                e.preventDefault();

                var link = $('#link').val().trim();
                var pattern = /^[a-zA-Z0-9-]+\.[a-zA-Z]{2,}(\.[a-zA-Z]{2,})?$/;

                if (!pattern.test(link) || link.startsWith("http://") || link.startsWith("https://")) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Link',
                        text: 'Link tidak boleh mengandung http:// atau https:// dan harus memiliki domain yang valid seperti .com, .org, dll.',
                        confirmButtonText: 'OK'
                    });
                } else {
                    this.submit();
                }
            });

            //Copy button
            $('.copyButton').click(function() {
                var textToCopy = $(this).parent().text().trim();
                var $temp = $('<input>');
                var value = $(this).parent().data('value');

                $('body').append($temp);

                $temp.val(value).select();
                document.execCommand('copy');
                $temp.remove();

                var $tooltip = $(this).find('.tooltip');
                $tooltip.css('visibility', 'visible');

                setTimeout(function() {
                    $tooltip.css('visibility', 'hidden');
                }, 2000);
            });

            // Add new row to DNS table
            $('#table-DNS').on('click', '#addRowButton', function() {
                var newRow = `
                    <tr>
                        <td>
                            <select name="type">
                                <option value="TXT">TXT</option>
                                <option value="A">A</option>
                                <option value="CNAME">CNAME</option>
                            </select>
                        </td>
                        <td>
                            <div class="list_form">
                                <input type="text" class="content-input" name="name" value="" placeholder="masukkan name">
                            </div>
                        </td>
                        <td>
                            <div class="list_form">
                                <input type="text" class="content-input" name="content" value="" placeholder="masukkan content">
                            </div>
                        </td>
                        <td>
                            <div class="grouptools">
                                <button class="sec_botton btn_success save-new" data-zoneid="{{ $zoneid }}" data-link="{{ $link }}">
                                    SAVE
                                </button>
                                
                                <button class="sec_botton btn_danger hapusKolom">
                                    X
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                $('#table-DNS tbody').append(newRow);
            });

            // Remove row from DNS table
            $('#table-DNS').on('click', '.hapusKolom', function() {
                $(this).closest('tr').remove();
            });

            // Save updated DNS record
            $('.save').click(function() {
                var index = $(this).data('index');
                var zoneid = $(this).data('zoneid');
                var name = $(this).data('name');
                var id = $(this).data('id');
                var $verificationText = $('#verificationText' + index);
                var $verificationName = $('#verificationName' + index);
                var $verificationType = $('#verificationType' + index);
                var newContent = $verificationText.find('input').val();
                var newName = $verificationName.find('input').val();
                var newType = $verificationType.find('select').val();

                $.ajax({
                    url: '/linkalternatifds/updatedns',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        zoneid: zoneid,
                        id: id,
                        name: newName,
                        type: newType,
                        content: newContent
                    },
                    success: function(response) {
                        $verificationText.html(newContent);
                        $('.save').hide();
                        $('.bt-cancel').hide();
                        $('.edit').show();
                        $('.delete').show();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'DNS berhasil ditambahkan',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // Save new DNS record
            $('#table-DNS').on('click', '.save-new', function() {
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                const $row = $(this).closest('tr');
                const type = $row.find('select[name="type"]').val();
                const name = $row.find('input[name="name"]').val().trim();
                const content = $row.find('input[name="content"]').val().trim();
                const data = {
                    _token: csrfToken,
                    zoneid: $(this).data('zoneid'),
                    type,
                    name,
                    content,
                    link: $(this).data('link')
                };

                if (content) {
                    $.ajax({
                        url: `/linkalternatifds/storedns`,
                        method: 'POST',
                        data,
                        success: response => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        },
                        error: xhr => {
                            const {
                                status,
                                responseJSON
                            } = xhr;
                            const {
                                message
                            } = responseJSON;
                            showAlert(status === 422 ? 'error' : 'warning', 'Error', message ||
                                'Failed to save data');
                        }
                    });
                } else {
                    showAlert('error', 'Validation Error', 'Content field cannot be empty.');
                }
            });

            // Delete DNS record
            $('.delete').on('click', function() {
                var itemId = $(this).data('id');
                var zoneId = $(this).data('zoneid');
                var deleteUrl = '/linkalternatifds/delete/' + zoneId + '/' + itemId;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan bisa mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire('Terhapus!', 'Item Anda telah dihapus.',
                                        'success')
                                    .then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire('Kesalahan!',
                                    'Terjadi kesalahan saat menghapus item Anda.',
                                    'error');
                            }
                        });
                    }
                });
            });

            // Edit DNS record
            $('.edit').click(function() {
                var index = $(this).data('index');
                var $verificationText = $('#verificationText' + index);
                var content = $verificationText.text().trim();

                var $verificationName = $('#verificationName' + index);
                var name = $verificationName.text().trim();

                var $verificationType = $('#verificationType' + index);
                var type = $verificationType.text().trim();

                $verificationText.html(
                    '<div class="list_form"><input type="text" class="form-control" value="' + content +
                    '"></div>');
                $verificationName.html(
                    '<div class="list_form"><input type="text" class="form-control" value="' + name +
                    '"></div>');
                $verificationType.html(
                    '<div class="list_form">' +
                    '  <select id="keterangan" name="keterangan" class="form-control">' +
                    '    <option value="TXT"' + (type === 'TXT' ? ' selected' : '') + '>TXT</option>' +
                    '    <option value="A"' + (type === 'A' ? ' selected' : '') + '>A</option>' +
                    '    <option value="CNAME"' + (type === 'CNAME' ? ' selected' : '') +
                    '>CNAME</option>' +
                    '  </select>' +
                    '</div>'
                );

                $(this).hide();
                $(this).siblings('.delete').hide();
                $(this).siblings('.save').show();
                $(this).siblings('.bt-cancel').show();
            });

            // Cancel editing of DNS record
            $('.bt-cancel').click(function() {
                var index = $(this).data('index');
                var $verificationText = $('#verificationText' + index);
                var originalContent = $verificationText.find('input').val();
                $verificationText.html(originalContent);

                var $verificationName = $('#verificationName' + index);
                var originalName = $verificationName.find('input').val();
                $verificationName.html(originalName);

                var $verificationType = $('#verificationType' + index);
                var originalType = $verificationType.find('select').val();
                $verificationType.html(originalType);

                $(this).hide();
                $(this).siblings('.save').hide();
                $(this).siblings('.edit').show();
                $(this).siblings('.delete').show();
            });

        });
    </script>
@endsection
