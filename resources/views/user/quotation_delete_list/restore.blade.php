@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header clearfix">
            </div>
            @include('user/'.$type.'/_details')
        </div>
    </div>
@stop

@section('scripts')
    <script>
    </script>
@endsection