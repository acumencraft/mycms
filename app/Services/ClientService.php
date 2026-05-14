<?php
namespace App\Services;

use App\Models\Client;
use App\Models\User;

class ClientService
{
    public function getOrCreate(User $user): Client
    {
        return Client::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name'    => $user->name,
                'email'   => $user->email,
                'phone'   => null,
                'company' => null,
                'country' => null,
            ]
        );
    }
}
