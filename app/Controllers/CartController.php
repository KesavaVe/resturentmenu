<?php

namespace App\Controllers;
use App\Models\CartProductModel;
class CartController extends BaseController
{
    private const TAX_RATE = 12.5;

    public function index()
    {
        $cart = session()->get('cart') ?? [];

        $items = $this->getItems();

        return view('cart', [
            'items' => $items,
            'cart' => $cart,
            'summary' => $this->calculateSummary($cart)
        ]);
    }

    public function add()
    {
        $itemId = (int) $this->request->getPost('item_id');

        if ($itemId <= 0) {
            return redirect()
                ->back()
                ->with('error', 'Invalid item');
        }

        $model = new CartProductModel();

        $item = $model
            ->where('id', $itemId)
            ->where('status', 1)
            ->first();

        if (!$item) {
            return redirect()
                ->back()
                ->with('error', 'Item not found');
        }

        $cart = session()->get('cart') ?? [];

        // Item already exists → increase quantity
        if (isset($cart[$itemId])) {

            $cart[$itemId]['quantity']++;

        } else {

            // First time adding item
            $cart[$itemId] = [
                'item_id' => (int) $item['id'],
                'name' => $item['name'],
                'price' => (float) $item['price'],
                'quantity' => 1
            ];
        }

        session()->set('cart', $cart);

        return redirect()->to('/cart');
    }

    public function increase()
    {
        $itemId = (int) $this->request->getPost('item_id');

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity']++;
        }

        session()->set('cart', $cart);

        return redirect()->to('/cart');
    }

    public function decrease()
    {
        $itemId = (int) $this->request->getPost('item_id');

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity']--;

            if ($cart[$itemId]['quantity'] <= 0) {
                unset($cart[$itemId]);
            }
        }

        session()->set('cart', $cart);

        return redirect()->to('/cart');
    }

    public function remove()
    {
        $itemId = (int) $this->request->getPost('item_id');

        $cart = session()->get('cart') ?? [];

        unset($cart[$itemId]);

        session()->set('cart', $cart);

        return redirect()->to('/cart');
    }

    public function clear()
    {
        session()->remove('cart');

        return redirect()->to('/cart');
    }

    private function getItems(): array
    {
        $model = new CartProductModel();

        $items = $model
            ->where('status', 1)
            ->orderBy('id', 'ASC')
            ->findAll();

        $result = [];

        foreach ($items as $item) {

            $result[(int) $item['id']] = [
                'item_id' => (int) $item['id'],
                'name' => $item['name'],
                'price' => (float) $item['price'],
            ];
        }

        return $result;
    }

    private function calculateSummary(array $cart): array
    {
        $totalInclTax = 0;

        foreach ($cart as $item) {
            $totalInclTax += $item['price'] * $item['quantity'];
        }

        // Prices already include 12.5% tax.
        $tax = $totalInclTax * (self::TAX_RATE / (100 + self::TAX_RATE));

        $subtotal = $totalInclTax - $tax;

        return [
            'subtotal' => round($subtotal, 2),
            'tax' => round($tax, 2),
            'total' => round($totalInclTax, 2)
        ];
    }

    public function updateQuantity()
    {
        $itemId = (int) $this->request->getPost('item_id');
        $quantity = (int) $this->request->getPost('quantity');

        if ($itemId <= 0) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' => 'Invalid item'
                ]);
        }

        if ($quantity < 1) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' => 'Quantity must be at least 1'
                ]);
        }

        $model = new CartProductModel();

        $item = $model
            ->where('id', $itemId)
            ->where('status', 1)
            ->first();

        if (!$item) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'message' => 'Item not found'
                ]);
        }

        $cart = session()->get('cart') ?? [];

        if (!isset($cart[$itemId])) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'message' => 'Item is not in cart'
                ]);
        }

        $cart[$itemId]['quantity'] = $quantity;

        // Important: refresh price from database.
        $cart[$itemId]['price'] = (float) $item['price'];
        $cart[$itemId]['name'] = $item['name'];

        session()->set('cart', $cart);

        $summary = $this->calculateSummary($cart);

        $itemTotal = $cart[$itemId]['price'] * $quantity;

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'item_id' => $itemId,
                'quantity' => $quantity,
                'item_total' => round($itemTotal, 2),
                'summary' => $summary
            ]
        ]);
    }
}