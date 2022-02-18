@extends('admin::layouts.panel')
@section('title',__('comment::comment.edit_comment'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('comment::comment.edit_comment') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('comment::comment.edit_comment') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.comments.update',$comment) }}" method="post">
                        @csrf
                        @method('PUT')
                        @if(!empty(session('success')))
                            <div class="alert alert-success">
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        @endif
                        @if(!empty($errors->all()))
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="commenter_id"
                                           class="form-label">{{ __('comment::comment.commenter_id') }}</label>
                                    <input type="text" class="form-control" id="commenter_id" name="commenter_id"
                                           value="{{ old('commenter_id',$comment->commenter_id) }}" readonly>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="commenter_type"
                                           class="form-label">{{ __('comment::comment.commenter_type') }}</label>
                                    <input type="text" class="form-control" id="commenter_type" name="commenter_type"
                                           value="{{ old('commenter_type',$comment->commenter_type) }}" readonly>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="guest_name"
                                           class="form-label">{{ __('comment::comment.guest_name') }}</label>
                                    <input type="text" class="form-control" id="guest_name" name="guest_name"
                                           value="{{ old('guest_name',$comment->guest_name) }}" readonly>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="guest_email"
                                           class="form-label">{{ __('comment::comment.guest_email') }}</label>
                                    <input type="email" class="form-control" id="guest_email" name="guest_email"
                                           value="{{ old('guest_email',$comment->guest_email) }}" readonly>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="commentable_id"
                                           class="form-label">{{ __('comment::comment.commentable_id') }}</label>
                                    <input type="text" class="form-control" id="commentable_id" name="commentable_id"
                                           value="{{ old('commentable_id',$comment->commentable_id) }}" readonly>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="commentable_type"
                                           class="form-label">{{ __('comment::comment.commentable_type') }}</label>
                                    <input type="text" class="form-control" id="commentable_type"
                                           name="commentable_type"
                                           value="{{ old('commentable_type',$comment->commentable_type) }}" readonly>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="scope"
                                           class="form-label">{{ __('comment::comment.scope') }}</label>
                                    <input type="number" class="form-control" id="scope"
                                           name="scope" value="{{ old('scope',$comment->scope) }}"
                                           max="{{ config('comment.max_score') }}" required autofocus tabindex="1">
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="comment" class="form-label">{{ __('comment::comment.comment') }}</label>
                                    <textarea class="form-control" id="comment" rows="4" name="comment"
                                              tabindex="2">{{ old('comment',$comment->comment) }}</textarea>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="approved" name="approved"
                                               tabindex="3"
                                               value="1" {{ $comment->approved?'checked':'' }}>
                                        <label for="approved"
                                               class="form-check-label">{{ __('comment::comment.approved') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2" tabindex="4"><i
                                    class="mdi mdi-content-save"></i> {{ __('admin::admin.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
