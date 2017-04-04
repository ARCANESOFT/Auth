<?php

return [

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */
    'email'                 => 'Email',
    'username'              => 'Nom d\'utilisateur',
    'password'              => 'Mot de passe',
    'password_confirmation' => 'Confirmation mot de passe',
    'first_name'            => 'Prénom',
    'last_name'             => 'Nom',

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'since'       => 'Membre depuis :date',
    'no-activity' => 'Aucune activité en ce moment',

    'messages' => [
        'created'  => [
            'title'   => 'Utilisateur créé !',
            'message' => "L'utilisateur [:name] a été créé avec succès !",
        ],

        'updated'  => [
            'title'   => "L'utilisateur a été mis à jour !",
            'message' => "L'utilisateur [:name] a été mis à jour avec succès !",
        ],

        'enabled' => [
            'title'   => 'Utilisateur activé !',
            'message' => "L'utilisateur [:name] a été activé avec succès !",
        ],

        'disabled' => [
            'title'   => 'Utilisateur désactivé !',
            'message' => "L'utilisateur [:name] a été désactivé avec succès !",
        ],

        'trashed' => [
            'title'   => 'Utilisateur supprimé !',
            'message' => "L'utilisateur [:name] a été déplacé vers la liste de la corbeille !",
        ],

        'deleted' => [
            'title'   => 'Utilisateur supprimé !',
            'message' => "L'utilisateur [:name] a été supprimé avec succès !",
        ],

        'restored' => [
            'title'   => "L'utilisateur a été restauré !",
            'message' => "L'utilisateur [:name] a été restauré avec succès !",
        ],
    ],
];
