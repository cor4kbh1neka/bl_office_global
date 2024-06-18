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
                    <a href="/bankds/addbank" class="tombol grey active">
                        <span class="texttombol">ADD & SET BANK</span>
                    </a>
                    <a href="/bankds/listmaster" class="tombol grey">
                        <span class="texttombol">LIST MASTER</span>
                    </a>
                    <a href="/bankds/listgroup" class="tombol grey">
                        <span class="texttombol">LIST GROUP</span>
                    </a>
                    <a href="/bankds/listbank/0/0" class="tombol grey">
                        <span class="texttombol">LIST BANK</span>
                    </a>
                    <a href="/bankds/xdata" class="tombol grey">
                        <span class="texttombol">X DATA</span>
                    </a>
                </div>

                <form method="POST" action="/bankds/updatedetailbank" class="secgroupdatabankds">
                    @csrf
                    @foreach ($data as $bank => $d)
                        <div class="groupsetbankmaster">
                            <span class="titlebankmaster">Edit Detail Bank</span>
                            <div class="groupplayerinfo">
                                <div class="listgroupplayerinfo left">
                                    <div class="listplayerinfo">
                                        <label for="masterbank">pilih master</label>
                                        <div class="groupeditinput">
                                            <input type="hidden" readonly id="idbank" name="idbank"
                                                value="{{ $d['idbank'] }}">
                                            <input type="hidden" readonly id="groupbank77" name="groupbank"
                                                value="{{ $groupbank }}">
                                                
                                            <select id="bankmaster" name="bankmaster" value="bca">
                                                @foreach ($dataBank as $db)
                                                    <option value="{{ $db['bnkmstrxyxyx'] }}"
                                                        {{ $bank == $db['bnkmstrxyxyx'] ? 'selected' : '' }}>
                                                        {{ $db['bnkmstrxyxyx'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="bankname">nama bank</label>
                                        <div class="groupnamabank">
                                            <div class="groupeditinput">
                                                <input type="hidden" readonly id="bankname_old" name="bankname_old"
                                                    value="{{ $d['namebankxxyy'] }}">
                                                <input type="text" readonly id="bankname" name="bankname"
                                                    value="{{ $d['namebankxxyy'] }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                                </svg>
                                            </div>
                                            <div class="groupeditinput">
                                                <select id="methode" name="methode">
                                                    <option value="bank"
                                                        {{ $d['yyxxmethod'] == 'bank' ? 'selected' : '' }}>bank</option>
                                                    <option value="ewallet"
                                                        {{ $d['yyxxmethod'] == 'ewallet' ? 'selected' : '' }}>ewallet
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" readonly id="namarek" name="namarek"
                                    value="{{ $d['xynamarekx'] }}">
                                    <input type="hidden" readonly id="nomorrek" name="nomorrek"
                                    value="{{ $d['norekxyxy'] }}">
                                    {{-- <div class="listplayerinfo">
                                        <label for="namarek">nama rekening</label>
                                        <div class="groupeditinput">
                                            <input type="text" readonly id="namarek" name="namarek"
                                                value="{{ $d['xynamarekx'] }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                            </svg>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="listplayerinfo">
                                        <label for="nomorrek">nomor rekening</label>
                                        <div class="groupeditinput">
                                            <input type="text" readonly id="nomorrek" name="nomorrek"
                                                value="{{ $d['norekxyxy'] }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                            </svg>
                                        </div>
                                    </div> --}}
                                    <div class="listplayerinfo">
                                        <label for="urlbarcode">url barcode</label>
                                        <div class="groupeditinput">
                                            <input type="text" readonly name="urlbarcode"
                                                value="{{ $d['barcodexrxr'] }}"
                                                placeholder="jika tidak ingin menampilkan barcode isi angka '0'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="listgroupplayerinfo right">
                                    <a href="#" class="tombol cancel delete-bank-button"
                                        data-idbank="{{ $d['idbank'] }}" data-bank="{{ $d['namebankxxyy'] }}">
                                        <span class="texttombol">
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                viewBox="0 0 48 48">
                                                <defs>
                                                    <mask id="ipSAdd0">
                                                        <g fill="none" stroke-linejoin="round" stroke-width="4">
                                                            <rect width="36" height="36" x="6" y="6"
                                                                fill="#fff" stroke="#fff" rx="3" />
                                                            <path stroke="#000" stroke-linecap="round"
                                                                d="M24 16v16m-8-8h16" />
                                                        </g>
                                                    </mask>
                                                </defs>
                                                <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSAdd0)" />
                                            </svg> --}}
                                            DELETE BANK
                                        </span>
                                    </a>
                                    <button class="tombol primary">
                                        <span class="texttombol">SAVE DATA</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </form>

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

        });

        // clear readonly
        $(document).ready(function() {
            $('.groupeditinput svg').click(function() {
                $(this).closest('.groupeditinput').toggleClass('edit');
                $(this).siblings('input').prop('readonly', function(_, val) {
                    return !val;
                });
            });
        });

        // checked radio button berdasarkan value dari status bank 1, 2, 3
        $(document).ready(function() {
            $('.groupradiooption[data-chekced]').each(function() {
                var checkedBankValue = $(this).attr('data-chekced');
                $(this).find('.listgrpstatusbank input[type="radio"][value="' + checkedBankValue + '"]')
                    .prop('checked', true);
            });
        });

        // dropdown selected
        $(document).ready(function() {
            var selectedValue = $('#groupbank').val();
            $('#groupbank option[value="' + selectedValue + '"]').attr('selected', 'selected');
        });

        //format value norek
        $(document).ready(function() {
            var nomorRekValue = $('#nomorrek').val();
            var formattedNomorRek = nomorRekValue.replace(/^(\d{3})(\d{4})(\d{4})(\d{4})(\d{4})(\d{4})(\d{4})/,
                    '$1-$2-$3-$4-$5-$6-$7')
                .replace(/^(\d{3})(\d{4})(\d{4})(\d{4})(\d{4})(\d{4})/, '$1-$2-$3-$4-$5-$6')
                .replace(/^(\d{3})(\d{4})(\d{4})(\d{4})(\d{4})/, '$1-$2-$3-$4-$5')
                .replace(/^(\d{3})(\d{4})(\d{4})(\d{4})/, '$1-$2-$3-$4')
                .replace(/^(\d{3})(\d{4})(\d{4})/, '$1-$2-$3')
                .replace(/^(\d{3})(\d{4})/, '$1-$2');
            $('#nomorrek').val(formattedNomorRek);

            $('#nomorrek').on('input', function() {
                var nomorRekValue = $(this).val();
                var cleanNomorRek = nomorRekValue.replace(/\D/g, '');
                var formattedNomorRek = cleanNomorRek.replace(
                        /^(\d{3})(\d{4})(\d{4})(\d{4})(\d{4})(\d{4})(\d{4})/, '$1-$2-$3-$4-$5-$6-$7')
                    .replace(/^(\d{3})(\d{4})(\d{4})(\d{4})(\d{4})(\d{4})/, '$1-$2-$3-$4-$5-$6')
                    .replace(/^(\d{3})(\d{4})(\d{4})(\d{4})(\d{4})/, '$1-$2-$3-$4-$5')
                    .replace(/^(\d{3})(\d{4})(\d{4})(\d{4})/, '$1-$2-$3-$4')
                    .replace(/^(\d{3})(\d{4})(\d{4})/, '$1-$2-$3')
                    .replace(/^(\d{3})(\d{4})/, '$1-$2');
                $(this).val(formattedNomorRek);
            });
        });

        $(document).ready(function() {
            $('.delete-bank-button').on('click', function(e) {
                e.preventDefault();

                let idbank = $(this).data('idbank');
                let bank = $(this).data('bank');

                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Anda tidak akan bisa mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/bankds/deletedetailbank',
                            type: 'POST',
                            data: {
                                idbank: idbank,
                                bank: bank,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: response.message,
                                        icon: 'success',
                                        timer: 3000,
                                        showConfirmButton: true
                                    }).then(() => {
                                        window.location.href =
                                            '/bankds/listbank/0/0';
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: response.message,
                                        icon: 'error',
                                        timer: 3000,
                                        showConfirmButton: true
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan: ' + xhr
                                        .responseText,
                                    icon: 'error',
                                    timer: 3000,
                                    showConfirmButton: true
                                });
                            }
                        });
                    }
                });
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
