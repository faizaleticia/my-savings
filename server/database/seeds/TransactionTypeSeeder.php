<?php

use App\Enums\OperationType;
use App\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionType::create([
            'code'      => 0,
            'name'      => 'Despesa',
            'operation' => OperationType::getKey(OperationType::Subtraction)
        ]);

        TransactionType::create([
            'code'      => 1,
            'name'      => 'Receita',
            'operation' => OperationType::getKey(OperationType::Sum)
        ]);

        TransactionType::create([
            'code'      => 2,
            'name'      => 'Transferência Saída',
            'operation' => OperationType::getKey(OperationType::Subtraction)
        ]);

        TransactionType::create([
            'code'      => 2,
            'name'      => 'Transferência Entrada',
            'operation' => OperationType::getKey(OperationType::Sum)
        ]);
    }
}
