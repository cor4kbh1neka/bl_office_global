@extends('layouts.index')

@section('container')
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>
            <div class="kembali">
                <a href="/productds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                        <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"
                            d="M44 40.836c-4.893-5.973-9.238-9.362-13.036-10.168c-3.797-.805-7.412-.927-10.846-.365V41L4 23.545L20.118 7v10.167c6.349.05 11.746 2.328 16.192 6.833c4.445 4.505 7.009 10.117 7.69 16.836Z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="textkembali">Kembali</span>
                </a>
            </div>
        </div>
        <div class="secagentds">
            <div class="groupsecagentds">
                <span class="titlebankmaster">Edit Dashboard</span>
                <form method="POST" action="/productds/update" id="form-agentds" class="groupplayerinfo">
                    @csrf
                    @foreach ($data as $item)
                        <div class="listgroupplayerinfo left">
                            <div class="listplayerinfo">
                                <label for="portfolio">Portfolio</label>
                                <div class="groupeditinput">
                                    <input type="hidden" name="id[]" value="{{ $item->id }}" {{ $disabled }}>
                                    <input type="text" id="portfolio" name="portfolio[]" value="{{ $item->portfolio }}"
                                        placeholder="masukkan nama portfolio">
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="productsname">Nama Game</label>
                                <div class="groupeditinput">
                                    <input type="text" id="productsname" name="productsname[]"
                                        value="{{ $item->productsname }}" placeholder="masukkan nama game">
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="listgroupplayerinfo right solo">
                        <button class="tombol primary">
                            <span class="texttombol">SAVE DATA</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan:',
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('#form').on('submit', function(e) {
                var valid = true;
                $('[name="password[]"]').each(function(index) {
                    var password = $(this).val();
                    var cpassword = $('[name="cpassword[]"]').eq(index).val();

                    if (password !== cpassword) {
                        valid = false;
                        alert('Password dan Konfirmasi Password tidak sama');
                        return false;
                    }
                });

                // Validasi PIN
                $('[name="pin[]"]').each(function(index) {
                    var pin = $(this).val();
                    var cpin = $('[name="cpin[]"]').eq(index).val();

                    if (pin !== cpin) {
                        valid = false;
                        alert('PIN dan Konfirmasi PIN tidak sama');
                        return false;
                    }
                });

                if (!valid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
