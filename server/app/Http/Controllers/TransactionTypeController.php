<?php

namespace App\Http\Controllers;

use App\Enums\OperationType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

use App\TransactionType;
use App\Http\Requests\TransactionTypeRequest;

class TransactionTypeController extends Controller
{
    /**
     * Create a new TransactionTypeController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get all transactions
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $transactions = TransactionType::all();

        return response()->json([
            'success'           => true,
            'message'           => 'Dados obtidos com sucesso.',
            'transaction_types' => $transactions,
        ]);
    }

    /**
     * Save a transaction type
     *
     * @param TransactionTypeRequest $request
     *
     * @return JsonResponse
     */
    public function store(TransactionTypeRequest $request): JsonResponse
    {
        $transactionType = TransactionType::create([
            'code'      => $request->code,
            'name'      => $request->name,
            'operation' => OperationType::getKey($request->operation),
        ]);

        return response()->json([
            'success'          => true,
            'message'          => 'Tipo de transação criado com sucesso.',
            'transaction_type' => $transactionType,
        ]);
    }

    /**
     * Update an account
     *
     * @param String $id
     * @param TransactionTypeRequest $request
     *
     * @return JsonResponse
     */
    public function update(String $id, TransactionTypeRequest $request): JsonResponse
    {
        $transactionType = TransactionType::find($id);

        $transactionType->update([
            'code'      => $request->code,
            'name'      => $request->name,
            'operation' => OperationType::getKey($request->operation),
        ]);

        return response()->json([
            'success'          => true,
            'message'          => 'Tipo de transação atualizado com sucesso.',
            'transaction_type' => $transactionType,
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
        $transactionType = TransactionType::find($id);
        $transactionType->delete();

        return response()->json([
            'success'          => true,
            'message'          => 'Tipo de transação removido com sucesso.',
            'transaction_type' => $transactionType,
        ]);
    }
}
