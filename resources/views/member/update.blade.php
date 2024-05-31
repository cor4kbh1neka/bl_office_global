@extends('layouts.index')

@section('container')
    <div class="sec_box hgi-100">
        <form action="/member/updatemember" method="POST" enctype="multipart/form-data" id="form-member">
            @csrf
            <div class="sec_form">
                <div class="sec_head_form">
                    <h3>{{ $title }}</h3>
                    <span>PLAYER INFORATION</span>
                </div>
                <div class="list_form">
                    <span class="sec_label">USER ID</span>
                    <input type="text" id="xyusernamexxy" name="xyusernamexxy" placeholder="Masukkan Username"
                        value="{{ $dataUser['xyusernamexxy'] }}" readonly required>
                </div>
                <div class="list_form">
                    <span class="sec_label">NAMA BANK</span>
                    <select id="xybanknamexyy" name="xybanknamexyy">
                        <option value="" class="pilihbank">Pilih Bank</option>
                        <option value="bri" {{ $dataUser['xybanknamexyy'] == 'bri' ? 'selected' : '' }}>bri</option>
                        <option value="bca" {{ $dataUser['xybanknamexyy'] == 'bca' ? 'selected' : '' }}>bca</option>
                        <option value="bca digital" {{ $dataUser['xybanknamexyy'] == 'bca digital' ? 'selected' : '' }}>bca
                            digital
                        </option>
                        <option value="sakuku" {{ $dataUser['xybanknamexyy'] == 'sakuku' ? 'selected' : '' }}>sakuku
                        </option>
                        <option value="bni" {{ $dataUser['xybanknamexyy'] == 'bni' ? 'selected' : '' }}>bni</option>
                        <option value="mandiri" {{ $dataUser['xybanknamexyy'] == 'mandiri' ? 'selected' : '' }}>mandiri
                        </option>
                        <option value="permata" {{ $dataUser['xybanknamexyy'] == 'permata' ? 'selected' : '' }}>permata
                        </option>
                        <option value="panin" {{ $dataUser['xybanknamexyy'] == 'panin' ? 'selected' : '' }}>panin
                        </option>
                        <option value="danamon" {{ $dataUser['xybanknamexyy'] == 'danamon' ? 'selected' : '' }}>danamon
                        </option>
                        <option value="cimb niaga" {{ $dataUser['xybanknamexyy'] == 'cimb niaga' ? 'selected' : '' }}>cimb
                            niaga</option>
                        <option value="bsi" {{ $dataUser['xybanknamexyy'] == 'bsi' ? 'selected' : '' }}>bsi
                        </option>
                        <option value="maybank" {{ $dataUser['xybanknamexyy'] == 'maybank' ? 'selected' : '' }}>maybank
                        </option>
                        <option value="bank jenius" {{ $dataUser['xybanknamexyy'] == 'bank jenius' ? 'selected' : '' }}>
                            bank
                            jenius</option>
                        <option value="bank jago" {{ $dataUser['xybanknamexyy'] == 'bank jago' ? 'selected' : '' }}>bank
                            jago</option>
                        <option value="seabank" {{ $dataUser['xybanknamexyy'] == 'seabank' ? 'selected' : '' }}>seabank
                        </option>
                        <option value="dana" {{ $dataUser['xybanknamexyy'] == 'dana' ? 'selected' : '' }}>dana
                        </option>
                        <option value="ovo" {{ $dataUser['xybanknamexyy'] == 'ovo' ? 'selected' : '' }}>ovo</option>
                        <option value="gopay" {{ $dataUser['xybanknamexyy'] == 'gopay' ? 'selected' : '' }}>gopay</option>
                        <option value="linkaja" {{ $dataUser['xybanknamexyy'] == 'linkaja' ? 'selected' : '' }}>linkaja
                        </option>
                        <option value="shopeepay" {{ $dataUser['xybanknamexyy'] == 'shopeepay' ? 'selected' : '' }}>
                            shopeepay
                        </option>
                        <option value="bank kalbar" {{ $dataUser['xybanknamexyy'] == 'bank kalbar' ? 'selected' : '' }}>
                            bank
                            kalbar</option>
                        <option value="bank bpd aceh"
                            {{ $dataUser['xybanknamexyy'] == 'bank bpd aceh' ? 'selected' : '' }}>
                            bank bpd aceh</option>
                        <option value="bank btn" {{ $dataUser['xybanknamexyy'] == 'bank btn' ? 'selected' : '' }}>bank
                            btn</option>
                        <option value="allobank" {{ $dataUser['xybanknamexyy'] == 'allobank' ? 'selected' : '' }}>allobank
                        </option>
                        <option value="bank btpn" {{ $dataUser['xybanknamexyy'] == 'bank btpn' ? 'selected' : '' }}>bank
                            btpn</option>
                        <option value="bpd kalteng" {{ $dataUser['xybanknamexyy'] == 'bpd kalteng' ? 'selected' : '' }}>bpd
                            kalteng</option>
                        <option value="keb hana" {{ $dataUser['xybanknamexyy'] == 'keb hana' ? 'selected' : '' }}>keb
                            hana</option>
                        <option value="shinhan bank" {{ $dataUser['xybanknamexyy'] == 'shinhan bank' ? 'selected' : '' }}>
                            shinhan bank</option>
                        <option value="arta graha" {{ $dataUser['xybanknamexyy'] == 'arta graha' ? 'selected' : '' }}>arta
                            graha</option>
                        <option value="bank aceh" {{ $dataUser['xybanknamexyy'] == 'bank aceh' ? 'selected' : '' }}>bank
                            aceh</optzion>
                        <option value="bank bjb" {{ $dataUser['xybanknamexyy'] == 'bank bjb' ? 'selected' : '' }}>bank bjb
                        </option>
                        <option value="bank papua" {{ $dataUser['xybanknamexyy'] == 'bank papua' ? 'selected' : '' }}>bank
                            papua</option>
                        <option value="bank kalsel" {{ $dataUser['xybanknamexyy'] == 'bank kalsel' ? 'selected' : '' }}>
                            bank
                            kalsel</option>
                        <option value="bpd kaltim" {{ $dataUser['xybanknamexyy'] == 'bpd kaltim' ? 'selected' : '' }}>bpd
                            kaltim</option>
                        <option value="bank aladin" {{ $dataUser['xybanknamexyy'] == 'bank aladin' ? 'selected' : '' }}>
                            bank
                            aladin</option>
                        <option value="bank aladin syariah"
                            {{ $dataUser['xybanknamexyy'] == 'bank aladin syariah' ? 'selected' : '' }}>bank aladin syariah
                        </option>
                        <option value="bank bpdm ambon"
                            {{ $dataUser['xybanknamexyy'] == 'bank bpdm ambon' ? 'selected' : '' }}>bank bpdm ambon
                        </option>
                        <option value="bank bukopin" {{ $dataUser['xybanknamexyy'] == 'bank bukopin' ? 'selected' : '' }}>
                            bank bukopin</option>
                        <option value="bank raya" {{ $dataUser['xybanknamexyy'] == 'bank raya' ? 'selected' : '' }}>bank
                            raya</option>
                        <option value="sumsel babel" {{ $dataUser['xybanknamexyy'] == 'sumsel babel' ? 'selected' : '' }}>
                            sumsel babel</option>
                        <option value="bank kalsel" {{ $dataUser['xybanknamexyy'] == 'bank kalsel' ? 'selected' : '' }}>
                            bank kalsel</option>
                        <option value="ABA Bank" {{ $dataUser['xybanknamexyy'] == 'ABA Bank' ? 'selected' : '' }}>ABA Bank
                        </option>
                        <option value="canadia bank" {{ $dataUser['xybanknamexyy'] == 'canadia bank' ? 'selected' : '' }}>
                            canadia bank</option>
                        <option value="phillip bank" {{ $dataUser['xybanknamexyy'] == 'phillip bank' ? 'selected' : '' }}>
                            phillip bank</option>
                        <option value="wing bank" {{ $dataUser['xybanknamexyy'] == 'wing bank' ? 'selected' : '' }}>wing
                            bank</option>
                    </select>
                </div>
                <div class="list_form">
                    <span class="sec_label">NAMA REKENING</span>
                    <input type="text" id="xybankuserxy" name="xybankuserxy" placeholder="Masukkan Nama Rekening"
                        value="{{ $dataUser['xybankuserxy'] }}" required>
                </div>
                <div class="list_form">
                    <span class="sec_label">NOMOR REKENING</span>
                    <input type="text" id="xxybanknumberxy" name="xxybanknumberxy" placeholder="Masukkan Nomor Rekening"
                        value="{{ $dataUser['xxybanknumberxy'] }}" required>
                </div>
                <div class="list_form">
                    <span class="sec_label">EMAIL</span>
                    <input type="text" id="xyx11xuser_mailxxyy" name="xyx11xuser_mailxxyy"
                        placeholder="Masukkan Alamat Email" value="{{ $dataUser['xyx11xuser_mailxxyy'] }}" readonly
                        required>
                </div>
                <div class="list_form">
                    <span class="sec_label">NOMOR HP</span>
                    <input type="text" id="xynumbphonexyyy" name="xynumbphonexyyy" placeholder="Masukkan Nomor HP"
                        value="{{ $dataUser['xynumbphonexyyy'] }}" readonly required>
                </div>
                <div class="list_form">
                    <span class="sec_label">GROUP BANK DEPOSIT</span>
                    <select id="group" name="group">
                        <option value="">Pilih Group Bank</option>
                        <option value="groupbank1" {{ $dataUser['group'] == 'groupbank1' ? 'selected' : '' }}>group
                            bank 1</option>
                        <option value="groupbank2" {{ $dataUser['group'] == 'groupbank2' ? 'selected' : '' }}>group
                            bank 2</option>
                        <option value="groupbank3" {{ $dataUser['group'] == 'groupbank3' ? 'selected' : '' }}>group
                            bank 3</option>
                        <option value="groupbank4" {{ $dataUser['group'] == 'groupbank4' ? 'selected' : '' }}>group
                            bank 4</option>
                        <option value="groupbank5" {{ $dataUser['group'] == 'groupbank5' ? 'selected' : '' }}>group
                            bank 5</option>
                    </select>
                </div>
                <div class="list_form">
                    <span class="sec_label">GROUP BANK WITHDRAW</span>
                    <select id="groupwd" name="groupwd">
                        <option value="">Pilih Group Bank</option>
                        <option value="groupbankwd1" {{ $dataUser['groupwd'] == 'groupbankwd1' ? 'selected' : '' }}>
                            group
                            bank 1</option>
                        <option value="groupbankwd2" {{ $dataUser['groupwd'] == 'groupbankwd2' ? 'selected' : '' }}>
                            group
                            bank 2</option>
                        <option value="groupbankwd3" {{ $dataUser['groupwd'] == 'groupbankwd3' ? 'selected' : '' }}>
                            group
                            bank 3</option>
                        <option value="groupbankwd4" {{ $dataUser['groupwd'] == 'groupbankwd4' ? 'selected' : '' }}>
                            group
                            bank 4</option>
                        <option value="groupbankwd5" {{ $dataUser['groupwd'] == 'groupbankwd5' ? 'selected' : '' }}>
                            group
                            bank 5</option>
                    </select>
                </div>


            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="Contactsubmit">SAVE DATA</button>
                <a href="/member" id="cancel"><button type="button" class="sec_botton btn_danger">SUSPEND
                        PLAYER</button></a>
            </div>
        </form>



        <form action="/member/updatepassword" method="POST" enctype="multipart/form-data" id="form-password">
            @csrf
            <div class="sec_form">
                <div class="sec_head_form">
                    <span>CHANGE PASSWORD</span>
                </div>
                <div class="list_form">
                    <span class="sec_label">Password</span>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                    <input type="hidden" name="xyusernamexxy" placeholder="Masukkan Username"
                        value="{{ $dataUser['xyusernamexxy'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Konfirmasi Password</span>
                    <input type="password" id="cpassword" name="cpassword" placeholder="Masukkan Komnfirmasi Password"
                        required>
                </div>

            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="Contactsubmit">Submit</button>
            </div>
        </form>



        <form action="/member/updateplayer" method="POST" enctype="multipart/form-data" id="form-member">
            @csrf
            <div class="sec_form">
                <div class="sec_head_form">
                    <span>CHANGE DATA PLAYER</span>
                </div>
                <div class="list_form">
                    <span class="sec_label">Change Information</span>
                    <input type="text" id="keterangan" name="keterangan" placeholder="Masukkan Informasi Player"
                        value="{{ $dataMember->keterangan }}">
                    <input type="hidden" name="xyusernamexxy" placeholder="Masukkan Username"
                        value="{{ $dataUser['xyusernamexxy'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Status</span>
                    <select id="status" name="status">
                        <option value="9" {{ $dataMember->status == '9' ? 'selected' : '' }}>New Member</option>
                        <option value="1" {{ $dataMember->status == '1' ? 'selected' : '' }}>Default</option>
                        <option value="2" {{ $dataMember->status == '2' ? 'selected' : '' }}>VVIP</option>
                        <option value="3" {{ $dataMember->status == '3' ? 'selected' : '' }}>Bandar</option>
                        <option value="4" {{ $dataMember->status == '4' ? 'selected' : '' }}>Warning</option>
                        <option value="5" {{ $dataMember->status == '5' ? 'selected' : '' }}>Suspend</option>
                    </select>
                </div>
                <div class="list_form">
                    <span class="sec_label">BET MIN</span>
                    <input type="number" id="min_bet" name="min_bet" placeholder="0"
                        value="{{ $dataMember->min_bet }}" required>
                </div>
                <div class="list_form">
                    <span class="sec_label">BET MIN</span>
                    <input type="number" id="max_bet" name="max_bet" placeholder="0"
                        value="{{ $dataMember->max_bet }}" required>
                </div>

            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="Contactsubmit">Submit</button>
                <a href="/member" id="cancel"><button type="button"
                        class="sec_botton btn_cancel">Cancel</button></a>
            </div>
        </form>

    </div>

    <script>
        $(document).ready(function() {
            $('#form-password').submit(function(event) {

                var password = $('#password').val();
                var cpassword = $('#cpassword').val();

                if (password !== cpassword) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Password dan konfirmasi password tidak cocok!'
                    });

                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
