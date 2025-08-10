@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">

    <style>
        .text-danger {
            color: var(--red-color);
        }

        .text-success {
            color: var(--green-color);
        }
    </style>

    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>

        <div class="sechistoryds">
            <div class="grouphistoryds memberlist">

                <div class="tabelproses">
                    <table>
                        <tbody>
                            <tr class="hdtable">
                                {{-- target_month', 'status', 'message --}}
                                <th class="bagno">#</th>
                                <th class="period_backup">period backup</th>
                                <th class="status">status</th>
                                <th class="message">message</th>
                                <th class="created_at">created at</th>
                                <th class="updated_at">updated at</th>
                            </tr>
                            @foreach ($data as $i => $d)
                                <tr>
                                    <td>{{ ($data->currentPage() - 1) * $data->perPage() + 1 + $i }}</td>
                                    <td>{{ $d->date }}</td>
                                    <td 
                                    @php
                                        if($d->status == 'success') {
                                            echo 'class="text-success"';
                                        } else if($d->status == 'failed') {
                                            echo 'class="text-danger"';
                                        }
                                    @endphp
                                    >{{ strtoupper($d->status) }}</td>
                                    <td data-proses="accept">{{ $d->message }}</td>
                                    <td>{{ $d->created_at }}</td>
                                    <td>{{ $d->updated_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div>
                        {{ $data->links('vendor.pagination.customdashboard') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('gagalTarikData'))
        <script>
            Swal.fire({
                text: '{{ session('gagalTarikData') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
