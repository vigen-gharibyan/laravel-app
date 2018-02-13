<?php

namespace App\Services;

use App\Exceptions\EmailIsNotUniqueException;
use App\Events\UserWasCreated;
//use App\Helpers\UserValidator;
use App\Repositories\UserRepository;
use Infrastructure\Auth\Authentication;
use Illuminate\Events\Dispatcher;

class UserService
{
    private $auth;

    private $dispatcher;

    private $userRepository;

    private $userValidator;

    public function __construct(
        Authentication $auth,
        Dispatcher $dispatcher,
        UserRepository $userRepository/*,
        UserValidator $userValidator*/
    ) {
        $this->auth = $auth;
        $this->dispatcher = $dispatcher;
        $this->userRepository = $userRepository;
    //    $this->userValidator = $userValidator;
    }

    public function create(array $data)
    {
        $account = $this->auth->getCurrentUser();

        // Check if the user has permission to create other users.
        // Will throw an exception if not.
        $account->checkPermission('users.create');

        // Use our validation helper to check if the given email
        // is unique within the account.
        /*
        if (!$this->userValidator->isEmailUniqueWithinAccount($data['email'], $account->id)) {
            throw new EmailIsNotUniqueException($data['email']);
        }
        */

        // Set the account ID on the user and create the record in the database
        $data['account_id'] = $account->id;
        $user = $this->userRepository->create($data);

        // If we set the relation right away on the user model, then we can
        // call $user->account without quering the database. This is useful if
        // we need to call $user->account in any of the event listeners
        $user->setRelation('account', $account);

        // Fire an event so that listeners can react
        $this->dispatcher->fire(new UserWasCreated($user));

        return $user;
    }
}