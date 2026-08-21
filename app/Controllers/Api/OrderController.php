<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\PaymentModel;

class OrderController extends BaseController
{
    public function index()
{
    $orderModel = new OrderModel();
    $orderItemModel = new OrderItemModel();
    $paymentModel = new PaymentModel();

    // Pagination inputs
    $page = (int) ($this->request->getGet('page') ?? 1);
    $limit = (int) ($this->request->getGet('limit') ?? 10);

    // Validate page
    if ($page < 1) {
        $page = 1;
    }

    // Prevent very large requests
    if ($limit < 1) {
        $limit = 10;
    }

    if ($limit > 100) {
        $limit = 100;
    }

    $offset = ($page - 1) * $limit;

    // Total orders
    $total = $orderModel->countAll();

    // Get only requested orders
    $orders = $orderModel
        ->orderBy('id', 'ASC')
        ->findAll($limit, $offset);

    if (empty($orders)) {
        return $this->response->setJSON([
            'success' => true,
            'data' => [],
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'total_pages' => $total > 0
                    ? (int) ceil($total / $limit)
                    : 0
            ]
        ]);
    }

    $orderIds = array_column($orders, 'id');

    // Get all items for these orders in one query
    $items = $orderItemModel
        ->select('
            order_items.id,
            order_items.order_id,
            order_items.item_id,
            order_items.size,
            order_items.price,
            order_items.quantity,
            order_items.total,
            menu_items.name AS item_name
        ')
        ->join(
            'menu_items',
            'menu_items.id = order_items.item_id',
            'inner'
        )
        ->whereIn('order_items.order_id', $orderIds)
        ->orderBy('order_items.order_id', 'ASC')
        ->orderBy('order_items.id', 'ASC')
        ->findAll();

    // Get all payments for these orders in one query
    $payments = $paymentModel
        ->whereIn('order_id', $orderIds)
        ->orderBy('order_id', 'ASC')
        ->orderBy('id', 'ASC')
        ->findAll();

    // Group items
    $itemsByOrder = [];

    foreach ($items as $item) {

        $orderId = (int) $item['order_id'];

        $itemsByOrder[$orderId][] = [
            'item_id' => (int) $item['item_id'],
            'item_name' => $item['item_name'],
            'size' => $item['size'],
            'price' => (float) $item['price'],
            'quantity' => (int) $item['quantity'],
            'total' => (float) $item['total']
        ];
    }

    // Group payments
    $paymentsByOrder = [];

    foreach ($payments as $payment) {

        $orderId = (int) $payment['order_id'];

        $paymentsByOrder[$orderId][] = [
            'payment_id' => (int) $payment['payment_id'],
            'payment_date' => $payment['payment_date'],
            'amount_due' => (float) $payment['amount_due'],
            'tips' => (float) $payment['tips'],
            'discount' => (float) $payment['discount'],
            'total_paid' => (float) $payment['total_paid'],
            'payment_type' => $payment['payment_type'],
            'payment_status' => $payment['payment_status']
        ];
    }

    // Build final response
    $result = [];

    foreach ($orders as $order) {

        $orderId = (int) $order['id'];

        $result[] = [
            'order_id' => $orderId,
            'order_date' => $order['order_date'],
            'status' => $order['status'],
            'items' => $itemsByOrder[$orderId] ?? [],
            'payments' => $paymentsByOrder[$orderId] ?? []
        ];
    }

    return $this->response->setJSON([
        'success' => true,
        'data' => $result,
        'pagination' => [
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'total_pages' => (int) ceil($total / $limit)
        ]
    ]);
}
    public function show($id)
{
    if (!is_numeric($id) || (int) $id <= 0) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Invalid order ID'
            ]);
    }

    $orderId = (int) $id;

    $orderModel = new OrderModel();
    $orderItemModel = new OrderItemModel();
    $paymentModel = new PaymentModel();

    // Get order
    $order = $orderModel->find($orderId);

    if (!$order) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Order not found'
            ]);
    }

    // Get order items with item name
    $items = $orderItemModel
        ->select('
            order_items.item_id,
            order_items.size,
            order_items.price,
            order_items.quantity,
            order_items.total,
            menu_items.name AS item_name
        ')
        ->join(
            'menu_items',
            'menu_items.id = order_items.item_id',
            'inner'
        )
        ->where('order_items.order_id', $orderId)
        ->orderBy('order_items.id', 'ASC')
        ->findAll();

    $formattedItems = [];

    foreach ($items as $item) {
        $formattedItems[] = [
            'item_id' => (int) $item['item_id'],
            'item_name' => $item['item_name'],
            'size' => $item['size'],
            'price' => (float) $item['price'],
            'quantity' => (int) $item['quantity'],
            'total' => (float) $item['total']
        ];
    }

    // Get payments
    $payments = $paymentModel
        ->where('order_id', $orderId)
        ->orderBy('id', 'ASC')
        ->findAll();

    $formattedPayments = [];

    foreach ($payments as $payment) {
        $formattedPayments[] = [
            'payment_id' => (int) $payment['payment_id'],
            'payment_date' => $payment['payment_date'],
            'amount_due' => (float) $payment['amount_due'],
            'tips' => (float) $payment['tips'],
            'discount' => (float) $payment['discount'],
            'total_paid' => (float) $payment['total_paid'],
            'payment_type' => $payment['payment_type'],
            'payment_status' => $payment['payment_status']
        ];
    }

    return $this->response->setJSON([
        'success' => true,
        'data' => [
            'order_id' => (int) $order['id'],
            'order_date' => $order['order_date'],
            'status' => $order['status'],
            'items' => $formattedItems,
            'payments' => $formattedPayments
        ]
    ]);
}
}