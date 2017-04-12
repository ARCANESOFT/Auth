<?php

return [

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes' => [
        'email'                 => 'Email',
        'username'              => "Nom d'utilisateur",
        'password'              => 'Mot de passe',
        'password_confirmation' => 'Confirmation mot de passe',
        'first_name'            => 'Prénom',
        'last_name'             => 'Nom',
        'full_name'             => 'Nom complet',
        'last_activity'         => 'Dernière Activité',
    ],

    /* -----------------------------------------------------------------
     |  Titles
     | -----------------------------------------------------------------
     */

    'titles' => [
        'users'        => 'Utilisateurs',
        'users-list'   => 'Liste des utilisateurs',
        'create-user'  => 'Créer un utilisateur',
        'new-user'     => 'Nouvel utilisateur',
        'edit-user'    => 'Modifier un utilisateur',
        'update-user'  => 'Mettre à jour un utilisateur',
        'user-details' => "Fiche de l'utilisateur",
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'since'        => 'Membre depuis :date',
    'no-activity'  => 'Aucune activité en ce moment',
    'list-empty'   => 'La liste des utilisateurs est vide.',
    'has-no-roles' => "Cet utilisateur n'a aucun rôle.",

    'messages' => [
        'created'  => [
            'title'   => 'Utilisateur créé !',
            'message' => "L'utilisateur [:name] a été créé avec succès !",
        ],

        'updated'  => [
            'title'   => 'Utilisateur modifié !',
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
            'title'   => 'Utilisateur a été restauré !',
            'message' => "L'utilisateur [:name] a été restauré avec succès !",
        ],

        'impersonation-failed' => [
            'title'   => "L'emprunt d'identité a échoué !",
            'message' => "L'emprunt d'identité est désactivé pour cet utilisateur !",
        ],
    ],

    /* -----------------------------------------------------------------
     |  Modals
     | -----------------------------------------------------------------
     */

    'modals' => [
        'enable' => [
            'title'   => "Activer l'utilisateur",
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-success">activer</span> cet utilisateur: <b>:name</b> ?',
        ],

        'disable' => [
            'title'   => "Désactiver l'utilisateur",
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-inverse">désactiver</span> cet utilisateur: <b>:name</b> ?',
        ],

        'delete' => [
            'title'   => "Supprimer l'utilisateur",
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-danger">supprimer</span> cet utilisateur: <b>:name</b> ?',
        ],

        'restore' => [
            'title'   => "Restaurer l'utilisateur",
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-primary">restaurer</span> cet utilisateur: <b>:name</b> ?',
        ],
    ],
];
