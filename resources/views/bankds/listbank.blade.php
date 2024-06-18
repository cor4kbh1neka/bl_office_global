@extends('layouts.index')

@section('container')
    <!-- CSS SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- JavaScript SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>
        <div class="secbankds">
            <div class="groupsecbankds">
                <div class="headsecbankds">
                    <a href="/bankds" class="tombol grey">
                        <span class="texttombol">ACTIVE BANK</span>
                    </a>
                    <a href="/bankds/addbankmaster" class="tombol grey">
                        <span class="texttombol">ADD & SET MASTER</span>
                    </a>
                    <a href="/bankds/addgroupbank" class="tombol grey">
                        <span class="texttombol">ADD & SET GROUP</span>
                    </a>
                    <a href="/bankds/addbank" class="tombol grey">
                        <span class="texttombol">ADD & SET BANK</span>
                    </a>
                    <a href="/bankds/listmaster" class="tombol grey">
                        <span class="texttombol">LIST MASTER</span>
                    </a>
                    <a href="/bankds/listgroup" class="tombol grey">
                        <span class="texttombol">LIST GROUP</span>
                    </a>
                    <a href="/bankds/listbank/0/0" class="tombol grey active">
                        <span class="texttombol">LIST BANK</span>
                    </a>
                    <a href="/bankds/xdata" class="tombol grey">
                        <span class="texttombol">X DATA</span>
                    </a>
                </div>
                <div class="secgroupdatabankds">
                    <span class="titlebankmaster">LIST REKENING BANK</span>
                    <div class="groupactivebank">
                        <form method="POST" action="/bankds/updatelistbank" id="form-listbankdp" class="listgroupbank">
                            @csrf
                            <div class="grouptablebank frinput">
                                <table>
                                    <tbody>
                                        <tr class="titlelistgroupbank">
                                            <th colspan="6" class="texttitle">DEPOSIT</th>
                                        </tr>
                                        <tr>
                                            <th colspan="5">
                                                <div class="listinputmember">
                                                    <select class="inputnew" name="groupbank" id="groupbank">
                                                        <option value="" selected="" place=""
                                                            style="color: #838383; font-style: italic;" disabled="">pilih
                                                            group</option>
                                                        @foreach ($listgroupdp as $bank => $d)
                                                            <option value="{{ $bank }}"
                                                                {{ $bank == $group ? 'selected' : '' }}>
                                                                {{ $bank }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </th>
                                            <th colspan="1">
                                                <button type="button" id="tambahKolom" class="tombol primary">
                                                    <span class="texttombol">+ tambah</span>

                                                </button>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table id="listbankTable">
                                    <tbody>
                                        <tr class="thead listbanksd">
                                            <th class="bknomor">#</th>
                                            <th class="bkmaster">master</th>
                                            <th class="bknamabank">nama bank</th>
                                            <th class="bknomorrek">nomor rekening</th>
                                            <th class="bknamarek">ganti bank</th>
                                            <th class="bkbarcode">barcode</th>
                                            <th class="check_box">
                                                <input type="checkbox" id="myCheckboxDeposit" name="myCheckboxDeposit">
                                            </th>
                                            <th class="bkactionss">actions</th>
                                        </tr>
                                        @php $no = 0; @endphp
                                        @foreach ($listbankdp as $group => $d)
                                            @foreach ($d as $bank => $dt)
                                                @foreach ($dt['data_bank'] as $i => $dbank)
                                                    @php $no++ @endphp
                                                    <tr>
                                                        <td>{{ $no }}</td>
                                                        <td>{{ strtoupper($bank) }}</td>
                                                        <td>
                                                            <div class="listinputmember">
                                                                <select class="inputnew smallfont"
                                                                    name="banklama-{{ $dbank['idbank'] }}">
                                                                    <option value="{{ $dbank['idbank'] }}">
                                                                        {{ $dbank['namebankxxyy'] }} -
                                                                        {{ $dbank['xynamarekx'] }} -
                                                                        {{ $dbank['norekxyxy'] }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td class="ceonorek">{{ $dbank['norekxyxy'] }}</td>
                                                        <td>
                                                            <div class="listinputmember">
                                                                <select class="inputnew smallfont"
                                                                    name="bankbaru-{{ $dbank['idbank'] }}"
                                                                    id="bankmaster_{{ $no }}" data-jenis="1">
                                                                    <option value="">pilih Bank</option>
                                                                    @foreach ($listbankex as $listbank)
                                                                        <option value="{{ explode(' - ', $listbank)[0] }}">
                                                                            {{ substr($listbank, strpos($listbank, '-') + 2) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>

                                                        {{-- <td>{{ $dbank['xynamarekx'] }}</td> --}}
                                                        <td class="check_box xurlbarcode">
                                                            <input type="checkbox" id="urlbarcode" name="urlbarcode"
                                                                data-barcode="{{ $dbank['zwzwshowbarcode'] ? '1' : '' }}"
                                                                disabled>
                                                        </td>
                                                        <td class="check_box">
                                                            <input type="checkbox"
                                                                id="myCheckboxDeposit-{{ $dbank['idbank'] }}"
                                                                name="myCheckboxDeposit-{{ $dbank['idbank'] }}"
                                                                data-id="">
                                                        </td>
                                                        <td>
                                                            <div class="kolom_action">
                                                                <div class="dot_action">
                                                                    <span>•</span>
                                                                    <span>•</span>
                                                                    <span>•</span>
                                                                </div>
                                                                <div class="action_crud">
                                                                    <a
                                                                        href="/bankds/setbank/{{ $dbank['idbank'] }}/{{ $group }}">
                                                                        <div class="list_action">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1em" height="1em"
                                                                                viewBox="0 0 24 24">
                                                                                <g fill="none" stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2">
                                                                                    <path
                                                                                        d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                                                    <path
                                                                                        d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                                                </g>
                                                                            </svg>
                                                                            <span>Edit</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="#"
                                                                        onclick="confirmDelete('{{ $dbank['idbank'] }}', '{{ $group }}')">
                                                                        <div class="list_action">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1em" height="1em"
                                                                                viewBox="0 0 24 24">
                                                                                <path fill="currentColor"
                                                                                    d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                            </svg>
                                                                            <span>Delete</span>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <button class="tombol primary" id="updateButton">
                                <span class="texttombol">UPDATE</span>
                            </button>
                        </form>

                        <form method="POST" action="/bankds/updatelistbank/WD" class="listgroupbank"
                            id="form-listbankwd">
                            @csrf
                            <div class="grouptablebank frinput">
                                <table>
                                    <tbody>
                                        <tr class="titlelistgroupbank">
                                            <th colspan="6" class="texttitle">WITHDRAW</th>
                                        </tr>
                                        <tr>
                                            <th colspan="5">
                                                <div class="listinputmember">
                                                    <select class="inputnew" name="groupbank" id="groupbankwd">
                                                        <option value="" selected="" place=""
                                                            style="color: #838383; font-style: italic;" disabled="">
                                                            pilih group
                                                        </option>
                                                        @foreach ($listgroupwd as $bank => $d)
                                                            <option value="{{ $bank }}"
                                                                {{ $bank == $groupwd ? 'selected' : '' }}>
                                                                {{ $bank }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </th>
                                            <th colspan="1">
                                                <button type="button" id="tambahKolomWd" class="tombol primary">
                                                    <span class="texttombol">+ tambah</span>
                                                </button>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table id="listbankTableWd">
                                    <tbody>
                                        <tr class="thead listbanksd">
                                            <th class="bknomor">#</th>
                                            <th class="bkmaster">master</th>
                                            <th class="bknamabank">nama bank</th>
                                            <th class="bknomorrek">nomor rekening</th>
                                            <th class="bknomorrek">ganti bank</th>
                                            <th class="bkbarcode">barcode</th>
                                            <th class="check_box">
                                                <input type="checkbox" id="myCheckboxWithdraw" name="myCheckboxWithdraw">
                                            </th>
                                            <th class="bkactionss">actions</th>
                                        </tr>
                                        @php $nowd = 1; @endphp
                                        @foreach ($listbankwd as $group => $d)
                                            @foreach ($d as $bank => $dt)
                                                @foreach ($dt['data_bank'] as $dbank)
                                                    @php $nowd++ @endphp
                                                    <tr>
                                                        <td>{{ $nowd }}</td>
                                                        <td>{{ strtoupper($bank) }}</td>
                                                        <td>
                                                            <div class="listinputmember">
                                                                <select class="inputnew smallfont"
                                                                    name="banklama-{{ $dbank['idbank'] }}">
                                                                    <option value="{{ $dbank['idbank'] }}">
                                                                        {{ $dbank['namebankxxyy'] }} -
                                                                        {{ $dbank['xynamarekx'] }} -
                                                                        {{ $dbank['norekxyxy'] }}
                                                                    </option>
                                                                </select>
                                                            </div>

                                                        </td>
                                                        <td class="ceonorek">{{ $dbank['norekxyxy'] }}</td>
                                                        <td>
                                                            <div class="listinputmember">
                                                                <select class="inputnew smallfont"
                                                                    name="bankbaru-{{ $dbank['idbank'] }}"
                                                                    id="bankmaster_{{ $no }}" data-jenis="1">
                                                                    <option value="">pilih Bank</option>
                                                                    @foreach ($listbankexwd as $listbank)
                                                                        <option
                                                                            value="{{ explode(' - ', $listbank)[0] }}">
                                                                            {{ substr($listbank, strpos($listbank, '-') + 2) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td class="check_box xurlbarcode">
                                                            <input type="checkbox" id="urlbarcode" name="urlbarcode"
                                                                data-barcode="" disabled>
                                                        </td>
                                                        <td class="check_box">
                                                            <input type="checkbox"
                                                                id="myCheckboxWithdraw-{{ $dbank['idbank'] }}"
                                                                name="myCheckboxWithdraw-{{ $dbank['idbank'] }}"
                                                                data-id="">
                                                        </td>
                                                        <td>
                                                            <div class="kolom_action">
                                                                <div class="dot_action">
                                                                    <span>•</span>
                                                                    <span>•</span>
                                                                    <span>•</span>
                                                                </div>
                                                                <div class="action_crud">
                                                                    <a
                                                                        href="/bankds/setbank/{{ $dbank['idbank'] }}/{{ $group }}">
                                                                        <div class="list_action">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1em" height="1em"
                                                                                viewBox="0 0 24 24">
                                                                                <g fill="none" stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2">
                                                                                    <path
                                                                                        d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                                                    <path
                                                                                        d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                                                </g>
                                                                            </svg>
                                                                            <span>Edit</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="#"
                                                                        onclick="confirmDelete('{{ $dbank['idbank'] }}', '{{ $group }}')">
                                                                        <div class="list_action">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1em" height="1em"
                                                                                viewBox="0 0 24 24">
                                                                                <path fill="currentColor"
                                                                                    d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                            </svg>
                                                                            <span>Delete</span>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button class="tombol primary" id="updateButtonWd">
                                <span class="texttombol">UPDATE</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#myCheckboxDeposit').change(function() {
                var isChecked = $(this).is(':checked');

                $('tbody tr:not([style="display: none;"]) [id^="myCheckboxDeposit-"]').prop('checked',
                    isChecked);
            });
        });
        $(document).ready(function() {
            $('#myCheckboxDeposit, [id^="myCheckboxDeposit-"]').change(function() {
                var isChecked = $('#myCheckboxDeposit:checked, [id^="myCheckboxDeposit-"]:checked').length >
                    0;
                if (isChecked) {
                    $('.all_act_butt').css('display', 'flex');
                } else {
                    $('.all_act_butt').hide();
                }
            });

        });

        $(document).ready(function() {
            $('#myCheckboxWithdraw').change(function() {
                var isChecked = $(this).is(':checked');

                $('tbody tr:not([style="display: none;"]) [id^="myCheckboxWithdraw-"]').prop('checked',
                    isChecked);
            });
        });
        $(document).ready(function() {
            $('#myCheckboxWithdraw, [id^="myCheckboxWithdraw-"]').change(function() {
                var isChecked = $('#myCheckboxWithdraw:checked, [id^="myCheckboxWithdraw-"]:checked')
                    .length > 0;
                if (isChecked) {
                    $('.all_act_butt').css('display', 'flex');
                } else {
                    $('.all_act_butt').hide();
                }
            });

        });

        // checked radio button berdasarkan value dari status bank 1, 2, 3
        $(document).ready(function() {
            $('tr[data-chekcedbank]').each(function() {
                var checkedBankValue = $(this).attr('data-chekcedbank');
                $(this).find('.listgrpstatusbank input[type="radio"][value="' + checkedBankValue + '"]')
                    .prop('checked', true);
            });
        });

        // url barcode ada maka checked
        $(document).ready(function() {
            $('input[type="checkbox"][data-barcode]').each(function() {
                var barcodeURL = $(this).data('barcode');
                if (barcodeURL) {
                    $(this).prop('checked', true);
                }
            });
        });

        // notifikasi show barcode
        $(document).ready(function() {
            $('.xurlbarcode').click(function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Mengubah data ini harus di kolom edit',
                    showConfirmButton: false,
                });
            });
        });

        //format value norek
        $(document).ready(function() {
            $('.ceonorek').each(function() {
                var nomorRekElement = $(this);
                var nomorRekValue = nomorRekElement.text();

                var formattedNomorRek = nomorRekValue.replace(/^(\d{3})(\d{4})(\d{4})$/, '$1-$2-$3');
                formattedNomorRek = formattedNomorRek.replace(/^(\d{3})(\d{4})(\d{4})(\d{4})$/,
                    '$1-$2-$3-$4');

                nomorRekElement.text(formattedNomorRek);
            });
        });

        $(document).ready(function() {
            $('#groupbank, #groupbankwd').change(function() {
                var selectedGroup = $('#groupbank').val();
                var selectBankWd = $('#groupbankwd').val();

                selectedGroup = selectedGroup == null || selectedGroup == '' ? '0' : selectedGroup;
                selectBankWd = selectBankWd == null || selectBankWd == '' ? '0' : selectBankWd;

                var redirectUrl = '/bankds/listbank/' + selectedGroup + '/' + selectBankWd;
                window.location.href = redirectUrl;
            });
        });

        $(document).ready(function() {
            $('select[name="bankmaster"]').change(function() {
                var selectedValue = $(this).val();
                var jenis = $(this).data('jenis');

                $.ajax({
                    url: '/getGroupBank/' + selectedValue + '/' + jenis,
                    type: 'GET',
                    success: function(response) {

                        var selectElement = $('#namabank');

                        $.each(response, function(index, item) {
                            selectElement.append($('<option>', {
                                value: item,
                                text: item
                            }));
                        });
                    },
                    error: function(xhr, status, error) {
                        // console.error(xhr.responseText);
                        alert('Terjadi kesalahan saat melakukan permintaan GET.');
                    }
                });
            });
        });
    </script>


    <script>
        var counter = 1000;
        document.getElementById('tambahKolom').addEventListener('click', function() {
            var groupbank = document.getElementById("groupbank").value;
            if (groupbank != '') {
                var table = document.getElementById('listbankTable').getElementsByTagName('tbody')[0];
                var newRow = table.insertRow();
                newRow.id = 'newRow' + (++counter);

                newRow.innerHTML = `
        <td>-</td>
        <td>Empty</td>
        <td>Empty</td>
        <td>Empty</td>
        <td>
            <div class="listinputmember">
                <input type="hidden" name="banklama-${counter}" value="">
                <select class="inputnew smallfont"
                    name="bankbaru-${counter}" data-jenis="1" required>
                    <option value="">pilih Bank</option>
                    @foreach ($listbankex as $listbank)
                        <option value="{{ explode(' - ', $listbank)[0] }}">
                            {{ substr($listbank, strpos($listbank, '-') + 2) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </td>
        <td class="check_box xurlbarcode">
            <input type="checkbox" id="urlbarcode" name="urlbarcode"
                data-barcode=""
                disabled>
        </td>
        <td class="check_box">
            <input type="checkbox" id="myCheckboxDeposit-${counter}"
                name="myCheckboxDeposit-${counter}" data-id="" checked onclick="return false;">
        </td>
        <td>
            <button id="hapusKolom" class="tombol danger cancel">
                <span class="texttombol"> X </span>
            </button>
        </td>
    `;
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Mohon pilih sebuah grup terlebih dahulu.'
                });
            }
        });

        document.addEventListener('click', function(event) {
            if (event.target.matches('.tombol.danger') || event.target.matches('.tombol.danger .texttombol')) {
                var row = event.target.closest('tr');
                if (row) {
                    row.remove();
                }
            }
        });




        var counterWd = 2000;
        document.getElementById('tambahKolomWd').addEventListener('click', function() {
            var groupbankwd = document.getElementById("groupbankwd").value;
            if (groupbankwd != '') {
                var table = document.getElementById('listbankTableWd').getElementsByTagName('tbody')[0];
                var newRow = table.insertRow();

                newRow.id = 'newRow' + (++counterWd);

                newRow.innerHTML = `
        <td>-</td>
        <td>Empty</td>
        <td>Empty</td>
        <td>Empty</td>
        <td>
            <div class="listinputmember">
                <input type="hidden" name="banklama-${counterWd}" value="">
                <select class="inputnew smallfont"
                    name="bankbaru-${counterWd}" data-jenis="1" required>
                    <option value="">pilih Bank</option>
                    @foreach ($listbankexwd as $listbank)
                        <option value="{{ explode(' - ', $listbank)[0] }}">
                            {{ substr($listbank, strpos($listbank, '-') + 2) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </td>
        <td class="check_box xurlbarcode">
            <input type="checkbox" id="urlbarcode" name="urlbarcode"
                data-barcode=""
                disabled>
        </td>
        <td class="check_box">
            <input type="checkbox" id="myCheckboxWithdraw-${counterWd}"
                name="myCheckboxWithdraw-${counterWd}" data-id="" checked onclick="return false;">
        </td>
        <td>
            <button id="hapusKolom" class="tombol danger cancel">
                <span class="texttombol"> X </span>
            </button>
        </td>
    `;
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Mohon pilih sebuah grup terlebih dahulu.'
                });
            }
        });





        function confirmDelete(idbank, group) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus list bank ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteGroup(idbank, group);
                }
            });
        }

        function deleteGroup(idbank, group) {
            $.ajax({
                url: '/bankds/deletelistbank/' + idbank + '/' + group,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    // console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'List bank berhasil dihapus.'
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    // console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat menghapus data.'
                    });
                }
            });
        }

        $(document).ready(function() {
            $('#updateButton').click(function(event) {
                event.preventDefault();

                var checkboxes = $('input[type="checkbox"][id^="myCheckboxDeposit-"]');
                var checked = false;

                checkboxes.each(function() {
                    if ($(this).is(':checked')) {
                        checked = true;
                        return false;
                    }
                });

                if (!checked) {
                    Swal.fire({
                        title: 'Warning',
                        text: 'Anda harus memilih group lalu melakukan centang untuk melakukan update data!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                } else {
                    $('#form-listbankdp').submit();
                }
            });

            $('#updateButtonWd').click(function(event) {
                event.preventDefault();

                var checkboxes = $('input[type="checkbox"][id^="myCheckboxWithdraw-"]');
                var checked = false;

                checkboxes.each(function() {
                    if ($(this).is(':checked')) {
                        checked = true;
                        return false;
                    }
                });

                if (!checked) {
                    Swal.fire({
                        title: 'Warning',
                        text: 'Anda harus memilih group lalu melakukan centang untuk melakukan update data!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                } else {
                    $('#form-listbankwd').submit();
                }
            });
        });
    </script>

    @if (session('success'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                });
            });
        </script>
    @endif
@endsection
