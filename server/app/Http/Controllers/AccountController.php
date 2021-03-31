<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

use App\Account;
use App\Http\Requests\AccountRequest;

class AccountController extends Controller
{
    /**
     * Create a new AccountController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get all accounts
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $accounts = Account::where('user_id', Auth::user()->id)->get();

        return response()->json([
            'success'  => true,
            'message'  => 'Dados obtidos com sucesso.',
            'accounts' => $accounts,
        ]);
    }

    /**
     * Save an account
     *
     * @param AccountRequest $request
     *
     * @return JsonResponse
     */
    public function store(AccountRequest $request): JsonResponse
    {
        $account = Account::create([
            'letter'      => $request->letter,
            'name'        => $request->name,
            'description' => $request->description,
            'color'       => $request->color,
            'user_id'     => Auth::user()->id,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Conta criada com sucesso.',
            'account'  => $account,
        ]);
    }

    /**
     * Update an account
     *
     * @param String $id
     * @param AccountRequest $request
     *
     * @return JsonResponse
     */
    public function update(String $id, AccountRequest $request): JsonResponse
    {
        $account = Account::find($id);

        $account->update([
            'letter'      => $request->letter,
            'name'        => $request->name,
            'description' => $request->description,
            'color'       => $request->color,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Conta atualizada com sucesso.',
            'account'  => $account,
        ]);
    }

    /**
     * Remove an account
     *
     * @param String $id
     *
     * @return JsonResponse
     */
    public function destroy(String $id): JsonResponse
    {
        $account = Account::find($id);
        $account->delete();

        return response()->json([
            'success'  => true,
            'message'  => 'Conta removida com sucesso.',
            'account'  => $account,
        ]);
    }
}
