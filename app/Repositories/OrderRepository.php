<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function findById(int $id): ?Order
    {
        return Order::with(['client', 'services', 'features'])->find($id);
    }

    public function getAll(): Collection
    {
        return Order::with(['client', 'services', 'features'])->orderBy('created_at', 'desc')->get();
    }

    public function getByClient(int $clientId): Collection
    {
        return Order::where('client_id', $clientId)
            ->with(['services', 'features'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function updateStatus(int $id, string $status): bool
    {
        return Order::where('id', $id)->update(['status' => $status]);
    }

    public function attachServices(Order $order, array $serviceIds): void
    {
        $order->services()->attach($serviceIds);
    }

    public function attachFeatures(Order $order, array $featureIds): void
    {
        $order->features()->attach($featureIds);
    }
}