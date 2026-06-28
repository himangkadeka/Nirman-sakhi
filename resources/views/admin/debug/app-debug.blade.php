@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Debug Mode - previewAdmin Error</h2>
        <div class="alert alert-danger">
            <strong>Error:</strong> {{ $error }}
            <br><strong>Exception:</strong> {{ $exception_message }}
        </div>
        <h4>Execution Trace:</h4>
        <table class="table table-sm">
            <tr><th>Step</th><th>Label</th><th>Time (ms)</th><th>Memory (MB)</th></tr>
            @foreach($debugLog as $log)
                <tr>
                    <td>{{ $log['step'] }}</td>
                    <td>{{ $log['label'] }}</td>
                    <td>{{ $log['time_ms'] }}</td>
                    <td>{{ $log['memory_mb'] }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection