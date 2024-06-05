<div class="sec_logo">
    <a href="/depositds" id="codeDashboardLink"><img class="gmb_logo" src="{{ asset('/assets/img/utama/logo.png') }}"
            alt="l21" /></a>
    <svg id="icon_expand" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category"
        viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <path d="M4 4h6v6h-6z" />
        <path d="M14 4h6v6h-6z" />
        <path d="M4 14h6v6h-6z" />
        <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
    </svg>
</div>
<div class="sec_list_sidemenu">
    <div class="bagsearch side">
        <div class="grubsearchnav">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24"
                stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                <path d="M21 21l-6 -6" />
            </svg>
            <input type="text" placeholder="Cari Tabel..." id="searchTabel" />
        </div>
    </div>

    <a href="/depositds" class="nav_group">
        <div class="title_Nav singlemenu {{ Request::is('dashboard*') ? 'nyala' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M11 21H5c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h6zm2 0h6c1.1 0 2-.9 2-2v-7h-8zm8-11V5c0-1.1-.9-2-2-2h-6v7z" />
            </svg>
            <span class="text_Nav">dashboard</span>
        </div>
    </a>
    @canany(['deposit', 'withdraw', 'manual_transaction', 'history_coin'])
        <div class="nav_group">
            <span class="title_Nav">TRANSACTION</span>
            <div class="list_sidejsx">
                @can('deposit')
                    <div class="data_sidejsx {{ Request::is('depositds*') ? 'active' : '' }}">
                        <a href="/depositds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                    d="M95.5 104h320a87.73 87.73 0 0 1 11.18.71a66 66 0 0 0-77.51-55.56L86 94.08h-.3a66 66 0 0 0-41.07 26.13A87.57 87.57 0 0 1 95.5 104m320 24h-320a64.07 64.07 0 0 0-64 64v192a64.07 64.07 0 0 0 64 64h320a64.07 64.07 0 0 0 64-64V192a64.07 64.07 0 0 0-64-64M368 320a32 32 0 1 1 32-32a32 32 0 0 1-32 32" />
                                <path fill="currentColor"
                                    d="M32 259.5V160c0-21.67 12-58 53.65-65.87C121 87.5 156 87.5 156 87.5s23 16 4 16s-18.5 24.5 0 24.5s0 23.5 0 23.5L85.5 236Z" />
                            </svg>
                            <span class="nav_title1">deposit</span>
                            <span class="countdatapend" id="countDP">{{ $dataCount['countDP'] }}</span>
                        </a>
                    </div>
                @endcan
                @can('withdraw')
                    <div class="data_sidejsx {{ Request::is('withdrawds*') ? 'active' : '' }}">
                        <a href="/withdrawds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M16 12c2.76 0 5-2.24 5-5s-2.24-5-5-5s-5 2.24-5 5s2.24 5 5 5m5.45 5.6c-.39-.4-.88-.6-1.45-.6h-7l-2.08-.73l.33-.94L13 16h2.8c.35 0 .63-.14.86-.37s.34-.51.34-.82c0-.54-.26-.91-.78-1.12L8.95 11H7v9l7 2l8.03-3c.01-.53-.19-1-.58-1.4M5 11H.984v11H5z" />
                            </svg>
                            <span class="nav_title1">withdraw</span>
                            <span class="countdatapend" id="countWD">{{ $dataCount['countWD'] }}</span>
                        </a>
                    </div>
                @endcan
                @can('manual_transaction')
                    <div class="data_sidejsx {{ Request::is('manualds*') ? 'active' : '' }}">
                        <a href="/manualds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M20.7 7c-.3.4-.7.7-.7 1s.3.6.6 1c.5.5 1 .9.9 1.4c0 .5-.5 1-1 1.5L16.4 16L15 14.7l4.2-4.2l-1-1l-1.4 1.4L13 7.1l4-3.8c.4-.4 1-.4 1.4 0l2.3 2.3c.4.4.4 1.1 0 1.4M3 17.2l9.6-9.6l3.7 3.8L6.8 21H3zM7 2v3h3v2H7v3H5V7H2V5h3V2z" />
                            </svg>
                            <span class="nav_title1">Manual</span>
                        </a>
                    </div>
                @endcan
                @can('history_coin')
                    <div class="data_sidejsx {{ Request::is('historycoinds*') ? 'active' : '' }}">
                        <a href="/historycoinds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <path d="M3 12a9 9 0 1 0 9-9a9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                    <path d="M3 3v5h5m4-1v5l4 2" />
                                </g>
                            </svg>
                            <span class="nav_title1">history coin</span>
                        </a>
                    </div>
                @endcan
            </div>
        </div>
    @endcanany

    @canany(['member_list', 'history_transaction', 'referral', 'history_game', 'member_outstanding', 'report'])
        <div class="nav_group">
            <span class="title_Nav">DATA</span>
            <div class="list_sidejsx">
                @can('member_list')
                    <div class="data_sidejsx {{ Request::is('memberlistds*') ? 'active' : '' }}">
                        <a href="/memberlistds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M16.67 13.13C18.04 14.06 19 15.32 19 17v3h4v-3c0-2.18-3.57-3.47-6.33-3.87" />
                                <circle cx="9" cy="8" r="4" fill="currentColor" fill-rule="evenodd" />
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4c-.47 0-.91.1-1.33.24a5.98 5.98 0 0 1 0 7.52c.42.14.86.24 1.33.24m-6 1c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4" />
                            </svg>
                            <span class="nav_title1">member list</span>
                        </a>
                    </div>
                    <div class="data_sidejsx {{ Request::is('seamless*') ? 'active' : '' }}">
                        <a href="/seamless/addmember" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M16.67 13.13C18.04 14.06 19 15.32 19 17v3h4v-3c0-2.18-3.57-3.47-6.33-3.87" />
                                <circle cx="9" cy="8" r="4" fill="currentColor" fill-rule="evenodd" />
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4c-.47 0-.91.1-1.33.24a5.98 5.98 0 0 1 0 7.52c.42.14.86.24 1.33.24m-6 1c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4" />
                            </svg>
                            <span class="nav_title1">Member Seamless</span>
                        </a>
                    </div>
                @endcan
                @can('history_transaction')
                    <div class="data_sidejsx {{ Request::is('historytransaksids*') ? 'active' : '' }}">
                        <a href="/historytransaksids" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                <path fill="currentColor"
                                    d="M4 5a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v7h3v2a3 3 0 0 1-3 3h-4.05q.05-.243.05-.5v-3A2.5 2.5 0 0 0 8.5 11H4zm11 11a2 2 0 0 0 2-2v-1h-2zM7.5 6a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2.5 4.5A1.5 1.5 0 0 0 8.5 12h-6A1.5 1.5 0 0 0 1 13.5v3A1.5 1.5 0 0 0 2.5 18h6a1.5 1.5 0 0 0 1.5-1.5zm-1 2v1a.5.5 0 0 0-.5.5h-1A1.5 1.5 0 0 1 9 15.5M8.5 13a.5.5 0 0 0 .5.5v1A1.5 1.5 0 0 1 7.5 13zm-6.5.5a.5.5 0 0 0 .5-.5h1A1.5 1.5 0 0 1 2 14.5zm.5 3.5a.5.5 0 0 0-.5-.5v-1A1.5 1.5 0 0 1 3.5 17zM4 15a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0" />
                            </svg>
                            <span class="nav_title1">history transaksi</span>
                        </a>
                    </div>
                @endcan
                @can('referral')
                    <div class="data_sidejsx {{ Request::is('referralds*') ? 'active' : '' }}">
                        <a href="/referralds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 5.5A3.5 3.5 0 0 1 15.5 9a3.5 3.5 0 0 1-3.5 3.5A3.5 3.5 0 0 1 8.5 9A3.5 3.5 0 0 1 12 5.5M5 8c.56 0 1.08.15 1.53.42c-.15 1.43.27 2.85 1.13 3.96C7.16 13.34 6.16 14 5 14a3 3 0 0 1-3-3a3 3 0 0 1 3-3m14 0a3 3 0 0 1 3 3a3 3 0 0 1-3 3c-1.16 0-2.16-.66-2.66-1.62a5.54 5.54 0 0 0 1.13-3.96c.45-.27.97-.42 1.53-.42M5.5 18.25c0-2.07 2.91-3.75 6.5-3.75s6.5 1.68 6.5 3.75V20h-13zM0 20v-1.5c0-1.39 1.89-2.56 4.45-2.9c-.59.68-.95 1.62-.95 2.65V20zm24 0h-3.5v-1.75c0-1.03-.36-1.97-.95-2.65c2.56.34 4.45 1.51 4.45 2.9z" />
                            </svg>
                            <span class="nav_title1">referral</span>
                        </a>
                    </div>
                @endcan
                @can('history_game')
                    <div class="data_sidejsx {{ Request::is('historygameds*') ? 'active' : '' }}">
                        <a href="/historygameds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                    d="M264.4 95.01c-35.6-.06-80.2 11.19-124.2 34.09C96.27 152 61.45 182 41.01 211.3c-20.45 29.2-25.98 56.4-15.92 75.8c10.07 19.3 35.53 30.4 71.22 30.4c35.69.1 80.29-11.2 124.19-34c44-22.9 78.8-53 99.2-82.2c20.5-29.2 25.9-56.4 15.9-75.8c-10.1-19.3-35.5-30.49-71.2-30.49m91.9 70.29c-3.5 15.3-11.1 31-21.8 46.3c-22.6 32.3-59.5 63.8-105.7 87.8c-46.2 24.1-93.1 36.2-132.5 36.2c-18.6 0-35.84-2.8-50.37-8.7l10.59 20.4c10.08 19.4 35.47 30.5 71.18 30.5c35.7 0 80.3-11.2 124.2-34.1c44-22.8 78.8-52.9 99.2-82.2c20.4-29.2 26-56.4 15.9-75.7zm28.8 16.8c11.2 26.7 2.2 59.2-19.2 89.7c-18.9 27.1-47.8 53.4-83.6 75.4c11.1 1.2 22.7 1.8 34.5 1.8c49.5 0 94.3-10.6 125.9-27.1c31.7-16.5 49.1-38.1 49.1-59.9s-17.4-43.4-49.1-59.9c-16.1-8.4-35.7-15.3-57.6-20m106.7 124.8c-10.2 11.9-24.2 22.4-40.7 31c-35 18.2-82.2 29.1-134.3 29.1c-21.2 0-41.6-1.8-60.7-5.2c-23.2 11.7-46.5 20.4-68.9 26.1c1.2.7 2.4 1.3 3.7 2c31.6 16.5 76.4 27.1 125.9 27.1s94.3-10.6 125.9-27.1c31.7-16.5 49.1-38.1 49.1-59.9z" />
                            </svg>
                            <span class="nav_title1">history game</span>
                        </a>
                    </div>
                @endcan
                @can('member_outstanding')
                    <div class="data_sidejsx {{ Request::is('outstandingds*') ? 'active' : '' }}">
                        <a href="/outstandingds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M4 20h12v2H4c-1.1 0-2-.9-2-2V7h2m18-3v12c0 1.1-.9 2-2 2H8c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h12c1.1 0 2 .9 2 2M12 8h-2v6h2m3-8h-2v8h2m3-3h-2v3h2Z" />
                            </svg>
                            <span class="nav_title1">member outstanding</span>
                            <span class="countdatapend outstanding">{{ $dataCount['countOuts'] }}</span>
                        </a>
                    </div>
                @endcan
                @can('cashback_rollingan')
                    <div class="data_sidejsx {{ Request::is('bonuslistds*') ? 'active' : '' }}">
                        <a href="/bonuslistds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 14 14">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M10.213 2.538A5.499 5.499 0 0 0 1.595 8.01a.75.75 0 0 1-1.474.277a6.999 6.999 0 0 1 11.163-6.821l.612-.612a.5.5 0 0 1 .854.353V3.5a.5.5 0 0 1-.5.5H9.957a.5.5 0 0 1-.353-.853zm2.791 2.577a.75.75 0 0 1 .876.598a6.999 6.999 0 0 1-11.164 6.821l-.612.613a.5.5 0 0 1-.854-.354V10.5a.5.5 0 0 1 .5-.5h2.293a.5.5 0 0 1 .354.854l-.61.609a5.499 5.499 0 0 0 8.618-5.472a.75.75 0 0 1 .6-.876ZM7.627 3.657a.75.75 0 0 0-1.5 0V4a1.704 1.704 0 0 0-.085 3.346l1.26.275a.32.32 0 0 1-.068.63H6.52a.32.32 0 0 1-.3-.212a.75.75 0 0 0-1.415.5a1.822 1.822 0 0 0 1.321 1.17v.362a.75.75 0 0 0 1.5 0v-.362a1.82 1.82 0 0 0-.005-3.553l-1.26-.276a.204.204 0 0 1 .044-.403h.828a.316.316 0 0 1 .3.212a.75.75 0 0 0 1.415-.5a1.818 1.818 0 0 0-1.322-1.17v-.36Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="nav_title1">Cashback/Rollingan</span>
                        </a>
                    </div>
                @endcan
                @can('report')
                    <div class="data_sidejsx {{ Request::is('reportds*') ? 'active' : '' }}">
                        <a href="/reportds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none" fill-rule="evenodd">
                                    <path
                                        d="M24 0v24H0V0zM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z" />
                                    <path fill="currentColor"
                                        d="M12 7a6 6 0 0 1 5.996 5.775L18 13v7h1a1 1 0 0 1 .117 1.993L19 22H5a1 1 0 0 1-.117-1.993L5 20h1v-7a6 6 0 0 1 6-6m-.857 4.986L9.652 14.47a1.01 1.01 0 0 0 .866 1.53h1.216l-.591.985a1 1 0 0 0 1.714 1.03l1.491-2.485a1.01 1.01 0 0 0-.866-1.53h-1.216l.591-.985a1 1 0 0 0-1.714-1.03ZM5.542 5.139l.094.083l.707.707a1 1 0 0 1-1.32 1.497l-.094-.083l-.707-.707a1 1 0 0 1 1.32-1.497m14.236.083a1 1 0 0 1 0 1.414l-.707.707a1 1 0 1 1-1.414-1.414l.707-.707a1 1 0 0 1 1.414 0M12 2a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0V3a1 1 0 0 1 1-1" />
                                </g>
                            </svg>
                            <span class="nav_title1">report</span>
                        </a>
                    </div>
                @endcan
            </div>
        </div>
    @endcanany

    @canany(['bank', 'memo'])
        <div class="nav_group">
            <span class="title_Nav">GENERAL CONFIG</span>
            <div class="list_sidejsx">
                @can('bank')
                    <div class="data_sidejsx {{ Request::is('bankds*') ? 'active' : '' }}">
                        <a href="/bankds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M11.5 1L2 6v2h19V6m-5 4v7h3v-7M2 22h19v-3H2m8-9v7h3v-7m-9 0v7h3v-7z" />
                            </svg>
                            <span class="nav_title1">bank</span>
                        </a>
                    </div>
                @endcan
                @can('memo')
                    <div class="data_sidejsx {{ Request::is('memods*') ? 'active' : '' }}">
                        <a href="/memods" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none">
                                    <path
                                        d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                    <path fill="currentColor"
                                        d="M19 3a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-3.697l-2.61 1.74c-.42.28-.966.28-1.386 0L8.697 19H5a3 3 0 0 1-3-3V6a3 3 0 0 1 3-3zM8.5 10a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m7 0a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3" />
                                </g>
                            </svg>
                            <span class="nav_title1">memo</span>
                            <span class="countdatapend memo">{{ $dataCount['countMemo'] }}</span>
                        </a>
                    </div>
                @endcan
            </div>
        </div>
    @endcanany

    @canany(['agent', 'analytic', 'content', 'apk_setting', 'memo_other'])
        <div class="nav_group">
            <span class="title_Nav">CONFIG ADMIN</span>
            <div class="list_sidejsx">
                @can('agent')
                    <div class="data_sidejsx {{ Request::is('agentds*') ? 'active' : '' }}">
                        <a href="/agentds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                <path fill="currentColor"
                                    d="M8 14h6v2H8zm0-8h12v2H8zm0 4h12v2H8zm0 14h6v2H8zm22 0v-2h-2.101a4.968 4.968 0 0 0-.732-1.753l1.49-1.49l-1.414-1.414l-1.49 1.49A4.968 4.968 0 0 0 24 18.101V16h-2v2.101a4.968 4.968 0 0 0-1.753.732l-1.49-1.49l-1.414 1.414l1.49 1.49A4.968 4.968 0 0 0 18.101 22H16v2h2.101a4.968 4.968 0 0 0 .732 1.753l-1.49 1.49l1.414 1.414l1.49-1.49a4.968 4.968 0 0 0 1.753.732V30h2v-2.101a4.968 4.968 0 0 0 1.753-.732l1.49 1.49l1.414-1.414l-1.49-1.49A4.968 4.968 0 0 0 27.899 24zm-7 2a3 3 0 1 1 3-3a3.003 3.003 0 0 1-3 3" />
                                <path fill="currentColor"
                                    d="M14 30H6a2.002 2.002 0 0 1-2-2V4a2.002 2.002 0 0 1 2-2h16a2.002 2.002 0 0 1 2 2v10h-2V4H6v24h8Z" />
                            </svg>
                            <span class="nav_title1">agent</span>
                        </a>
                    </div>
                @endcan
                @can('analytic')
                    <div class="data_sidejsx {{ Request::is('analyticsds*') ? 'active' : '' }}">
                        <a href="/analyticsds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M8 12q-.425 0-.712.288T7 13v3q0 .425.288.713T8 17t.713-.288T9 16v-3q0-.425-.288-.712T8 12m8-5q-.425 0-.712.288T15 8v8q0 .425.288.713T16 17t.713-.288T17 16V8q0-.425-.288-.712T16 7m-4 7q-.425 0-.712.288T11 15v1q0 .425.288.713T12 17t.713-.288T13 16v-1q0-.425-.288-.712T12 14m-7 7q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.587 1.413T19 21zm7-9q.425 0 .713-.288T13 11t-.288-.712T12 10t-.712.288T11 11t.288.713T12 12" />
                            </svg>
                            <span class="nav_title1">analytics</span>
                        </a>
                    </div>
                @endcan
                @can('content')
                    <div class="data_sidejsx {{ Request::is('contentds*') ? 'active' : '' }}">
                        <a href="/contentds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M21.04 12.13c-.14 0-.28.06-.39.17l-1 1l2.05 2.05l1-1c.22-.21.22-.56 0-.77l-1.28-1.28a.53.53 0 0 0-.38-.17m-1.97 1.75L13 19.94V22h2.06l6.06-6.07zM19 11.12l-7.09 7.08c-.41-.25-.91-.4-1.41-.4c-1.5 0-2.7 1.2-2.7 2.7V22H4a2 2 0 0 1-2-2v-3.8h1.5c1.5 0 2.7-1.2 2.7-2.7S5 10.8 3.5 10.8H2V7c0-1.1.9-2 2-2h4V3.5a2.5 2.5 0 0 1 5 0V5h4a2 2 0 0 1 2 2z" />
                            </svg>
                            <span class="nav_title1">content</span>
                        </a>
                    </div>
                @endcan
                @can('apk_setting')
                    <div class="data_sidejsx {{ Request::is('apksettingds*') ? 'active' : '' }}">
                        <a href="/apksettingds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m9.25 22l-.4-3.2q-.325-.125-.612-.3t-.563-.375L4.7 19.375l-2.75-4.75l2.575-1.95Q4.5 12.5 4.5 12.338v-.675q0-.163.025-.338L1.95 9.375l2.75-4.75l2.975 1.25q.275-.2.575-.375t.6-.3l.4-3.2h5.5l.4 3.2q.325.125.613.3t.562.375l2.975-1.25l2.75 4.75l-2.575 1.95q.025.175.025.338v.674q0 .163-.05.338l2.575 1.95l-2.75 4.75l-2.95-1.25q-.275.2-.575.375t-.6.3l-.4 3.2zm2.8-6.5q1.45 0 2.475-1.025T15.55 12t-1.025-2.475T12.05 8.5q-1.475 0-2.488 1.025T8.55 12t1.013 2.475T12.05 15.5" />
                            </svg>
                            <span class="nav_title1">APK settings</span>
                        </a>
                    </div>
                @endcan
                {{-- @can('memo_other')
                    <div class="data_sidejsx {{ Request::is('memotouserds*') ? 'active' : '' }}">
                        <a href="/memotouserds" id="Player">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M2.25 5A2.75 2.75 0 0 1 5 2.25h14A2.75 2.75 0 0 1 21.75 5v10A2.75 2.75 0 0 1 19 17.75H7.961c-.38 0-.739.173-.976.47l-2.33 2.913c-.798.996-2.405.433-2.405-.843z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="nav_title1">memo to other user</span>
                        </a>
                    </div>
                @endcan --}}
            </div>
        </div>
    @endcanany
</div>
