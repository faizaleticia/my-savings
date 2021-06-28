<?php

namespace App\Http\Controllers;

use App\Enums\OperationType;
use App\Transaction;
use App\Http\Requests\TransactionRequest;

use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
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
     * Save an transaction by user account
     *
     * @param TransactionRequest $request
     *
     * @return JsonResponse
     */
    public function storeTransactionByUserAccount($accountId, TransactionRequest $request): JsonResponse
    {
        $transaction = Transaction::create([
            'account_id'          => $accountId,
            'value'               => $request->value,
            'transaction_type_id' => $request->transaction_type_id,
        ]);

        return response()->json([
            'success'     => true,
            'message'     => 'Transação criada com sucesso.',
            'transaction' => $transaction,
        ]);
    }

    /**
     * Update an transaction by user account
     *
     * @param String $accountId
     * @param String $transactionId
     * @param TransactionRequest $request
     *
     * @return JsonResponse
     */
    public function updateTransactionByUserAccount($accountId, $transactionId, TransactionRequest $request): JsonResponse
    {
        $transaction = Transaction::where('id', $transactionId)
            ->where('account_id', $accountId)
            ->first();

        $transaction->update([
            'value'               => $request->value,
            'transaction_type_id' => $request->transaction_type_id,
        ]);

        return response()->json([
            'success'     => true,
            'message'     => 'Transação atualizado com sucesso.',
            'transaction' => $transaction,
        ]);
    }

    /**
     * Get all transactions by user account
     *
     * @return JsonResponse
     */
    public function getTransactionsByUserAccount($accountId): JsonResponse
    {
        $transactions = Transaction::where('account_id', $accountId)->get();

        return response()->json([
            'success'      => true,
            'message'      => 'Dados obtidos com sucesso.',
            'transactions' => $transactions,
        ]);
    }

    /**
     * Get tota value by user account
     *
     * @return JsonResponse
     */
    public function getTotalByUserAccount($accountId): JsonResponse
    {
        $transactions = Transaction::where('account_id', $accountId)->get();

        $total = 0;

        foreach ($transactions as $transaction) {
            if ($transaction->transactionType->operation === OperationType::getKey(OperationType::Subtraction)) {
                $total -= $transaction->value;
            } else if ($transaction->transactionType->operation === OperationType::getKey(OperationType::Sum)) {
                $total += $transaction->value;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Dados obtidos com sucesso.',
            'total'   => $total,
        ]);
    }

    /**
     * Remove an transaction by user account
     *
     * @param String $accountId
     *
     * @return JsonResponse
     */
    public function destroyTransactionByUserAccount(String $accountId, String $transactionId): JsonResponse
    {
        $transaction = Transaction::where('id', $transactionId)
            ->where('account_id', $accountId)
            ->first();

        $transaction->delete();

        return response()->json([
            'success'     => true,
            'message'     => 'Transação removida com sucesso.',
            'transaction' => $transaction,
        ]);
    }

    /**
     * Remove all transactions by user account
     *
     * @param String $accountId
     *
     * @return JsonResponse
     */
    public function destroyAllTransactionsByUserAccount(String $accountId): JsonResponse
    {
        $transactions = Transaction::where('account_id', $accountId)->get();

        foreach ($transactions as $transaction) {
            $transaction->delete();
        }

        return response()->json([
            'success'     => true,
            'message'     => 'Transações removidas com sucesso.',
            'transaction' => $transactions,
        ]);
    }
}
