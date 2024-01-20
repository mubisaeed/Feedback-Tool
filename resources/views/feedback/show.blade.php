@extends('layouts.app')
@section('content')
    @include('partials.breadcrums', ['route1' => 'feedback.index', 'component1' => 'Feedbacks', 'component2' => 'Feedback Show'])
    @include('partials.alerts')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <p>{!! $feedback->description !!}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @foreach(@$feedback->comments as $comment)
                    <div class="row">
                        <div class="col-md-6">
                            <strong>{{$comment->user->name}}</strong>
                        </div>
                        <div class="col-md-6 text-end">
                            {{\Carbon\Carbon::create($comment->created_at)->format('m/d/y')}}
                        </div>
                    </div>
                    <div class="mt-3">
                        <p>{!! $comment->content !!}</p>
                    </div>
                    <hr style="border-top: 1px dotted #ccc; margin: 20px 0; background: #2f3745; margin-bottom: 3px">
                @endforeach
            </div>
        </div>

        @can('feedback-send-comment')
        <div class="card">
            <div class="card-body">
                <form action="{{route('feedback.comment')}}" method="POST">
                    @csrf
                    <input type="hidden" name="feedback_id" value="{{$feedback->id}}">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Comment: <span style="color: red;">*</span></label>
                        <textarea class="form-control" name="content">{{old('content')}}</textarea>
                    </div>
                    <div class="text-end">
                        <a href="{{route('feedback.index')}}" class="btn btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary ms-3">Comment <i class="ph-paper-plane-tilt ms-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
        @endcan
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( 'textarea[name="content"]' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endpush
