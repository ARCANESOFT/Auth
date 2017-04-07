<?php

return [
    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes'   => [
        'group'       => 'Group',
        'name'        => 'Name',
        'slug'        => 'Slug',
        'description' => 'Description',
    ],

    /* -----------------------------------------------------------------
     |  Titles
     | -----------------------------------------------------------------
     */

    'titles'       => [
        'permissions'        => 'Permissions',
        'permissions-list'   => 'List of permissions',
        'permission-details' => 'Permission Details',
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'list-empty'   => 'The list of permissions is empty.',
    'has-no-group' => 'This permission isn\'t belonging to any group of permissions.',

    'messages'     => [
        'detached' => [
            'title'   => 'Role detached !',
            'message' => 'The role [:role] has been successfully detached from [:permission] !',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Modals
     | -----------------------------------------------------------------
     */

    'modals'       => [
        'detach' => [
            'title'   => 'Detach Role',
            'message' => 'Are you sure you want to <span class="label label-danger">detach</span> this role : <b>:name</b> ?',
        ],
    ],
];
