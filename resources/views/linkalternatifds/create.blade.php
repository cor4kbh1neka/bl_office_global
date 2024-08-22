@extends('layouts.index')

@section('container')
    <style>
        .groupdatasecagentds .tabelproses .actiondetail {
            width: 5%;
        }
    </style>
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>Add New Agent</h2>
            <div class="kembali">
                <a href="/linkalternatifds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                        <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"
                            d="M44 40.836c-4.893-5.973-9.238-9.362-13.036-10.168c-3.797-.805-7.412-.927-10.846-.365V41L4 23.545L20.118 7v10.167c6.349.05 11.746 2.328 16.192 6.833c4.445 4.505 7.009 10.117 7.69 16.836Z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="textkembali">Kembali</span>
                </a>
            </div>
        </div>
        <div class="secagentds">
            <div class="groupsecagentds">
                <span class="titlebankmaster">Tambah Link</span>
                <form method="POST" action="/linkalternatifds/store" id="form-linkalternatifds" class="groupplayerinfo">
                    @csrf
                    <div class="listgroupplayerinfo left">
                        <div class="listplayerinfo">
                            <label for="link">Link</label>
                            <div class="groupeditinput">
                                <span class="texttombol">https://</span>
                                <input type="text" id="link" name="link" value="{{ $link }}"
                                    placeholder="masukkan nama agent" required {{ $step == 'edit' ? 'disabled' : '' }}>
                            </div>
                        </div>
                    </div>
                    <div class="listgroupplayerinfo right solo">
                        @if ($step == 'create')
                            <button type="submit" class="tombol primary">
                                <span class="texttombol">SAVE DATA</span>
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if ($step == 'edit')
            <div class="secagentds" style="padding-bottom: 10px">
                <div class="groupsecagentds">
                    <span class="titlebankmaster">CLOUDFLARE NAMESERVER</span>
                    <div class="groupdatasecagentds">
                        <div class="tabelproses" style="margin-bottom: 5px">
                            <table>
                                <tbody>
                                    <tr class="hdtable">
                                        <th class="bagiplogin">Type</th>
                                        <th class="baglogininfo">Value</th>
                                    </tr>
                                    @foreach ($datans['name_servers'] as $index => $item)
                                        <tr>
                                            <td>NS {{ $index + 1 }}</td>
                                            <td>
                                                {{ $item }}
                                                <button class="copyButton"
                                                    style="border: none; background: none; cursor: pointer; padding-left: 5px; position: relative;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                                        role="img" width="1em" height="1em"
                                                        viewBox="0 0 2048 2048">
                                                        <path fill="currentColor"
                                                            d="M2048 0v1664h-384v384H0V384h384V0zm-128 1536V128H512v256h256v128H128v1408h1408v-640h128v256zm-979-339l-90-90l594-595h-421V384h640v640h-128V603z">
                                                        </path>
                                                    </svg>
                                                    <span class="tooltip"
                                                        style="visibility: hidden; background-color: black; color: #fff; text-align: center; border-radius: 5px; padding: 5px; position: absolute; z-index: 1; bottom: 125%; left: 50%; transform: translateX(-50%); white-space: nowrap;">Copied!</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="secagentds">
                <div class="groupsecagentds">
                    <span class="titlebankmaster">DNS MANAGEMENT</span>
                    <div class="groupdatasecagentds">
                        <div class="tabelproses" style="margin-bottom: 5px">
                            <table id="table-DNS">
                                <tbody>
                                    <tr class="hdtable">
                                        <th class="bagiplogin">Type</th>
                                        <th class="baglogininfo">Content</th>
                                        <th class="actiondetail">
                                            <button class="tombol proses" type="button" id="addRowButton">
                                                <span class="texttombol">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                        viewBox="0 0 48 48">
                                                        <defs>
                                                            <mask id="ipSAdd0">
                                                                <g fill="none" stroke-linejoin="round" stroke-width="4">
                                                                    <rect width="36" height="36" x="6" y="6"
                                                                        fill="#fff" stroke="#fff" rx="3"></rect>
                                                                    <path stroke="#000" stroke-linecap="round"
                                                                        d="M24 16v16m-8-8h16"></path>
                                                                </g>
                                                            </mask>
                                                        </defs>
                                                        <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSAdd0)">
                                                        </path>
                                                    </svg>
                                                    ADD
                                                </span>
                                            </button>
                                        </th>
                                    </tr>
                                    @foreach ($datadns as $index => $item)
                                        <tr>
                                            <td>{{ $item['type'] }}</td>
                                            <td id="verificationText{{ $index }}">{{ $item['content'] }}</td>
                                            <td>
                                                <div class="grouptools">
                                                    <button type="button" class="tombol primary edit"
                                                        data-index="{{ $index }}">
                                                        <span class="texttombol">EDIT</span>
                                                    </button>
                                                    <button type="button" class="tombol cancel delete"
                                                        data-zoneid="{{ $zoneid }}" data-id="{{ $item['id'] }}">
                                                        <span class="texttombol">DELETE</span>
                                                    </button>
                                                    <button type="button" class="tombol proses save"
                                                        data-index="{{ $index }}"
                                                        data-zoneid="{{ $zoneid }}" data-id="{{ $item['id'] }}"
                                                        data-name="{{ $item['name'] }}" style="display: none;">
                                                        <span class="texttombol">SAVE</span>
                                                    </button>
                                                    <button type="button" class="tombol cancel bt-cancel"
                                                        data-index="{{ $index }}" style="display: none;">
                                                        <span class="texttombol">CANCEL</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

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
        });

        $(document).ready(function() {
            // Copy text to clipboard and show tooltip
            $('.copyButton').click(function() {
                var textToCopy = $(this).parent().text().trim();
                var $temp = $('<input>');
                $('body').append($temp);
                $temp.val(textToCopy).select();
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
                            </select>
                        </td>
                        <td>
                            <input type="text" class="content-input" name="content" value="" placeholder="masukkan nama agent">
                        </td>
                        <td>
                            <div class="grouptools">
                                <button class="tombol proses save-new" data-zoneid="{{ $zoneid }}" data-link="{{ $link }}">
                                    <span class="texttombol">SAVE</span>
                                </button>
                                <button class="tombol danger cancel hapusKolom">
                                    <span class="texttombol"> X </span>
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

                $verificationText.html('<input type="text" class="form-control" value="' + content + '">');
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

                $(this).hide();
                $(this).siblings('.save').hide();
                $(this).siblings('.edit').show();
                $(this).siblings('.delete').show();
            });

            // Save updated DNS record
            $('.save').click(function() {
                var index = $(this).data('index');
                var zoneid = $(this).data('zoneid');
                var name = $(this).data('name');
                var id = $(this).data('id');
                var $verificationText = $('#verificationText' + index);
                var newContent = $verificationText.find('input').val();

                $.ajax({
                    url: '/linkalternatifds/updatedns',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        zoneid: zoneid,
                        id: id,
                        name: name,
                        content: newContent
                    },
                    success: function(response) {
                        $verificationText.html(newContent);
                        $('.save').hide();
                        $('.bt-cancel').hide();
                        $('.edit').show();
                        $('.delete').show();

                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Konten berhasil diperbarui.',
                            icon: 'success',
                            confirmButtonText: 'OK'
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
                const content = $row.find('input[name="content"]').val().trim();
                const data = {
                    _token: csrfToken,
                    zoneid: $(this).data('zoneid'),
                    type: $row.find('select[name="type"]').val(),
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
        });
    </script>
@endsection
