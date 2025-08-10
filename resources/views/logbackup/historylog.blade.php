@extends('layouts.index')

@section('container')

<style>
    .container-top {
    display: flex;
    gap: 1rem; 
    align-items: center; 
}
    .container-top > form {
        flex: 1; 
    }

    pre {
        margin-top: 10px;
    }
</style>

<div class="container">
    <h1>{{ $title }}</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    
    <label for="logFile">Pilih Log File:</label>
    <div class="container-top">
       
        <form method="GET" action="/historylog" class="mb-3">
            <select name="logFile" id="logFile" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
                @foreach($availableLogs as $file)
                    <option value="{{ $file }}" {{ $file == $logFile ? 'selected' : '' }}>{{ $file }}</option>
                @endforeach
            </select>
        </form>

        <form action="/historylog/clear" method="POST" onsubmit="return confirm('Yakin ingin menghapus log?')">
            @csrf
            <input type="hidden" name="logFile" value="{{ $logFile }}">
            <button class="sec_botton btn_danger">Clear Log</button> 
        </form>
    </div>
    <pre style="background:#111;color:#0f0;padding:15px;height:600px;overflow:auto;">{{ $logs }}</pre>
</div>
@endsection
