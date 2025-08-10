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

        .countdatapend {
            width: unset;
            right: 10px;
            padding: 3px 10px;
            background: var(--red-color);
            font-size: 12px;
            color: white;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .headsecreportds a {
            display: flex;
            justify-content: space-between;
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
                <div class="headsecreportds">
                    <a href="/jobmonitoring/job" class="tombol grey active">
                        <span class="texttombol">Jobs</span>
                        <span class="countdatapend" id="countWD">{{ $countDataJob }}</span>
                    </a>
                    <a href="/jobmonitoring/failjob" class="tombol grey">
                        <span class="texttombol">Failed Jobs</span>
                         <span class="countdatapend" id="countWD">{{ $countDataFailJob }}</span>
                    </a>
                </div>
                <div class="tabelproses">
                    <table>
                        <tbody>
                            <tr class="hdtable">
                                <th class="bagno">#</th>
                                <th class="period_backup">queue</th>
                                <th class="status">attempts</th>
                                <th class="message">reserved at</th>
                                <th class="created_at">available at</th>
                                <th class="updated_at">created at</th>
                            </tr>
                            @foreach ($data as $i => $d)
                                <tr>
                                    <td>{{ ($data->currentPage() - 1) * $data->perPage() + 1 + $i }}</td>
                                    <td>{{ $d->queue }}</td>
                                    <td>{{ $d->attempts }}</td>
                                    <td>{{ $d->reserved_at }}</td>
                                    <td>{{ $d->available_at }}</td>
                                    <td>{{ $d->created_at }}</td>
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
