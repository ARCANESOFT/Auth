<?php

return [

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */
    'email'                 => 'Email address',
    'username'              => 'Username',
    'password'              => 'Password',
    'password_confirmation' => 'Password Confirmation',
    'first_name'            => 'First Name',
    'last_name'             => 'Last Name',

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */
    'since'       => 'Member since :date',
    'no-activity' => 'No activity yet',

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
    ],

];
