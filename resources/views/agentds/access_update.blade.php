<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/utama/g21-icon.ico') }}" />
    <title>Dashboard | L21</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/design.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/custom_dash.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    {{-- <script>
        $(document).ready(function() {
            adjustElementSize();
        });
    </script> --}}
</head>
<div class="sec_table">
    <div class="secgrouptitle">
        <h2>{{ $title }} </h2>
    </div>
    <div class="seceditmemberds updateagent">
        <span class="titlebankmaster">leader-access</span>
        <form method="POST" action="/agentds/accessupdate/update" class="groupseceditmemberds">
            @csrf
            <div class="groupplayerinfo">
                <div class="listgroupplayerinfo left">
                    <div class="listplayerinfo">
                        <label for="name_access">access type name</label>
                        <div class="groupeditinput">
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <input type="text" id="name_access" name="name_access" value="{{ $data->name_access }}"
                                readonly placeholder="masukkan nama access type">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <spann class="titleeditmemberds">transaction</spann>
            <div class="groupplayerinfo">
                <div class="listgroupplayerinfo">
                    <div class="grouplistaccess">
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="deposit" name="deposit" value="on"
                                    {{ $data->deposit ? 'checked' : '' }}>
                            </div>
                            <label for="deposit">view deposit</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="withdraw" name="withdraw" value="on"
                                    {{ $data->withdraw ? 'checked' : '' }}>
                            </div>
                            <label for="withdraw">view withdraw</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="manual_transaction" name="manual_transaction" value="on"
                                    {{ $data->manual_transaction ? 'checked' : '' }}>
                            </div>
                            <label for="manual_transaction">view manual transaction</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="history_coin" name="history_coin" value="on"
                                    {{ $data->history_coin ? 'checked' : '' }}>
                            </div>
                            <label for="history_coin">view history coin</label>
                        </div>
                    </div>
                </div>
            </div>
            <spann class="titleeditmemberds">data</spann>
            <div class="groupplayerinfo">
                <div class="listgroupplayerinfo">
                    <div class="grouplistaccess">
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="member_list" name="member_list" value="on"
                                    {{ $data->member_list ? 'checked' : '' }}>
                            </div>
                            <label for="member_list">view member list</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="member_seamless" name="member_seamless" value="on"
                                    {{ $data->member_seamless ? 'checked' : '' }}>
                            </div>
                            <label for="member_seamless">view member seamless</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="referral" name="referral" value="on"
                                    {{ $data->referral ? 'checked' : '' }}>
                            </div>
                            <label for="referral">view referral</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="history_transaction" name="history_transaction"
                                    value="on" {{ $data->history_transaction ? 'checked' : '' }}>
                            </div>
                            <label for="history_transaction">view history transkasi</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="history_game" name="history_game" value="on"
                                    {{ $data->history_game ? 'checked' : '' }}>
                            </div>
                            <label for="history_game">view history game</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="member_outstanding" name="member_outstanding"
                                    value="on" {{ $data->member_outstanding ? 'checked' : '' }}>
                            </div>
                            <label for="member_outstanding">view member outstanding</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="cashback_rollingan" name="cashback_rollingan"
                                    value="on" {{ $data->cashback_rollingan ? 'checked' : '' }}>
                            </div>
                            <label for="cashback_rollingan">view cashback/rollingan</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="report" name="report" value="on"
                                    {{ $data->report ? 'checked' : '' }}>
                            </div>
                            <label for="report">view report</label>
                        </div>
                    </div>
                </div>
            </div>
            <spann class="titleeditmemberds">general config</spann>
            <div class="groupplayerinfo">
                <div class="listgroupplayerinfo">
                    <div class="grouplistaccess">
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="bank" name="bank" value="on"
                                    {{ $data->bank ? 'checked' : '' }}>
                            </div>
                            <label for="bank">view bank</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="refeerral_bonus" name="refeerral_bonus" value="on"
                                    {{ $data->refeerral_bonus ? 'checked' : '' }}>
                            </div>
                            <label for="refeerral_bonus">view bonus setting</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="memo" name="memo" value="on"
                                    {{ $data->memo ? 'checked' : '' }}>
                            </div>
                            <label for="memo">view memo</label>
                        </div>
                    </div>
                </div>
            </div>
            <spann class="titleeditmemberds">config admin</spann>
            <div class="groupplayerinfo">
                <div class="listgroupplayerinfo">
                    <div class="grouplistaccess">
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="agent" name="agent" value="on"
                                    {{ $data->agent ? 'checked' : '' }}>
                            </div>
                            <label for="agent">view agent</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="analytic" name="analytic" value="on"
                                    {{ $data->analytic ? 'checked' : '' }}>
                            </div>
                            <label for="analytic">view analytic</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="content" name="content" value="on"
                                    {{ $data->content ? 'checked' : '' }}>
                            </div>
                            <label for="content">view content</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="apk_setting" name="apk_setting" value="on"
                                    {{ $data->apk_setting ? 'checked' : '' }}>
                            </div>
                            <label for="apk_setting">view apk settings</label>
                        </div>
                        <div class="listaccess">
                            <div class="check_box">
                                <input type="checkbox" id="memo_other" name="memo_other" value="on"
                                    {{ $data->memo_other ? 'checked' : '' }}>
                            </div>
                            <label for="memo_other">memo to other user</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="listgroupplayerinfo right">
                <button class="tombol primary">
                    <span class="texttombol">SAVE DATA</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.groupeditinput svg').click(function() {
            $(this).closest('.groupeditinput').toggleClass('edit');
            $(this).siblings('input').prop('readonly', function(_, val) {
                return !val;
            });
        });
    });

    //checked checkbox
    $(document).ready(function() {
        if ($('.check_box input').val() === '1') {
            $('.check_box input').prop('checked', true);
        }
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
