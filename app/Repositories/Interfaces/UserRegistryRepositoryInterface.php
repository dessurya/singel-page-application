<?php

namespace App\Repositories\Interfaces;

interface UserRegistryRepositoryInterface {
    public function signup($data);
    public function findById($data);
}