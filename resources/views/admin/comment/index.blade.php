@extends('admin::layouts.panel')
@section('title',__('comment::comment.comments'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('comment::comment.comments') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('comment::comment.comments') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="comments_table" class="table table-centered w-100 dt-responsive nowrap">
                            <thead class="table-light">
                            <tr>
                                <th>{{ __('comment::comment.id') }}</th>
                                <th>{{ __('comment::comment.commenter_id') }}</th>
                                <th>{{ __('comment::comment.commenter_type') }}</th>
                                <th>{{ __('comment::comment.guest_name') }}</th>
                                <th>{{ __('comment::comment.guest_email') }}</th>
                                <th>{{ __('comment::comment.commentable_id') }}</th>
                                <th>{{ __('comment::comment.commentable_type') }}</th>
                                <th>{{ __('comment::comment.score') }}</th>
                                <th>{{ __('comment::comment.approved') }}</th>
                                <th>{{ __('comment::comment.parent') }}</th>
                                <th>{{ __('comment::comment.created_at') }}</th>
                                <th>{{ __('comment::comment.updated_at') }}</th>
                                <th>{{ __('comment::comment.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            let table = $('#comments_table').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('admin.comments.index') }}",
                "language": language,
                "pageLength": pageLength,
                "columns": [
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': false},
                ],
                "order": [[0, "desc"]],
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                    $('#comments_table tr td:nth-child(13)').addClass('table-action');
                    delete_listener();
                }
            });
            table.on('childRow.dt', function (e, row) {
                delete_listener();
            });
        });
    </script>
@endsection
