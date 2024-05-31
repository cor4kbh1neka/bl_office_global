@extends('layouts.index')
@section('container')

<div class="sec_box hgi-100">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>Create Sitemap</h3>
            <span>keterangan form</span>
        </div>
        <form action="/analyticsds/sitemap/" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="list_form">
                <span class="sec_label">Url Page</span>
                <input type="text" id="urpage" name="urpage" placeholder="Masukkan Url">
            </div>
            
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="" name="">Submit</button>
                <a href="/analyticsds/sitemap/"><button type="button" class="sec_botton btn_cancel">Cancel</button></a>
            </div>
        </form>
    </div>
</div>    

@endsection