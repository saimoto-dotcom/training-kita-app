<?php

namespace App\Http\Controllers;

use App\Consts\AppConsts;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        // 検索条件取得
        $lastName = trim($request->query('last_name', ''));
        $firstName = trim($request->query('first_name', ''));
        $email = trim($request->query('email', ''));

        // クエリ作成
        $adminUsers = AdminUser::query()
            ->when($lastName !== '', function ($query) use ($lastName) {
                $query->where('last_name', 'like', "%{$lastName}%");
            })
            ->when($firstName !== '', function ($query) use ($firstName) {
                $query->where('first_name', 'like', "%{$firstName}%");
            })
            ->when($email !== '', function ($query) use ($email) {
                $query->where('email', 'like', "%{$email}%");
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(AppConsts::ARTICLES_PER_PAGE);

        // Blade に渡す
        return view('admin.admin_users.index', compact(
            'adminUsers',
            'lastName',
            'firstName',
            'email'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response
    {
        abort(501);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        abort(501);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id): Response
    {
        abort(501);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id): Response
    {
        abort(501);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): Response
    {
        abort(501);
    }
}
