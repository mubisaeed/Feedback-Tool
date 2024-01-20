@extends('layouts.app')
@section('content')
    @include('partials.breadcrums', ['route1' => 'feedback.index', 'component1' => 'Feedbacks', 'component2' => 'Feedback List'])
    @include('partials.alerts')
    <div class="content">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-striped">
                    @if(count($feedbacks) > 0)
                        <thead>
                        <tr class="bg-dark text-white">
                            <th>Title</th>
                            <th>Category</th>
                            <th>User</th>
                            @canany(['feedback-show'])
                                <th></th>
                            @endcanany
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($feedbacks as $key => $feedback)
                            <tr>
                                <td>{{$feedback->title ?? ''}}</td>
                                <td>{{$feedback->category->name ?? ''}}</td>
                                <td>{{ucwords($feedback->user->name) ?? ''}}</td>
                                @canany(['feedback-show'])
                                <td>
                                    @can('feedback-show')
                                        <a href="{{route('feedback.show', $feedback->id)}}" class="btn btn-light">Show</a>
                                    @endcan
                                </td>
                                @endcanany
                            </tr>
                        @endforeach
                        </tbody>
                    @else
                        <h2 class="pt-2" style="margin-left: 400px">No Record Found</h2>
                    @endif
                </table>
            </div>
        </div>
        <div class="mt-4 mb-4 text-end">
            {{ $feedbacks->withQueryString()->onEachSide(3)->links() }}
        </div>
    </div>
@endsection
