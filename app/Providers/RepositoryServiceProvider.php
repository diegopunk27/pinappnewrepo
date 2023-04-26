<?php

namespace App\Providers;

use App\Interfaces\ClientRepositoryInterface;
use App\Repositories\ClientRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    public function register() {

        $this->app->bind(
            ClientRepositoryInterface::class,
            ClientRepository::class
        );
    }

}
