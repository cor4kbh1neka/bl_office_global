@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <form method="POST" action="/agentds/accessadd/store" class="sec_table">
        @csrf
        <div class="secgrouptitle">
            <h2>{{ $title }} </h2>
            <div class="kembali">
                <a href="/agentds/access">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                        <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"
                            d="M44 40.836c-4.893-5.973-9.238-9.362-13.036-10.168c-3.797-.805-7.412-.927-10.846-.365V41L4 23.545L20.118 7v10.167c6.349.05 11.746 2.328 16.192 6.833c4.445 4.505 7.009 10.117 7.69 16.836Z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="textkembali">Kembali</span>
                </a>
            </div>
        </div>
        <div class="seceditmemberds updateagent addagent">
            <div class="groupseceditmemberds">
                <div class="groupplayerinfo">
                    <div class="listgroupplayerinfo left small">
                        <div class="listplayerinfo">
                            <label for="name_access">access type name</label>
                            <div class="groupeditinput">
                                <input type="text" id="name_access" name="name_access" value=""
                                    placeholder="masukkan nama access type" required>
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
                                    <input type="checkbox" id="deposit" name="deposit" value="on">
                                </div>
                                <label for="deposit">view deposit</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="withdraw" name="withdraw" value="on">
                                </div>
                                <label for="withdraw">view withdraw</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="manual_transaction" name="manual_transaction" value="on">
                                </div>
                                <label for="manual_transaction">view manual transaction</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="history_coin" name="history_coin" value="on">
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
                                    <input type="checkbox" id="member_list" name="member_list" value="on">
                                </div>
                                <label for="member_list">view member list</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="member_seamless" name="member_seamless" value="on">
                                </div>
                                <label for="member_seamless">view member seamless</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="referral" name="referral" value="on">
                                </div>
                                <label for="referral">view referral</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="history_transaction" name="history_transaction"
                                        value="on">
                                </div>
                                <label for="history_transaction">view history transkasi</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="history_game" name="history_game" value="on">
                                </div>
                                <label for="history_game">view history game</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="member_outstanding" name="member_outstanding"
                                        value="on">
                                </div>
                                <label for="member_outstanding">view member outstanding</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="cashback_rollingan" name="cashback/rollingan"
                                        value="cashback/rollingan">
                                </div>
                                <label for="cashback_rollingan">view cashback/rollingan</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="report" name="report" value="on">
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
                                    <input type="checkbox" id="bank" name="bank" value="on">
                                </div>
                                <label for="bank">view bank</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="refeerral_bonus" name="refeerral_bonus" value="on">
                                </div>
                                <label for="refeerral_bonus">view bonus setting</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="memo" name="memo" value="on">
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
                                    <input type="checkbox" id="agent" name="agent" value="on">
                                </div>
                                <label for="agent">view agent</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="analytic" name="analytic" value="on">
                                </div>
                                <label for="analytic">view analytic</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="content" name="content" value="on">
                                </div>
                                <label for="content">view content</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="apk_setting" name="apk_setting" value="on">
                                </div>
                                <label for="apk_setting">view apk settings</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="memo_other" name="memo_other" value="on">
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
            </div>
        </div>
    </form>

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
@endsection
