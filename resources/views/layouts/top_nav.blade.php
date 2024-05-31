<div class="breadcrumb">
    <ol class="main_bred">
        <li class="list_bread"><span  id="root_breadtime"></span></li>
        <li class="separator_bread">
            {{-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5"
                    d="M8.91 19.92l6.52-6.52c.77-.77.77-2.03 0-2.8L8.91 4.08"></path>
            </svg> --}}
        </li>
        {{-- <li class="list_bread"><a href="" id="root_bread">Data IP</a></li> --}}
    </ol>
</div>
<div class="right_top_nav">

    <a href="/notifikasids" class="nav_notifikasi" data-informasi="23">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
            <path fill="currentColor" d="M21 19v1H3v-1l2-2v-6c0-3.1 2.03-5.83 5-6.71V4a2 2 0 0 1 2-2a2 2 0 0 1 2 2v.29c2.97.88 5 3.61 5 6.71v6zm-7 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2" />
        </svg>
        <div class="countnotif">
            <p></p>
        </div>
    </a>
    <div class="profile_nav">
        <img class="users_img"
            src="{{ auth()->user()->image != null ? asset('storage/profileImg/' . auth()->user()->image) : 'https://craftypixels.com/placeholder-image/35x35/c2c2c2/fff&text=35x35' }}"
            alt="gambar profile" />
        <div class="group_users_name">
            <span class="users_name">{{ auth()->user()->username }}</span>
            <div class="group_users_level">
                <span class="users_level">{{ auth()->user()->divisi }}</span>
                <span>▼</span>
            </div>
        </div>
        <div class="list_menu_profile">
            <a href="" id="Profile">
                <div class="data_profile">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle"
                        viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                        <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                    </svg>
                    <span>profile</span>
                </div>
            </a>
            <form action="/logout" method="post">
                @csrf
                <button type="submit">
                    <div class="data_profile">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout-2"
                            viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                            <path d="M15 12h-12l3 -3" />
                            <path d="M6 15l-3 -3" />
                        </svg>
                        <span>logout</span>
                    </div>
                </button>
            </form>

        </div>
    </div>
</div>

<script>
    // print data notifikasi
    $(document).ready(function(){
        var informasi = $(".nav_notifikasi").data("informasi");
        $(".countnotif p").text(informasi);
    });
</script>