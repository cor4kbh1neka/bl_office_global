@extends('layouts.index')

@section('container')
    <div class="sec_box hgi-100">
        <form action="/member/store" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            <div class="sec_form">
                <div class="sec_head_form">
                    <h3>{{ $title }}</h3>
                    <span>Tambah {{ $title }}</span>
                </div>
                <div class="list_form">
                    <span class="sec_label">Username</span>
                    <input type="text" id="xyusernamexxy" name="xyusernamexxy" placeholder="Masukkan Username" required>
                </div>
                <div class="list_form">
                    <span class="sec_label">Password</span>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                </div>
                <div class="list_form">
                    <span class="sec_label">Bank</span>
                    <input type="xybanknamexyy" id="xybanknamexyy" name="xybanknamexyy" placeholder="Masukkan Nama Bank"
                        required>
                </div>
                <div class="list_form">
                    <span class="sec_label">Nama Rekening</span>
                    <input type="xybankuserxy" id="xybankuserxy" name="xybankuserxy" placeholder="Masukkan Nama Rekening"
                        required>
                </div>
                <div class="list_form">
                    <span class="sec_label">Nomor Rekening</span>
                    <input type="xxybanknumberxy" id="xxybanknumberxy" name="xxybanknumberxy"
                        placeholder="Masukkan Nomor Rekening" required>
                </div>
                <div class="list_form">
                    <span class="sec_label">Email</span>
                    <input type="xyx11xuser_mailxxyy" id="xyx11xuser_mailxxyy" name="xyx11xuser_mailxxyy"
                        placeholder="Masukkan Email" required>
                </div>
                <div class="list_form">
                    <span class="sec_label">No. Hp</span>
                    <input type="xynumbphonexyyy" id="xynumbphonexyyy" name="xynumbphonexyyy" placeholder="Masukkan No.Hp"
                        required>
                </div>
            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="Contactsubmit">Submit</button>
                <a href="/member" id="cancel"><button type="button" class="sec_botton btn_cancel">Cancel</button></a>
            </div>
        </form>
    </div>
@endsection
