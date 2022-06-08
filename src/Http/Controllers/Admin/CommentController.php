<?php

namespace Dealskoo\Comment\Http\Controllers\Admin;

use Dealskoo\Admin\Http\Controllers\Controller as AdminController;
use Dealskoo\Comment\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends AdminController
{
    public function index(Request $request)
    {
        abort_if(!$request->user()->canDo('comments.index'), 403);
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('comment::admin.comment.index');
        }
    }

    private function table(Request $request)
    {
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'commenter_id', 'commenter_type', 'guest_name', 'guest_email', 'commentable_id', 'commentable_type', 'score', 'approved', 'parent_id', 'created_at', 'updated_at'];
        $column = $columns[$request->input('order.0.column', 0)];
        $desc = $request->input('order.0.dir', 'desc');
        $query = Comment::query();
        if ($keyword) {
            $query->where('comment', 'like', '%' . $keyword . '%');
            $query->orWhere('guest_name', 'like', '%' . $keyword . '%');
            $query->orWhere('guest_email', 'like', '%' . $keyword . '%');
        }
        $query->orderBy($column, $desc);
        $count = $query->count();
        $comments = $query->skip($start)->take($limit)->get();
        $rows = [];
        $can_view = $request->user()->canDo('comments.show');
        $can_edit = $request->user()->canDo('comments.edit');
        $can_destroy = $request->user()->canDo('comments.destroy');
        foreach ($comments as $comment) {
            $row = [];
            $row[] = $comment->id;
            $row[] = $comment->commenter_id;
            $row[] = $comment->commenter_type;
            $row[] = $comment->guest_name;
            $row[] = $comment->guest_email;
            $row[] = $comment->commentable_id;
            $row[] = $comment->commentable_type;
            $row[] = $comment->score;
            $row[] = $comment->approved;
            $row[] = $comment->parent_id;
            $row[] = $comment->created_at->format('Y-m-d H:i:s');
            $row[] = $comment->updated_at->format('Y-m-d H:i:s');
            $view_link = '';
            if ($can_view) {
                $view_link = '<a href="' . route('admin.comments.show', $comment) . '" class="action-icon"><i class="mdi mdi-eye"></i></a>';
            }

            $edit_link = '';
            if ($can_edit) {
                $edit_link = '<a href="' . route('admin.comments.edit', $comment) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
            }
            $destroy_link = '';
            if ($can_destroy) {
                $destroy_link = '<a href="javascript:void(0);" class="action-icon delete-btn" data-table="comments_table" data-url="' . route('admin.comments.destroy', $comment) . '"> <i class="mdi mdi-delete"></i></a>';
            }
            $row[] = $view_link . $edit_link . $destroy_link;
            $rows[] = $row;
        }
        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $rows
        ];
    }

    public function show(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('comments.show'), 403);
        $comment = Comment::query()->findOrFail($id);
        return view('comment::admin.comment.show', ['comment' => $comment]);
    }

    public function edit(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('comments.edit'), 403);
        $comment = Comment::query()->findOrFail($id);
        return view('comment::admin.comment.edit', ['comment' => $comment]);
    }

    public function update(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('comments.edit'), 403);
        $request->validate([
            'score' => ['required', 'digits_between:0,' . config('comment.max_score')],
            'comment' => ['required'],
        ]);
        $comment = Comment::query()->findOrFail($id);
        $comment->fill($request->only([
            'score',
            'comment',
        ]));
        $comment->approved = $request->boolean('approved', false);
        $comment->save();
        return back()->with('success', __('admin::admin.update_success'));
    }

    public function destroy(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('comments.destroy'), 403);
        return ['status' => Comment::destroy($id)];
    }
}
