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
                @foreach($feedback->comments as $comment)
                    @php
                        $regex = '/@([^\s]+)/';
                        $newContent = preg_replace($regex, '<span class="highlighted-mention">@$1</span>', $comment->content);
                    @endphp
                    <div class="row">
                        <div class="col-md-6">
                            <strong>{{ucwords($comment->user->name)}}</strong>
                        </div>
                        <div class="col-md-6 text-end">
                            {{\Carbon\Carbon::create($comment->created_at)->format('m/d/y')}}
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="comment-container">
                            {!! $newContent !!}
                        </div>
                    </div>
                    <hr style="border-top: 1px dotted #ccc; margin: 20px 0; background: #2f3745; margin-bottom: 3px">
                @endforeach
            </div>
        </div>

    @can('feedback-send-comment')
        <div class="card">
            <div class="card-body">
                <form action="{{ route('feedback.comment') }}" method="POST">
                    @csrf
                    <input type="hidden" name="feedback_id" value="{{ $feedback->id }}">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Comment: <span style="color: red;">*</span></label>
                        <textarea class="form-control" id="comment" name="comment"></textarea>
                        <div id="suggestions" style="display: none; border: 1px solid #ccc; position: absolute; background: #fff; max-height: 150px; overflow-y: auto;"></div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('feedback.index') }}" class="btn btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary ms-3">Comment <i class="ph-paper-plane-tilt ms-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    @endcan

    <!-- Your existing content here -->
@endsection

<style>
    .suggestion-item {
        padding: 5px;
        cursor: pointer;
        border-bottom: 1px solid #ccc;
    }

    .suggestion-item:last-child {
        border-bottom: none;
    }

    .highlighted-mention {
        color: blue; /* You can customize the styling here */
        font-weight: bold;
    }

    .toolbar {
        margin-bottom: 10px;
    }
</style>

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            const commentInput = $('#comment');
            const suggestionsContainer = $('#suggestions');
            let editor;
            ClassicEditor
                .create(document.querySelector('textarea[name="comment"]'))
                .then(ckEditor => {
                    editor = ckEditor;

                    editor.model.document.on('change:data', () => {
                        const editorData = editor.getData();
                        const matches = editorData.match(/@(\w+)/g);

                        if (matches) {
                            const lastMatch = matches[matches.length - 1];
                            const query = lastMatch.substring(1); // Remove '@' from the query

                            if (query.length > 0) {
                                fetchUsers(query);
                            } else {
                                suggestionsContainer.hide();
                            }
                        } else {
                            suggestionsContainer.hide();
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                });

            function fetchUsers(query) {
                $.ajax({
                    url: '{{ route("search-users") }}',
                    method: 'GET',
                    data: {query: query},
                    success: function (data) {
                        const users = data.users;
                        suggestionsContainer.empty();

                        if (users.length > 0) {
                            let suggestionItem = '';
                            $.each(users, function (index, user) {
                                suggestionItem += '<div class="suggestion-item">' + user.name + '</div>';
                            });
                            suggestionsContainer.html(suggestionItem);
                            suggestionsContainer.show();
                        } else {
                            suggestionsContainer.hide();
                        }
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            }

            suggestionsContainer.on('click', '.suggestion-item', function () {
                const username = $(this).text().trim();

                const currentComment = editor.getData();
                const cursorPosition = editor.model.document.selection.anchor.offset;
                const beforeCursor = currentComment.substring(0, cursorPosition);
                const afterCursor = currentComment.substring(cursorPosition);
                const isAtSymbolBeforeCursor = beforeCursor.trim().endsWith('@');
                const newComment = isAtSymbolBeforeCursor ? beforeCursor.replace(/@(\w*)$/, '@' + username) + ' ' + afterCursor : beforeCursor + '@' + username + ' ' + afterCursor;

                editor.setData(newComment);
                suggestionsContainer.hide();
            });
        });
    </script>
@endpush
