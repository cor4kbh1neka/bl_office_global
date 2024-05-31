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
                    <a href="/bankds" class="tombol grey active">
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
                    <a href="/bankds/listbank/0/0" class="tombol grey">
                        <span class="texttombol">LIST BANK</span>
                    </a>
                    <a href="/bankds/xdata" class="tombol grey">
                        <span class="texttombol">X DATA</span>
                    </a>
                </div>
                <div class="secgroupdatabankds">
                    <span class="titlebankmaster">ACTIVE BANK</span>
                    <div class="groupactivebank">
                        <form method="POST" action="changestatusbank" id="form-depo" class="listgroupbank">
                            @csrf
                            <div class="grouptablebank">
                                <table>
                                    <tbody>
                                        <tr class="titlelistgroupbank">
                                            <th colspan="6" class="texttitle">DEPOSIT</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table>
                                    <tbody>
                                        <tr class="thead">
                                            <th class="bknomor">#</th>
                                            <th class="bknama">nama bank</th>
                                            <th class="bkonline">online bank</th>
                                            <th class="bkonline">offline bank</th>
                                            <th class="bkonline">trouble bank</th>
                                            <th class="check_box">
                                                <input type="checkbox" id="myCheckboxDeposit" name="myCheckboxDeposit">
                                            </th>
                                        </tr>
                                        @foreach ($data as $i => $d)
                                            <tr data-chekcedbank="{{ $d['statusxyxyy'] }}" class="chekcedbank">
                                                <td>{{ $i + 1 }}</td>
                                                <td class="tdnamabank">{{ $d['bnkmstrxyxyx'] }}
                                                    <input type="hidden" name="wdstatusxyxyy_{{ $d['bnkmstrxyxyx'] }}"
                                                        value="{{ $d['wdstatusxyxyy'] }}">
                                                    <input type="hidden" name="bnkmstrxyxyx_{{ $d['bnkmstrxyxyx'] }}"
                                                        value="{{ $d['bnkmstrxyxyx'] }}">
                                                    <input type="hidden" name="urllogoxxyx_{{ $d['bnkmstrxyxyx'] }}"
                                                        value="{{ $d['urllogoxxyx'] }}">
                                                </td>
                                                <td>
                                                    <div class="listgrpstatusbank">
                                                        <input class="status_online" type="radio"
                                                            id="depo_online_{{ $d['bnkmstrxyxyx'] }}"
                                                            name="statusdepo_{{ $d['bnkmstrxyxyx'] }}" value=1>
                                                        <label for="depo_online_{{ $d['bnkmstrxyxyx'] }}">online</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="listgrpstatusbank">
                                                        <input class="status_offline" type="radio"
                                                            id="depo_offline_{{ $d['bnkmstrxyxyx'] }}"
                                                            name="statusdepo_{{ $d['bnkmstrxyxyx'] }}" value=2>
                                                        <label for="depo_offline_{{ $d['bnkmstrxyxyx'] }}">offline</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="listgrpstatusbank">
                                                        <input class="status_trouble" type="radio"
                                                            id="depo_trouble_{{ $d['bnkmstrxyxyx'] }}"
                                                            name="statusdepo_{{ $d['bnkmstrxyxyx'] }}" value=3>
                                                        <label for="depo_trouble_{{ $d['bnkmstrxyxyx'] }}">trouble</label>
                                                    </div>
                                                </td>
                                                <td class="check_box"
                                                    onclick="toggleCheckbox('myCheckboxDeposit-{{ $d['bnkmstrxyxyx'] }}')">
                                                    <input type="checkbox" id="myCheckboxDeposit-{{ $d['bnkmstrxyxyx'] }}"
                                                        name="myCheckboxDeposit-{{ $d['bnkmstrxyxyx'] }}"
                                                        data-id="{{ $d['bnkmstrxyxyx'] }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button class="tombol primary">
                                <span class="texttombol">UPDATE</span>
                            </button>
                        </form>

                        <form method="POST" action="changestatusbank/WD" id="form-wd" class="listgroupbank">
                            @csrf
                            <div class="grouptablebank">
                                <table>
                                    <tbody>
                                        <tr class="titlelistgroupbank">
                                            <th colspan="6" class="texttitle">WITHDRAW</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table>
                                    <tbody>
                                        <tr class="thead">
                                            <th class="bknomor">#</th>
                                            <th class="bknama">nama bank</th>
                                            <th class="bkonline">online bank</th>
                                            <th class="bkonline">offline bank</th>
                                            <th class="bkonline">trouble bank</th>
                                            <th class="check_box">
                                                <input type="checkbox" id="myCheckboxWithdraw" name="myCheckboxWithdraw">
                                            </th>
                                        </tr>
                                        @foreach ($data as $i => $d)
                                            <tr data-chekcedbank="{{ $d['wdstatusxyxyy'] }}" class="chekcedbank">
                                                <td>{{ $i + 1 }}</td>
                                                <td class="tdnamabank">{{ $d['bnkmstrxyxyx'] }}
                                                    <input type="hidden" name="statusxyxyy_{{ $d['bnkmstrxyxyx'] }}"
                                                        value="{{ $d['statusxyxyy'] }}" value="{{ $d['statusxyxyy'] }}">
                                                    <input type="hidden" name="bnkmstrxyxyx_{{ $d['bnkmstrxyxyx'] }}"
                                                        value="{{ $d['bnkmstrxyxyx'] }}">
                                                    <input type="hidden" name="urllogoxxyx_{{ $d['bnkmstrxyxyx'] }}"
                                                        value="{{ $d['urllogoxxyx'] }}">
                                                </td>
                                                <td>
                                                    <div class="listgrpstatusbank">
                                                        <input class="status_online" type="radio"
                                                            id="wd_online_{{ $d['bnkmstrxyxyx'] }}"
                                                            name="statuswd_{{ $d['bnkmstrxyxyx'] }}" value=1>
                                                        <label for="wd_online_{{ $d['bnkmstrxyxyx'] }}">online</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="listgrpstatusbank">
                                                        <input class="status_offline" type="radio"
                                                            id="wd_offline_{{ $d['bnkmstrxyxyx'] }}"
                                                            name="statuswd_{{ $d['bnkmstrxyxyx'] }}" value=2>
                                                        <label for="wd_offline_{{ $d['bnkmstrxyxyx'] }}">offline</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="listgrpstatusbank">
                                                        <input class="status_trouble" type="radio"
                                                            id="wd_trouble_{{ $d['bnkmstrxyxyx'] }}"
                                                            name="statuswd_{{ $d['bnkmstrxyxyx'] }}" value=3>
                                                        <label for="wd_trouble_{{ $d['bnkmstrxyxyx'] }}">trouble</label>
                                                    </div>
                                                </td>
                                                <td class="check_box"
                                                    onclick="toggleCheckbox('myCheckboxWithdraw-{{ $d['bnkmstrxyxyx'] }}')">
                                                    <input type="checkbox"
                                                        id="myCheckboxWithdraw-{{ $d['bnkmstrxyxyx'] }}"
                                                        name="myCheckboxWithdraw-{{ $d['bnkmstrxyxyx'] }}"
                                                        data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <button class="tombol primary">
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

        $(document).ready(function() {
            $('input[type="radio"]').click(function() {
                $(this).closest('tr').find('.check_box input[type="checkbox"]').prop('checked', true);
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
@endsection
