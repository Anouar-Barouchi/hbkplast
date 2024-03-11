<?php

namespace Modules\User\Admin;

use Modules\Admin\Ui\AdminTable;

class UserTable extends AdminTable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected $rawColumns = ['created_at'];

    /**
     * Make table response for the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function make()
    {
        return $this->newTable()
            ->editColumn('created_at', function ($user) {
                return view('admin::partials.table.date')->with('date', $user->created_at);
            });
    }
}
