<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\MenuItem;

class MenuItemController extends Controller
{
    /**
     * Get all menu items
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $menuItems = MenuItem::all();

        return response()->json([
            'success'    => true,
            'message'    => 'Dados obtidos com sucesso.',
            'menu_items' => $menuItems,
        ]);
    }
}
