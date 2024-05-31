@extends('layouts.index')

@section('container')
    <div class="sec_box hgi-100">
        <form action="" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            @foreach ($data as $index => $item)
                <div class="sec_form">
                    <div class="sec_head_form">
                        <h3>{{ $title }}</h3>
                        <span>Edit {{ $title }}</span>
                        <input type="hidden" name="id[]" value="{{ $item->id }}" {{ $disabled }}>
                    </div>
                    <div class="list_form">
                        <span class="sec_label">Nama</span>
                        <input type="text" id="name" name="name[]" placeholder="Masukkan Nama" {{ $disabled }}
                            value={{ $item->name }} required>
                    </div>
                    <div class="list_form">
                        <span class="sec_label">Divisi</span>
                        <select id="divisi" name="divisi[]" {{ $disabled }}>
                            <option value="admin" {{ $item->divisi == 'admin' ? 'selected' : '' }}>admin</option>
                        </select>
                    </div>
                    <div class="list_form">
                        <span class="sec_label">Username</span>
                        <input type="text" id="username" name="username[]" placeholder="Masukkan Username"
                            {{ $disabled }} value={{ $item->username }} required>
                    </div>
                    <div class="list_form">
                        <span class="sec_label">Password</span>
                        <input type="password" id="password" name="password[]"
                            placeholder="Masukkan Password Jika Ingin Mengganti Password , Kosongkan jika tidak"
                            {{ $disabled }}>
                    </div>
                    <div class="list_form">
                        <span class="sec_label">Konfirmasi Password</span>
                        <input type="password" id="cpassword" name="cpassword" placeholder="Masukkan Konfirmasi Password"
                            {{ $disabled }}>
                    </div>
                    <div class="list_form">
                        <span class="sec_label">Gambar Profile</span>
                        <div class="pilihan_gambar">
                            <input type="file" id="image" name="image[]" {{ $disabled }}>
                            <button type="button" class="img_gallery">Pilih Gallery</button>
                        </div>
                    </div>
                </div>

                <span class="title_Nav">USER ACCESS : </span>
                <div class="sec_form">
                    <div class="list_form">
                        <span class="sec_label">Apk</span>
                        <div class="sec_togle">
                            <input type="checkbox" id="isapk" name="isapk[]" {{ $item->isapk ? 'checked' : '' }}>
                            <label for="isapk" class="sec_switch"></label>
                        </div>
                    </div>
                    <div class="list_form">
                        <span class="sec_label">Data</span>
                        <div class="sec_togle">
                            <input type="checkbox" id="isdata" name="isdata[]" {{ $item->isdata ? 'checked' : '' }}>
                            <label for="isdata" class="sec_switch"></label>
                        </div>
                    </div>
                    <div class="list_form">
                        <span class="sec_label">Transaction</span>
                        <div class="sec_togle">
                            <input type="checkbox" id="istransaction" name="istransaction[]" value="on"
                                {{ $item->istransaction ? 'checked' : '' }}>
                            <label for="istransaction" class="sec_switch"></label>
                        </div>
                    </div>
                    <div class="list_form">
                        <span class="sec_label">Config</span>
                        <div class="sec_togle">
                            <input type="checkbox" id="isconfig" name="isconfig[]" {{ $item->isconfig ? 'checked' : '' }}>
                            <label for="isconfig" class="sec_switch"></label>
                        </div>
                    </div>
                    <div class="list_form">
                        <span class="sec_label">Config Admin</span>
                        <div class="sec_togle">
                            <input type="checkbox" id="isconfigadmin" name="isconfigadmin"
                                {{ $item->isconfigadmin ? 'checked' : '' }}>
                            <label for="isconfigadmin" class="sec_switch"></label>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="Contactsubmit" {{ $disabled }}>Submit</button>
                <a href="/user" id="cancel"><button type="button" class="sec_botton btn_cancel">Cancel</button></a>
            </div>
        </form>
    </div>
@endsection
