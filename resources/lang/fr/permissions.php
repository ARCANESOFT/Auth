<?php

return [
    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes'   => [
        'group'       => 'Groupe',
        'name'        => 'Nom',
        'slug'        => 'Slug',
        'description' => 'Description',
    ],

    /* -----------------------------------------------------------------
     |  Titles
     | -----------------------------------------------------------------
     */

    'titles'       => [
        'permissions'        => 'Permissions',
        'permissions-list'   => 'Liste des permissions',
        'permission-details' => 'Fiche permission',
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'list-empty'   => 'La liste des permissions est vide.',
    'has-no-group' => 'Cette permission n\'appartient à aucun groupe des permissions.',

    'messages'     => [
        'detached' => [
            'title'   => 'Rôle détaché !',
            'message' => 'Le rôle [:role] a été détaché avec succès de [:permission] !',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Modals
     | -----------------------------------------------------------------
     */

    'modals'       => [
        'detach' => [
            'title'   => 'Détacher le rôle',
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-danger">détacher</span> ce rôle: <b>:name</b>?',
        ],
    ],
];
