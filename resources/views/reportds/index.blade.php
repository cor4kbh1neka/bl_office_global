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
        {{-- @dd($data); --}}
        <div class="secreportds">
            <div class="groupsecreportds">
                <div class="headsecreportds">
                    <a href="/reportds" class="tombol grey active">
                        <span class="texttombol">WIN LOSE MEMBER</span>
                    </a>
                    <a href="/reportds/winlosematch" class="tombol grey">
                        <span class="texttombol">WIN LOSE MATCH</span>
                    </a>
                    <a href="/reportds/towl" class="tombol grey">
                        <span class="texttombol">TURN OVER & WIN LOSE</span>
                    </a>
                    {{-- <a href="/reportds/memberstatement" class="tombol grey">
                        <span class="texttombol">STATEMENT</span>
                    </a> --}}
                </div>
                <div class="groupdatareportds">
                    <div class="grouphistoryds memberlist">
                        <div class="groupheadhistoryds">
                            <form method="GET" action="/reportds" class="listmembergroup">

                                {{-- <div class="listinputmember">
                                    <label for="username">username</label>
                                    <input type="text" id="username" name="username" placeholder="username">
                                </div>
                                <div class="listinputmember">
                                    <label for="gabungdari">tanggal dari</label>
                                    <input type="date" id="gabungdari" name="gabungdari" placeholder="tanggal gabung dari">
                                </div>
                                <div class="listinputmember">
                                    <label for="gabunghingga">tanggal hingga</label>
                                    <input type="date" id="gabunghingga" name="tanggal gabung hingga" placeholder="nama rekening">
                                </div> --}}
                                <div class="listinputmember">
                                    <label for="username">username <span class="required">*</span></label>
                                    <input type="text" name="username" id="username"
                                        placeholder="username (wajib di isi)" value="{{ $username }}" required>
                                </div>
                                <div class="listinputmember">
                                    <label for="portfolio">jenis game <span class="required">*</span></label>
                                    <select name="portfolio" id="portfolio" required>
                                        <option value="" style="color: #838383; font-style: italic;" disabled=""
                                            selected>
                                            pilih
                                            jenis</option>
                                        <option value="SportsBook" {{ $portfolio == 'SportsBook' ? 'selected' : '' }}>
                                            SportsBook
                                        </option>
                                        <option value="VirtualSports" {{ $portfolio == 'VirtualSports' ? 'selected' : '' }}>
                                            VirtualSports
                                        </option>
                                        <option value="Games" {{ $portfolio == 'Games' ? 'selected' : '' }}>Games</option>
                                        <option value="SeamlessGame" {{ $portfolio == 'SeamlessGame' ? 'selected' : '' }}>
                                            SeamlessGame</option>
                                    </select>
                                </div>
                                <div class="listinputmember">
                                    <label for="startDate">dari <span class="required">*</span></label>
                                    <input type="date" name="startDate" id="startDate" value="{{ $startDate }}"
                                        required>
                                </div>
                                <div class="listinputmember">
                                    <label for="endDate">hingga <span class="required">*</span></label>
                                    <input type="date" name="endDate" id="endDate" value="{{ $endDate }}"
                                        required>
                                </div>
                                <div class="listinputmember">
                                    <button class="tombol primary">
                                        <span class="texttombol">SUBMIT</span>
                                    </button>
                                </div>
                                <div class="exportdata">
                                    <span class="textdownload">download</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                    </svg>
                                </div>
                            </form>
                        </div>
                        <div class="tabelproses">
                            {{-- <table>
                                <tbody>
                                    <tr class="hdtable">
                                        <th class="bagtotal" rowspan="2">total</th>
                                        <th class="bagamount" rowspan="2">amount</th>
                                        <th class="bagvalidamount" rowspan="2">valid amount</th>
                                        <th class="baggrosscom" rowspan="2">gross com</th>
                                        <th class="bagmember" colspan="4">member</th>
                                        <th class="bagcompany" colspan="4">company</th>
                                    </tr>
                                    <tr class="hdtable">
                                        <th>referral</th>
                                        <th>W/L</th>
                                        <th>com</th>
                                        <th>W/L + com</th>
                                        <th>referral</th>
                                        <th>W/L</th>
                                        <th>com</th>
                                        <th>W/L + com</th>
                                    </tr>
                                    <tr>
                                        <td>From 4/23/2024 To 04/24/2024</td>
                                        <td class="datacc" data-get="145703"></td>
                                        <td class="datacc" data-get="0"></td>
                                        <td class="datacc" data-get="13399.48"></td>
                                        <td class="datacc" data-get="6500"></td>
                                        <td class="datacc" data-get="13399.48"></td>
                                        <td class="datacc" data-get="6899.48"></td>
                                        <td class="datacc" data-get="20298.96"></td>
                                        <td class="datacc" data-get="6500"></td>
                                        <td class="datacc" data-get="13399.48"></td>
                                        <td class="datacc" data-get="6899.48"></td>
                                        <td class="datacc" data-get="20298.96"></td>
                                    </tr>
                                </tbody>
                            </table> --}}
                            <table>
                                <tbody>
                                    <tr class="hdtable">
                                        <th class="bagno" rowspan="2">#</th>
                                        <th class="baguser" rowspan="2">username</th>
                                        <th class="bagcurr" rowspan="2">curr</th>
                                        <th class="bagamount" rowspan="2">amount</th>
                                        <th class="bagvalidamount" rowspan="2">valid amount</th>
                                        <th class="baggrosscom" rowspan="2">gross com</th>
                                        <th class="bagmember" colspan="4">member</th>
                                        <th class="bagcompany" colspan="4">company</th>
                                    </tr>
                                    <tr class="hdtable">
                                        <th>referral</th>
                                        <th>W/L</th>
                                        <th>com</th>
                                        <th>W/L + com</th>
                                        <th>referral</th>
                                        <th>W/L</th>
                                        <th>com</th>
                                        <th>W/L + com</th>
                                    </tr>

                                    @foreach ($data as $i => $d)
                                    
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $d['username'] }}</td>
                                            <td>IDR</td>
                                            <td class="datacc" data-get="{{ $d['amount'] }}"></td>
                                            <td class="datacc" data-get="0"></td>
                                            <td class="datacc" data-get="{{ $d['commission'] }}"></td>
                                            <td class="datacc" data-get="{{ $d['referral'] }}"></td>
                                            <td class="datacc" data-get="{{ $d['winlose'] }}"></td>
                                            <td class="datacc" data-get="{{ $d['commission'] }}"></td>
                                            <td class="datacc"
                                                data-get="{{ $d['winlose'] + $d['commission'] + $d['referral'] }}"></td>
                                            <td class="datacc" data-get="{{ -$d['referral'] }}"></td>
                                            <td class="datacc"
                                                data-get="{{ $d['winlose'] < 0 ? abs($d['winlose']) : -$d['winlose'] }}">
                                            </td>
                                            <td class="datacc" data-get="{{ $d['commission'] }}"></td>
                                            <td class="datacc"
                                                data-get="{{ $d['winlose'] + $d['commission'] + $d['referral'] < 0 ? abs($d['winlose'] + $d['commission'] + $d['referral']) : -($d['winlose'] + $d['commission'] + $d['referral']) }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="grouppagination" style="padding: 25px;">
                                
                            </div>
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
        });

        // print nilai td
        $(document).ready(function() {
            $('.datacc').each(function() {
                var value = parseFloat($(this).attr('data-get')).toFixed(2);
                var formattedValue = numberWithCommas(value);
                $(this).text(formattedValue);
            });
        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
@endsection
