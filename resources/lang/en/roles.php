<?php

return [

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes' => [
        'name'        => 'Name',
        'slug'        => 'Slug',
        'description' => 'Description',
        'locked'      => 'Locked',
    ],

    /* -----------------------------------------------------------------
     |  Titles
     | -----------------------------------------------------------------
     */

    'titles' => [
        'roles'        => 'Roles',
        'roles-list'   => 'List of roles',
        'create-role'  => 'Create a role',
        'new-role'     => 'New Role',
        'edit-role'    => 'Edit a Role',
        'update-role'  => 'Update Role',
        'role-details' => 'Role Details',
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'list-empty'         => 'The list of roles is empty.',
    'has-no-users'       => 'This role has no users.',
    'has-no-permissions' => 'This role has no permissions.',

    'messages'           => [
        'created'  => [
            'title'   => 'Role Created !',
            'message' => 'The Role [:name] was successfully created !',
        ],

        'updated'  => [
            'title'   => 'Role Updated !',
            'message' => 'The Role [:name] was successfully updated !',
        ],

        'enabled'  => [
            'title'   => 'Role Activated !',
            'message' => 'The Role [:name] has been successfully activated !',
        ],

        'disabled' => [
            'title'   => 'Role Disabled !',
            'message' => 'The role [:name] has been successfully disabled !',
        ],

        'deleted'  => [
            'title'   => 'Role Deleted !',
            'message' => 'The role [:name] has been successfully deleted !',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Modals
     | -----------------------------------------------------------------
     */

    'modals' => [
        'enable' => [
            'title'   => 'Activate Role',
            'message' => 'Are you sure you want to <span class="label label-success">activate</span> this role: <b>:name</b> ?',
        ],

        'disable' => [
            'title'   => 'Disable Role',
            'message' => 'Are you sure you want to <span class="label label-inverse">disable</span> this role: <b>:name</b> ?',
        ],

        'delete' => [
            'title'   => 'Delete Role',
            'message' => 'Are you sure you want to <span class="label label-danger">delete</span> this role: <b>:name</b> ?',
        ],
    ],
];
