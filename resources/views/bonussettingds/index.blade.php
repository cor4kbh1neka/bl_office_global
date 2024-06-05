@extends('layouts.index')

@section('container')
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }} </h2>
        </div>
        <div class="seceditmemberds updateagent">
            <div class="groupseceditmemberds">
                <spann class="titleeditmemberds change">Referral & Bonus Settings</spann>
                <form method="POST" action="/bonussettingds/update" class="groupplayerinfo">
                    @csrf
                    <div class="groupplayerinfo">
                        <div class="listgroupplayerinfo left">
                            <div class="listplayerinfo">
                                <label for="min">minimal bet</label>
                                <div class="groupeditinput">
                                    <input type="number" readonly id="min" name="min" value="10">
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
                                    <input type="number" readonly id="max" name="max" value="10000">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="listplayerinfo ssreff">
                                <span class="labelbonusreff">Bonus Referral</span>
                                <div class="groupbnsreff">
                                    <div class="listreff">
                                        <label for="sportsbook">sportsbook (%)</label>
                                        <input type="number" id="sportsbook" name="sportsbook" value="0.2"
                                            step="0.1" placeholder="% referral">
                                    </div>
                                    <div class="listreff">
                                        <label for="virtualsports">virtualsports (%)</label>
                                        <input type="number" id="virtualsports" name="virtualsports" value="0.2"
                                            step="0.1" placeholder="% referral">
                                    </div>
                                    <div class="listreff">
                                        <label for="games">games (%)</label>
                                        <input type="number" id="games" name="games" value="0.2" step="0.1"
                                            placeholder="% games">
                                    </div>
                                    <div class="listreff">
                                        <label for="seamlesgames">seamlesgames (%)</label>
                                        <input type="number" id="seamlesgames" name="seamlesgames" value="0.2"
                                            step="0.1" placeholder="% seamlesgames">
                                    </div>
                                </div>
                            </div>
                            <div class="listplayerinfo ssreff">
                                <span class="labelbonusreff">Bonus</span>
                                <div class="groupbnsreff">
                                    <div class="listreff">
                                        <label for="cashback">cashback (%)</label>
                                        <input type="number" id="cashback" name="cashback" value="0.2" step="0.1"
                                            placeholder="% cashback">
                                    </div>
                                    <div class="listreff">
                                        <label for="rollingan">rollingan (%)</label>
                                        <input type="number" id="rollingan" name="rollingan" value="0.2" step="0.1"
                                            placeholder="% rollingan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="listgroupplayerinfo right solo">
                            <button class="tombol primary">
                                <span class="texttombol">SAVE DATA</span>
                            </button>
                        </div>
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
