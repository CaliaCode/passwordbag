<?php

namespace App\Repositories;

// Framework
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Client;

class ClientRepository
{

    /**
     * @var Client
     */
    private $client;

    /**
     * ClientRepository constructor.
     * 
     * @param Client $client
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * Save the Client
     * 
     * @param array $data
     * @return Client $client
     */
    public function create(array $data) {

        $currentUser = Auth::user();

        return $currentUser->clients()->create($data);

    }

}