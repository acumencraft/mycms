<?php
namespace App\Services;

use App\Models\Client;
use App\Models\Feature;
use App\Models\Order;
use App\Models\Service;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    public function createOrder(array $data, ?int $clientId = null): Order
    {
        return DB::transaction(function () use ($data, $clientId) {
            if ($clientId) {
                $client = Client::find($clientId);
                if ($client) {
                    $data['client_id'] = $clientId;
                    $data['client_name'] = $client->name;
                    $data['email'] = $client->email;
                    $data['phone'] = $client->phone;
                }
            }

            $data['price_estimate'] = $this->calculateTotalPrice($data);

            $order = $this->orderRepository->create($data);

            if (!empty($data['services'])) {
                $this->orderRepository->attachServices($order, $data['services']);
            }

            if (!empty($data['features'])) {
                $this->orderRepository->attachFeatures($order, $data['features']);
            }

            return $order;
        });
    }

    public function updateOrderStatus(int $orderId, string $status): bool
    {
        return $this->orderRepository->updateStatus($orderId, $status);
    }

    public function getOrderById(int $id): ?Order
    {
        return $this->orderRepository->findById($id);
    }

    public function getAllOrders(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->orderRepository->getAll();
    }

    public function getOrdersByClient(int $clientId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->orderRepository->getByClient($clientId);
    }

    private function calculateTotalPrice(array $data): float
    {
        $serviceIds = $data['services'] ?? [];
        $featureIds = $data['features'] ?? [];

        // იყო: 2 ცალკე query — ახლა: 1 query sum()-ით თითოეულზე
        $serviceTotal = Service::whereIn('id', $serviceIds)->sum('base_price');
        $featureTotal = Feature::whereIn('id', $featureIds)->sum('price');

        return (float) ($serviceTotal + $featureTotal);
    }

    public function getAvailableServices()
    {
        return Service::where('status', true)->get();
    }

    public function getAvailableFeatures()
    {
        return Feature::all();
    }
}
