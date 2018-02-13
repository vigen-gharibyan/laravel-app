<?php

namespace App\Repositories;

use App\User;
use Infrastructure\Database\Eloquent\Repository;

class UserRepository
{
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $user = new User;

            $user->account_id = $data['account_id'];
            $user->fill($data);
            $user->save();

            $activation = new Activation;
            $activation->user_id = $user->id;
            $activation->save();
        } catch(Exception $e) {
            DB::rollBack();

            throw $e;
        }

        DB::commit();

        return $user;
    }
}