<?php

return [

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes' => [
        'email'                 => 'Email address',
        'username'              => 'Username',
        'password'              => 'Password',
        'password_confirmation' => 'Password Confirmation',
        'first_name'            => 'First Name',
        'last_name'             => 'Last Name',
        'full_name'             => 'Full Name',
        'last_activity'         => 'Last activity',
    ],

    /* -----------------------------------------------------------------
     |  Titles
     | -----------------------------------------------------------------
     */

    'titles' => [
        'users'        => 'Users',
        'users-list'   => 'List of users',
        'create-user'  => 'Create a user',
        'new-user'     => 'New User',
        'edit-user'    => 'Edit a user',
        'update-user'  => 'Update a user',
        'user-details' => 'User details',
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'since'        => 'Member since :date',
    'no-activity'  => 'No activity yet',
    'list-empty'   => 'The list of users is empty.',
    'has-no-roles' => 'This user has no roles.',

    'messages' => [
        'created'  => [
            'title'   => 'User created !',
            'message' => 'The user [:name] was created successfully !',
        ],

        'updated'  => [
            'title'   => 'User Updated !',
            'message' => 'The user [:name] was updated successfully !',
        ],

        'enabled' => [
            'title'   => 'User activated !',
            'message' => 'The user [:name] has been successfully activated !',
        ],

        'disabled' => [
            'title'   => 'User disabled !',
            'message' => 'The user [:name] has been successfully disabled !',
        ],

        'trashed' => [
            'title'   => 'User deleted !',
            'message' => 'The user [:name] was moved to the trash list !',
        ],

        'deleted' => [
            'title'   => 'User deleted !',
            'message' => 'The user [:name] has been successfully deleted !',
        ],

        'restored' => [
            'title'   => 'User restored !',
            'message' => 'The user [:name] has been successfully restored !',
        ],

        'impersonation-failed' => [
            'title'   => 'Impersonation failed !',
            'message' => 'The impersonation is disabled for this user !',
        ],
    ],

];
