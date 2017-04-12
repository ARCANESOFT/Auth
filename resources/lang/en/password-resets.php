<?php

return [

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes' => [
        'expired' => 'Expired',
    ],

    /* -----------------------------------------------------------------
     |  Titles
     | -----------------------------------------------------------------
     */

    'titles' => [
        'password-resets'      => 'Password Resets',
        'password-resets-list' => 'List of password resets',
    ],

    /* -----------------------------------------------------------------
     |  Actions
     | -----------------------------------------------------------------
     */

    'actions' => [
        'clear-expired' => 'Clear expired',
        'delete-all'    => 'Delete all'
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'list-empty'   => 'The password resets list is empty.',

    'messages' => [
        'cleared' => [
            'title'   => 'Password resets cleared !',
            'message' => 'All the expired password resets was successfully cleared !',
        ],

        'deleted' => [
            'title'   => 'Password resets cleared !',
            'message' => 'All the password resets was successfully deleted !',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Modals
     | -----------------------------------------------------------------
     */

    'modals' => [
        'clear' => [
            'title'   => 'Clear all expired password resets',
            'message' => 'Are you sure to <span class="label label-warning">clear</span> all the expired password resets ?',
        ],

        'delete' => [
            'title'   => 'Delete all password resets',
            'message' => 'Are you sure to <span class="label label-danger">delete</span> all password resets ?',
        ],
    ],
];
