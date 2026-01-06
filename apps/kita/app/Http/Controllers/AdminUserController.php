<?php

namespace App\Http\Controllers;

use App\Consts\AppConsts;
use App\Http\Requests\AdminUserStoreRequest;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
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
            ->when(
                $request->filled('last_name'),
                fn ($q) => $q->where(
                    'last_name',
                    'like',
                    '%'.trim($request->last_name).'%'
                )
            )
            ->when(
                $request->filled('first_name'),
                fn ($q) => $q->where(
                    'first_name',
                    'like',
                    '%'.trim($request->first_name).'%'
                )
            )
            ->when(
                $request->filled('email'),
                fn ($q) => $q->where(
                    'email',
                    'like',
                    '%'.trim($request->email).'%'
                )
            )
            ->orderBy('updated_at', 'desc')
            ->paginate(AppConsts::ARTICLES_PER_PAGE)
            // 検索条件保持
            ->appends($request->query());

        // Blade に渡す
        return view('admin.admin_users.index', compact(
            'adminUsers',
            'lastName',
            'firstName',
            'email'
        ));
    }

    /**
     * Show the form for creating a new article.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('admin.admin_users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AdminUserStoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminUserStoreRequest $request)
    {
        // バリデーション済みデータのみ取得
        $validated = $request->validated();

        // DB登録処理
        $adminUser = AdminUser::create([
            'last_name'  => trim($validated['last_name']),
            'first_name' => trim($validated['first_name']),
            'email'      => trim($validated['email']),
            'password'   => Hash::make($validated['password']),
        ]);

        // 編集画面へリダイレクト + フラッシュメッセージ
        return redirect()
            ->route('admin_users.edit', $adminUser->id)
            ->with('success', '登録処理が完了しました');
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
