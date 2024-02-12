@extends('layouts.app')
@section('content')
    @include('partials.breadcrums', ['route1' => 'feedback.index', 'component1' => 'Feedbacks', 'component2' => 'Create Feedback'])
    @include('partials.alerts')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <form action="{{route('feedback.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Title: <span style="color: red;">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="Enter feedback title" required value="{{old('title')}}">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Category: <span style="color: red;">*</span></label>
                                <select class="form-control form-control-select2" name="category_id" required>
                                    <optgroup>
                                        <option value="" selected>Select category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description: <span style="color: red;">*</span></label>
                        <textarea class="form-control" id="comment" name="description">{{old('description')}}</textarea>
                        <div id="suggestions" style="display: none; border: 1px solid #ccc; position: absolute; background: #fff; max-height: 150px; overflow-y: auto;"></div>
                    </div>
                    <div class="text-end">
                        <a href="{{route('feedback.index')}}" class="btn btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary ms-3">Create <i class="ph-paper-plane-tilt ms-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            const commentInput = $('#comment');
            const suggestionsContainer = $('#suggestions');
        });


        ClassicEditor
            .create(document.querySelector('textarea[name="description"]'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    const editorData = editor.getData();
                    const matches = editorData.match(/@(\w+)/g);

                    if (matches) {
                        const lastMatch = matches[matches.length - 1];
                        const query = lastMatch.substring(1); // Remove '@' from the query

                        if (query.length > 0) {
                            console.log('sds');
                            fetchUsers(query);
                        }
                    }
                });
            })
            .catch(error => {
                console.error(error);
            });


        function fetchUsers(query) {
            console.log(query);
            $.ajax({
                url: '{{ route("search-users") }}',
                method: 'GET',
                data: { query: query },
                success: function (data) {
                    const users = data.users;
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
                },
                error: function (error) {
                    console.error(error);
                }
            });
        }

        // ClassicEditor
        //     .create( document.querySelector( 'textarea[name="description"]' ) )
        //     .catch( error => {
        //         console.error( error );
        //     } );
    </script>
@endpush
