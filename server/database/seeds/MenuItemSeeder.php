<?php

use Illuminate\Database\Seeder;

use App\MenuItem;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuItem::create([
            'title'       => 'Contas',
            'description' => 'Gerencia suas contas financeiras: Ao manter suas contas financeiras no MySavings, é possível obter diversas métricas, tais como: saldo inicial, saldo atual, receitas e despesas por período e comparativos de saídas e entradas.',
            'route'       => '/accounts',
        ]);
    }
}
