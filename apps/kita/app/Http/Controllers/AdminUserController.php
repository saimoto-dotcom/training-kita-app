<?php

namespace App\Http\Controllers;

use App\Consts\AppConsts;
use App\Http\Requests\AdminUserStoreRequest;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Models\AdminUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     */
    public function edit(int $id)
    {
        // IDでモデルを取得
        $admin_user = AdminUser::findOrFail($id);

        return view('admin.admin_users.edit', compact('admin_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminUserUpdateRequest $request
     * @param AdminUser $admin_user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminUserUpdateRequest $request, AdminUser $admin_user): RedirectResponse
    {
        // バリデーション済みデータ取得
        $validated = $request->validated();

        // 更新データを整形
        $data = [
            'last_name'  => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'email'      => $validated['email'],
        ];

        // 更新実行
        $admin_user->update($data);

        // 成功時は同画面にリダイレクト＋フラッシュメッセージ
        return redirect()
            ->route('admin_users.edit', $admin_user->id)
            ->with('success', '更新処理が完了しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AdminUser  $admin_user
     * @return RedirectResponse
     */
    public function destroy(AdminUser $admin_user): RedirectResponse
    {
        // 削除処理
        $admin_user->delete();

        // 管理者一覧へリダイレクト
        return redirect()
            ->route('admin_users.index')
            ->with('success', '削除処理が完了しました');
    }
}
