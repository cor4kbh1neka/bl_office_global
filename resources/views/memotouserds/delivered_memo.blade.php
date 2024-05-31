@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor" d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>
        <div class="secmemods">
            <div class="groupsecmemods">
                <div class="headgroupsecmemods">
                    <a href="/memotouserds" class="tombol grey">
                        <span class="texttombol">create</span>
                    </a>
                    <a href="/memotouserds/delivered" class="tombol grey active">
                        <span class="texttombol">delivered</span>
                    </a>
                </div>
                <div class="groupdatamemo inbox">
                    <div class="headfilter">
                        <div class="groupinputfilter">
                            <div class="listinputmember">
                                <label for="iddelivered">ID delivered</label>
                                <input type="text" id="iddelivered" name="iddelivered" placeholder="ID delivered">
                            </div>
                            <div class="listinputmember">
                                <button class="tombol primary">
                                    <span class="texttombol">SUBMIT</span>
                                </button>
                            </div>
                        </div>
                        <div class="exportdata">
                            <span class="textdownload">download</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                            </svg>
                        </div>
                    </div>
                    <div class="groupplayerinfo">
                        <div class="tabelproses">
                            <table>
                                <tbody>
                                    <tr class="hdtable">
                                        <th class="bagno">#</th>
                                        <th class="bagidms">ID delivered</th>
                                        <th class="bagtanggalinbox">tanggal message</th>
                                        <th class="bagsubject">subject</th>
                                        <th class="bagpengirim">pengirim</th>
                                        <th class="bagaction">actions</th>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>DV000001</td>
                                        <td>2024-04-03 13:29:37</td>
                                        <td>INFORMASI UPDATE</td>
                                        <td>TEAM IT</td>
                                        <td>
                                            <div class="kolom_action">
                                                <div class="dot_action">
                                                    <span>•</span>
                                                    <span>•</span>
                                                    <span>•</span>
                                                </div>
                                                <div class="action_crud">
                                                    <a href="/memotouserds/read" target="_blank" class="openviewport">
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                                                <circle cx="16" cy="16" r="4" fill="currentColor" />
                                                                <path fill="currentColor" d="M30.94 15.66A16.69 16.69 0 0 0 16 5A16.69 16.69 0 0 0 1.06 15.66a1 1 0 0 0 0 .68A16.69 16.69 0 0 0 16 27a16.69 16.69 0 0 0 14.94-10.66a1 1 0 0 0 0-.68M16 22.5a6.5 6.5 0 1 1 6.5-6.5a6.51 6.51 0 0 1-6.5 6.5" />
                                                            </svg>
                                                            <span>Lihat</span>
                                                        </div>
                                                    </a>
                                                    <a href="#" >
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                            </svg>
                                                            <span>Delete</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>DV000001</td>
                                        <td>2024-04-03 13:29:37</td>
                                        <td>MAINTENANCE</td>
                                        <td>TEAM IT</td>
                                        <td>
                                            <div class="kolom_action">
                                                <div class="dot_action">
                                                    <span>•</span>
                                                    <span>•</span>
                                                    <span>•</span>
                                                </div>
                                                <div class="action_crud">
                                                    <a href="/memotouserds/read" target="_blank" class="openviewport">
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                                                <circle cx="16" cy="16" r="4" fill="currentColor" />
                                                                <path fill="currentColor" d="M30.94 15.66A16.69 16.69 0 0 0 16 5A16.69 16.69 0 0 0 1.06 15.66a1 1 0 0 0 0 .68A16.69 16.69 0 0 0 16 27a16.69 16.69 0 0 0 14.94-10.66a1 1 0 0 0 0-.68M16 22.5a6.5 6.5 0 1 1 6.5-6.5a6.51 6.51 0 0 1-6.5 6.5" />
                                                            </svg>
                                                            <span>Lihat</span>
                                                        </div>
                                                    </a>
                                                    <a href="#" >
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                            </svg>
                                                            <span>Delete</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>DV000001</td>
                                        <td>2024-04-03 13:29:37</td>
                                        <td>MAINTENANCE</td>
                                        <td>TEAM IT</td>
                                        <td>
                                            <div class="kolom_action">
                                                <div class="dot_action">
                                                    <span>•</span>
                                                    <span>•</span>
                                                    <span>•</span>
                                                </div>
                                                <div class="action_crud">
                                                    <a href="/memotouserds/read" target="_blank" class="openviewport">
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                                                <circle cx="16" cy="16" r="4" fill="currentColor" />
                                                                <path fill="currentColor" d="M30.94 15.66A16.69 16.69 0 0 0 16 5A16.69 16.69 0 0 0 1.06 15.66a1 1 0 0 0 0 .68A16.69 16.69 0 0 0 16 27a16.69 16.69 0 0 0 14.94-10.66a1 1 0 0 0 0-.68M16 22.5a6.5 6.5 0 1 1 6.5-6.5a6.51 6.51 0 0 1-6.5 6.5" />
                                                            </svg>
                                                            <span>Lihat</span>
                                                        </div>
                                                    </a>
                                                    <a href="#" >
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                            </svg>
                                                            <span>Delete</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>DV000001</td>
                                        <td>2024-04-03 13:29:37</td>
                                        <td>MAINTENANCE</td>
                                        <td>TEAM IT</td>
                                        <td>
                                            <div class="kolom_action">
                                                <div class="dot_action">
                                                    <span>•</span>
                                                    <span>•</span>
                                                    <span>•</span>
                                                </div>
                                                <div class="action_crud">
                                                    <a href="/memotouserds/read" target="_blank" class="openviewport">
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                                                <circle cx="16" cy="16" r="4" fill="currentColor" />
                                                                <path fill="currentColor" d="M30.94 15.66A16.69 16.69 0 0 0 16 5A16.69 16.69 0 0 0 1.06 15.66a1 1 0 0 0 0 .68A16.69 16.69 0 0 0 16 27a16.69 16.69 0 0 0 14.94-10.66a1 1 0 0 0 0-.68M16 22.5a6.5 6.5 0 1 1 6.5-6.5a6.51 6.51 0 0 1-6.5 6.5" />
                                                            </svg>
                                                            <span>Lihat</span>
                                                        </div>
                                                    </a>
                                                    <a href="#" >
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                            </svg>
                                                            <span>Delete</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>DV000001</td>
                                        <td>2024-04-03 13:29:37</td>
                                        <td>MAINTENANCE</td>
                                        <td>TEAM IT</td>
                                        <td>
                                            <div class="kolom_action">
                                                <div class="dot_action">
                                                    <span>•</span>
                                                    <span>•</span>
                                                    <span>•</span>
                                                </div>
                                                <div class="action_crud">
                                                    <a href="/memotouserds/read" target="_blank" class="openviewport">
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                                                <circle cx="16" cy="16" r="4" fill="currentColor" />
                                                                <path fill="currentColor" d="M30.94 15.66A16.69 16.69 0 0 0 16 5A16.69 16.69 0 0 0 1.06 15.66a1 1 0 0 0 0 .68A16.69 16.69 0 0 0 16 27a16.69 16.69 0 0 0 14.94-10.66a1 1 0 0 0 0-.68M16 22.5a6.5 6.5 0 1 1 6.5-6.5a6.51 6.51 0 0 1-6.5 6.5" />
                                                            </svg>
                                                            <span>Lihat</span>
                                                        </div>
                                                    </a>
                                                    <a href="#" >
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                            </svg>
                                                            <span>Delete</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>DV000001</td>
                                        <td>2024-04-03 13:29:37</td>
                                        <td>MAINTENANCE</td>
                                        <td>TEAM IT</td>
                                        <td>
                                            <div class="kolom_action">
                                                <div class="dot_action">
                                                    <span>•</span>
                                                    <span>•</span>
                                                    <span>•</span>
                                                </div>
                                                <div class="action_crud">
                                                    <a href="/memotouserds/read" target="_blank" class="openviewport">
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                                                <circle cx="16" cy="16" r="4" fill="currentColor" />
                                                                <path fill="currentColor" d="M30.94 15.66A16.69 16.69 0 0 0 16 5A16.69 16.69 0 0 0 1.06 15.66a1 1 0 0 0 0 .68A16.69 16.69 0 0 0 16 27a16.69 16.69 0 0 0 14.94-10.66a1 1 0 0 0 0-.68M16 22.5a6.5 6.5 0 1 1 6.5-6.5a6.51 6.51 0 0 1-6.5 6.5" />
                                                            </svg>
                                                            <span>Lihat</span>
                                                        </div>
                                                    </a>
                                                    <a href="#" >
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                            </svg>
                                                            <span>Delete</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>DV000001</td>
                                        <td>2024-04-03 13:29:37</td>
                                        <td>MAINTENANCE</td>
                                        <td>TEAM IT</td>
                                        <td>
                                            <div class="kolom_action">
                                                <div class="dot_action">
                                                    <span>•</span>
                                                    <span>•</span>
                                                    <span>•</span>
                                                </div>
                                                <div class="action_crud">
                                                    <a href="/memotouserds/read" target="_blank" class="openviewport">
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                                                <circle cx="16" cy="16" r="4" fill="currentColor" />
                                                                <path fill="currentColor" d="M30.94 15.66A16.69 16.69 0 0 0 16 5A16.69 16.69 0 0 0 1.06 15.66a1 1 0 0 0 0 .68A16.69 16.69 0 0 0 16 27a16.69 16.69 0 0 0 14.94-10.66a1 1 0 0 0 0-.68M16 22.5a6.5 6.5 0 1 1 6.5-6.5a6.51 6.51 0 0 1-6.5 6.5" />
                                                            </svg>
                                                            <span>Lihat</span>
                                                        </div>
                                                    </a>
                                                    <a href="#" >
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                            </svg>
                                                            <span>Delete</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>DV000001</td>
                                        <td>2024-04-03 13:29:37</td>
                                        <td>MAINTENANCE</td>
                                        <td>TEAM IT</td>
                                        <td>
                                            <div class="kolom_action">
                                                <div class="dot_action">
                                                    <span>•</span>
                                                    <span>•</span>
                                                    <span>•</span>
                                                </div>
                                                <div class="action_crud">
                                                    <a href="/memotouserds/read" target="_blank" class="openviewport">
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                                                <circle cx="16" cy="16" r="4" fill="currentColor" />
                                                                <path fill="currentColor" d="M30.94 15.66A16.69 16.69 0 0 0 16 5A16.69 16.69 0 0 0 1.06 15.66a1 1 0 0 0 0 .68A16.69 16.69 0 0 0 16 27a16.69 16.69 0 0 0 14.94-10.66a1 1 0 0 0 0-.68M16 22.5a6.5 6.5 0 1 1 6.5-6.5a6.51 6.51 0 0 1-6.5 6.5" />
                                                            </svg>
                                                            <span>Lihat</span>
                                                        </div>
                                                    </a>
                                                    <a href="#" >
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                            </svg>
                                                            <span>Delete</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>DV000001</td>
                                        <td>2024-04-03 13:29:37</td>
                                        <td>MAINTENANCE</td>
                                        <td>TEAM IT</td>
                                        <td>
                                            <div class="kolom_action">
                                                <div class="dot_action">
                                                    <span>•</span>
                                                    <span>•</span>
                                                    <span>•</span>
                                                </div>
                                                <div class="action_crud">
                                                    <a href="/memotouserds/read" target="_blank" class="openviewport">
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                                                <circle cx="16" cy="16" r="4" fill="currentColor" />
                                                                <path fill="currentColor" d="M30.94 15.66A16.69 16.69 0 0 0 16 5A16.69 16.69 0 0 0 1.06 15.66a1 1 0 0 0 0 .68A16.69 16.69 0 0 0 16 27a16.69 16.69 0 0 0 14.94-10.66a1 1 0 0 0 0-.68M16 22.5a6.5 6.5 0 1 1 6.5-6.5a6.51 6.51 0 0 1-6.5 6.5" />
                                                            </svg>
                                                            <span>Lihat</span>
                                                        </div>
                                                    </a>
                                                    <a href="#" >
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                            </svg>
                                                            <span>Delete</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>DV000001</td>
                                        <td>2024-04-03 13:29:37</td>
                                        <td>MAINTENANCE</td>
                                        <td>TEAM IT</td>
                                        <td>
                                            <div class="kolom_action">
                                                <div class="dot_action">
                                                    <span>•</span>
                                                    <span>•</span>
                                                    <span>•</span>
                                                </div>
                                                <div class="action_crud">
                                                    <a href="/memotouserds/read" target="_blank" class="openviewport">
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                                                <circle cx="16" cy="16" r="4" fill="currentColor" />
                                                                <path fill="currentColor" d="M30.94 15.66A16.69 16.69 0 0 0 16 5A16.69 16.69 0 0 0 1.06 15.66a1 1 0 0 0 0 .68A16.69 16.69 0 0 0 16 27a16.69 16.69 0 0 0 14.94-10.66a1 1 0 0 0 0-.68M16 22.5a6.5 6.5 0 1 1 6.5-6.5a6.51 6.51 0 0 1-6.5 6.5" />
                                                            </svg>
                                                            <span>Lihat</span>
                                                        </div>
                                                    </a>
                                                    <a href="#" >
                                                        <div class="list_action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                            </svg>
                                                            <span>Delete</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="grouppagination">
                                <div class="grouppaginationcc">
                                    <div class="trigger left">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <g fill="none" fill-rule="evenodd">
                                                <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                <path fill="currentColor" d="M7.94 13.06a1.5 1.5 0 0 1 0-2.12l5.656-5.658a1.5 1.5 0 1 1 2.121 2.122L11.122 12l4.596 4.596a1.5 1.5 0 1 1-2.12 2.122l-5.66-5.658Z" />
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="trigger right">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <g fill="none" fill-rule="evenodd">
                                                <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                <path fill="currentColor" d="M16.06 10.94a1.5 1.5 0 0 1 0 2.12l-5.656 5.658a1.5 1.5 0 1 1-2.121-2.122L12.879 12L8.283 7.404a1.5 1.5 0 0 1 2.12-2.122l5.658 5.657Z" />
                                            </g>
                                        </svg>
                                    </div>
                                    <span class="numberpage active">1</span>
                                    <span class="numberpage">2</span>
                                    <span class="numberpage">3</span>
                                    <span class="numberpage">4</span>
                                    <span class="numberpage">5</span>
                                    <span class="numberpage">...</span>
                                    <span class="numberpage">12</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#myCheckbox').change(function() {
                var isChecked = $(this).is(':checked');

                $('tbody tr:not([style="display: none;"]) [id^="myCheckbox-"]').prop('checked', isChecked);
            });
        });

        $(document).ready(function() {
            $('#myCheckbox, [id^="myCheckbox-"]').change(function() {
                var isChecked = $('#myCheckbox:checked, [id^="myCheckbox-"]:checked').length > 0;
                if (isChecked) {
                    $('.all_act_butt').css('display', 'flex');
                } else {
                    $('.all_act_butt').hide();
                }
            });

        });

        // clear readonly
        $(document).ready(function() {
            $('.groupeditinput svg').click(function() {
                $(this).closest('.groupeditinput').toggleClass('edit');
                $(this).siblings('input').prop('readonly', function(_, val) {
                    return !val;
                });
            });
        });

        // status read atau unread
        $(document).ready(function() {
            $(".dataxstatus").each(function() {
                var status = $(this).attr("data-status");
                var xstatusElement = $(this).find(".xstatus");
                
                if (status === "0") {
                    xstatusElement.text("unread");
                } else if (status === "1") {
                    xstatusElement.text("read");
                }
            });
        });

        //open jendela detail
        $(document).ready(function() {
            $(".openviewport").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 700;
                var windowHeight = $(window).height() * 0.65;
                var windowLeft = ($(window).width() - windowWidth) / 1;
                var windowTop = ($(window).height() - windowHeight) / 0.95;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" + windowLeft + ", top=" + windowTop);
            });
        });
    </script>
@endsection
