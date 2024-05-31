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
                <div class="secgroupdatabankds">
                    <form method="POST" action="/storebank" class="groupsetbankmaster">
                        @csrf
                        <span class="titlebankmaster">Add Detail Bank</span>
                        <div class="listgroupplayerinfo left">
                            <div class="listplayerinfo">
                                <label for="masterbank">pilih master</label>
                                <div class="groupeditinput">
                                    <select id="bankmaster" name="masterbnkxyxt" value="bca" required>
                                        <option value="bca">bca</option>
                                        <option value="bni">bni</option>
                                        <option value="bri">bri</option>
                                        <option value="mandiri">mandiri</option>
                                        <option value="cimb">cimb</option>
                                        <option value="danamon">danamon</option>
                                        <option value="panin">panin</option>
                                        <option value="cimb">cimb</option>
                                        <option value="permata">permata</option>
                                        <option value="bsi">bsi</option>
                                        <option value="dana">dana</option>
                                        <option value="gopay">gopay</option>
                                        <option value="ovo">ovo</option>
                                        <option value="pulsa">pulsa</option>
                                        <option value="linkaja">linkaja</option>
                                        <option value="qris">qris</option>
                                    </select>
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="bankname">nama bank</label>
                                <div class="groupnamabank">
                                    <div class="groupeditinput">
                                        <input type="text" id="bankname" name="namebankxxyy" value=""
                                            placeholder="masukkan nama bank" required>
                                    </div>
                                    <div class="groupeditinput">
                                        <select id="methode" name="yyxxmethod" value="bank" required>
                                            <option value="" selected="" place=""
                                                style="color: #838383; font-style: italic;" disabled="">pilih methode
                                            </option>
                                            <option value="bank">bank</option>
                                            <option value="ewallet">ewallet</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="namarek">nama rekening</label>
                                <div class="groupeditinput">
                                    <input type="text" id="namarek" name="xynamarekx" value=""
                                        placeholder="masukkan nama rekening" required>
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="nomorrek">nomor rekening</label>
                                <div class="groupeditinput">
                                    <input type="text" id="nomorrek" name="norekxyxy" value=""
                                        placeholder="masukkan nomor rekening" required>
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="urlbarcode">url barcode</label>
                                <div class="groupeditinput">
                                    <input type="text" id="urlbarcode" name="barcodexrxr" value=""
                                        placeholder="jika tidak ingin menampilkan barcode isi angka '0'" required>
                                </div>
                            </div>
                        </div>
                        <div class="listgroupplayerinfo right solo">
                            <button class="tombol primary">
                                <span class="texttombol">SAVE DATA</span>
                            </button>
                        </div>
                    </form>
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
    </script>
@endsection
