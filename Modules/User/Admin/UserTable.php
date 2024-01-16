<?php

namespace Modules\User\Admin;

use Modules\Admin\Ui\AdminTable;
use Illuminate\Http\JsonResponse;

class UserTable extends AdminTable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected array $rawColumns = ['last_login'];


    /**
     * Make table response for the resource.
     *
     * @return JsonResponse
     */
    public function make()
    {
        return $this->newTable()
            ->editColumn('last_login', function ($user) {
                return view('admin::partials.table.date')->with('date', $user->last_login);
            });
    }
}
