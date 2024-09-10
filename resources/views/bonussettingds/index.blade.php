@extends('layouts.index')

@section('container')
    <style>
        .groupseceditmemberds2 {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 30px;
        }

        .titleeditmemberds2.change {
            margin-top: 10px;
        }


        .titleeditmemberds2 {
            width: 100%;
            font-family: 'myFont1';
            text-transform: uppercase;
            font-size: 18px;
            padding: 10px;
            background: var(--bg-box-primary);
            text-align: center;
            color: rgba(var(--rgba-white), 0.8);
        }

        .mb-100 {
            margin-bottom: 100px;
        }

        .listgroupplayerinfo.left {
            width: 80%;
        }
    </style>
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }} </h2>
        </div>
        <div class="seceditmemberds updateagent">
            <div class="groupseceditmemberds">
                <form method="POST" action="/bonussettingds/update" class="groupplayerinfo mb-100">
                    @csrf
                    <div class="listgroupplayerinfo left">

                        <div class="groupseceditmemberds2">
                            <spann class="titleeditmemberds2 change">minimal & maksimal bet</spann>
                            <div class="listplayerinfo">
                                <label for="min">minimal bet</label>
                                <div class="groupeditinput">
                                    <input type="number" readonly id="min" name="min"
                                        value="{{ $databetsetting->min }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="max">maksimal bet</label>
                                <div class="groupeditinput">
                                    <input type="number" readonly id="max" name="max"
                                        value="{{ $databetsetting->max }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="groupseceditmemberds2">
                            <spann class="titleeditmemberds2 change">persentase referral</spann>
                            <div class="listplayerinfo ssreff">
                                <span class="labelbonusreff">Bonus Referral</span>
                                <div class="groupbnsreff">
                                    @dd($dataProduct);
                                    @foreach ($dataProduct as $index => $item)
                                        <div class="listreff">
                                            <label for="persen_referral-{{ $index }}">{{ $item->portfolio }}</label>
                                            <input type="hidden" name="id-product[]" value="{{ $item->id }}">
                                            <input type="number" id="persen_referral-{{ $index }}"
                                                name="persen_referral[]" value="{{ $item->persen_referral }}" step="0.01"
                                                placeholder="0">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="groupseceditmemberds2">
                            <spann class="titleeditmemberds2 change">persentase bonus</spann>
                            <div class="listplayerinfo ssreff">
                                <span class="labelbonusreff">Cashback & Rollingan</span>
                                <div class="groupbnsreff">
                                    @foreach ($dataProduct as $index => $item)
                                        <div class="listreff">
                                            <label for="persen_bonus-{{ $index }}">{{ $item->portfolio }} (%)</label>
                                            <input type="number" id="persen_bonus-{{ $index }}"
                                                name="persen_bonus[]" value="{{ $item->persen_bonus }}" step="0.01"
                                                placeholder="0">
                                        </div>
                                        <div class="listreff">
                                            <label for="jenis_bonus">jenis bonus</label>
                                            <select id="jenis_bonus" name="jenis_bonus[]">
                                                <option value="cashback"
                                                    {{ $item->jenis_bonus == 'cashback' ? 'selected' : '' }}>cashback
                                                </option>
                                                <option value="rollingan"
                                                    {{ $item->jenis_bonus == 'rollingan' ? 'selected' : '' }}>rollingan
                                                </option>
                                            </select>
                                        </div>
                                        <div class="listreff">
                                            <label for="min_lose_bet">win lose / turn over</label>
                                            <input type="number" id="min_lose_bet" name="min_lose_bet[]"
                                                value="{{ $item->min_lose_bet }}" placeholder="0">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="listgroupplayerinfo right solo">
                        <button class="tombol primary">
                            <span class="texttombol">SAVE DATA</span>
                        </button>
                    </div>
                </form>
            </div>
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
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: '<ul>' +
                    @foreach ($errors->all() as $error)
                        '<li>{{ $error }}</li>' +
                    @endforeach
                '</ul>',
            });
        </script>
    @endif
@endsection
