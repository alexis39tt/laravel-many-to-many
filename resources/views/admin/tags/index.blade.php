@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Tag list</div>
                    <div class="card-body">
                        <div class="new-post">
                            <form class="d-flex mb-3" action="{{ route('tags.store') }}" method="POST">
                                <button type="submit" class="btn btn-success mr-2 btnP">New Tag</button>
                                <div>
                                    @csrf
                                    <input value="@if (old('formType') == 'create') {{ old('name') }} @endif" type="text"
                                        class="form-control @if (old('formType') == 'create') is-invalid @endif" id="name"
                                        placeholder="Insert the tag" name="name">
                                    <input type="hidden" name="formType" value="create">
                                </div>
                                @if (old('formType') == 'create')
                                    @error('name')
                                        <div class="alert alert-danger ml-2 mb-0 py-0 px-4 d-flex align-items-center">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                @endif
                            </form>
                        </div>
                        <div class="posts">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tags as $key => $tag)
                                        <tr class="my_item">
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>
                                                <div
                                                    class="name {{ old('formType') == 'edit' && old('oldName') == $tag->name ? 'd-none' : '' }}">
                                                    {{ $tag->name }}</div>
                                                <div
                                                    class="name-input {{ old('formType') == 'edit' && old('oldName') == $tag->name ? '' : 'd-none' }}">
                                                    <form class="d-inline-block edit-form"
                                                        action="{{ route('tags.update', $tag) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input
                                                            value="{{ old('oldName') == $tag->name ? old('name') : $tag->name }}"
                                                            type="text"
                                                            class="form-control @if (old('formType') == 'edit' && old('oldName') == $tag->name) is-invalid my_validation @endif"
                                                            id="name" placeholder="Insert the name" name="name" data-old-name="{{$tag->name}}">
                                                        <input type="hidden" name="formType" value="edit">
                                                        <input type="hidden" name="oldName" value="{{ $tag->name }}">
                                                        @if (old('formType') == 'edit' && old('oldName') == $tag->name)
                                                            @error('name')
                                                                <div
                                                                    class="alert alert-danger mb-0 py-0 px-4 d-flex align-items-center">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        @endif
                                                    </form>
                                                </div>
                                            </td>
                                            <td>{{ $tag->slug }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info"><a class="text-white"
                                                        href="{{ route('tags.show', $tag->id) }}">View</a></button>
                                                <div class="edit-buttons d-inline-block">
                                                    <button type="button"
                                                        class="btn btn-warning btnP text-white toggleForm {{ old('oldName') == $tag->name ? 'd-none' : ''}}">Edit</button>
                                                    <button type="button"
                                                        class="btn btn-warning btnP text-white submitForm {{ old('oldName') == $tag->name ? 'failed-validation' : 'd-none' }} ">Confirm</button>
                                                </div>
                                                <button type="submit" class="btn btn-danger btnToggle btnP"
                                                    data-toggle="modal" data-target="#exampleModal"
                                                    data-slug="{{ $tag->id }}">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-uppercase" id="exampleModalLabel">Attention! ???</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this tag?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary btnP"
                                                data-dismiss="modal">Close</button>
                                            <form action="" method="POST" class="my_form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger toastClicker delete-tag btnP"
                                                    data-dismiss="modal">Confirm</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Toast -->
                            <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 9999; right: 0; top: 60px;">
                                <div id="liveToast" class="toast hide" role="alert" aria-live="assertive"
                                    aria-atomic="true" data-delay="2000">
                                    <div class="toast-body">
                                        Tag successfully deleted! ????
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
