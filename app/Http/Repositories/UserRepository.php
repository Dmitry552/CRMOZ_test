<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return User::query()->firstOrCreate(['email' => $data['email']], $data);
    }

    /**
     * @param string $email
     * @return Model
     */
    public function getUserForEmail(string $email): Model
    {
        return User::query()->where('email', $email)->firstOrFail();
    }
}
