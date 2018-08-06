<?php

namespace App\Services;

// Framework
use Illuminate\Support\Facades\Storage;

// Repositories
use App\Repositories\ClientRepository;

class ClientService{

    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * ClientService constructor.
     * 
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository){

        $this->clientRepository = $clientRepository;

    }

    /**
     * Create Client
     * 
     * @param array $data
     * @return bool
     */
    public function createClient(array $data){

        $this->clientRepository->create($data);

        return true;

    }

}