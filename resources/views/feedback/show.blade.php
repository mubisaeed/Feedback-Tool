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

        <div class="toolbar">
            <button style="border: none;background: #F3F4F6; color: #8f2929 " onclick="toggleBold()">Bold</button>
            <span>(Click on Bold button after text select to bold.)</span>
        </div>

    @can('feedback-send-comment')
        <div class="card">
            <div class="card-body">
                <form action="{{route('feedback.comment')}}" method="POST">
                    @csrf
                    <input type="hidden" name="feedback_id" value="{{$feedback->id}}">
                    <div class="mb-3" >
                        <label class="form-label fw-semibold">Comment: <span style="color: red;">*</span></label>
                        <textarea class="form-control" id="comment" name="comment"></textarea>

                        <!-- Suggestions Popup -->
                        <div id="suggestions" style="display: none; border: 1px solid #ccc; position: absolute; background: #fff; max-height: 150px; overflow-y: auto;"></div>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function () {
            const commentInput = $('#comment');
            const suggestionsContainer = $('#suggestions');
            commentInput.on('input', function () {
                const inputValue = $(this).val();
                const cursorPosition = commentInput.prop('selectionStart');
                const textBeforeCursor = inputValue.substring(0, cursorPosition);

                if (textBeforeCursor.endsWith('@')) {
                    const query = inputValue.split('@')[1].split(' ')[0];
                    const url = 'http://127.0.0.1:8000/feedback/search-users';

                    axios.get(url)
                        .then(response => {
                            const users = response.data.users;
                            suggestionsContainer.empty();

                            if (users.length > 0) {
                                let suggestionItem = '';
                                $.each(users, function (index, data) {
                                    suggestionItem += '<div class="suggestion-item">'+ data.name + '</div>';
                                });
                                suggestionsContainer.append(suggestionItem);
                                suggestionsContainer.show();
                            } else {
                                suggestionsContainer.hide();
                            }
                        })
                        .catch(error => {
                            console.error(error);
                        });
                } else {
                    suggestionsContainer.hide();
                }
            });
            suggestionsContainer.on('click', '.suggestion-item', function () {
                const username = $(this).text().trim();
                const currentComment = commentInput.val();
                const cursorPosition = commentInput.prop('selectionStart');
                const beforeCursor = currentComment.substring(0, cursorPosition);
                const afterCursor = currentComment.substring(cursorPosition);
                const isAtSymbolBeforeCursor = beforeCursor.trim().endsWith('@');
                commentInput.val(isAtSymbolBeforeCursor ? beforeCursor + username + ' ' + afterCursor : beforeCursor + '@' + username + ' ' + afterCursor);
                suggestionsContainer.hide();
            });
        });

        function toggleBold() {
            const textarea = document.getElementById('comment');
            const selectedText = textarea.value.substring(textarea.selectionStart, textarea.selectionEnd);

            if (selectedText !== '') {
                const boldText = '<strong>' + selectedText + '</strong>';
                const textBeforeCursor = textarea.value.substring(0, textarea.selectionStart);
                const textAfterCursor = textarea.value.substring(textarea.selectionEnd);
                textarea.value = textBeforeCursor + boldText + textAfterCursor;
            }
        }
    </script>
@endpush
