<?php

return [

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes'   => [
        'name'        => 'Nom',
        'slug'        => 'Slug',
        'description' => 'Description',
        'locked'      => 'Verrouillé',
    ],

    /* -----------------------------------------------------------------
     |  Titles
     | -----------------------------------------------------------------
     */

    'titles'       => [
        'roles'        => 'Rôles',
        'roles-list'   => 'Liste des rôles',
        'create-role'  => 'Créer un rôle',
        'new-role'     => 'Nouveau rôle',
        'edit-role'    => 'Modifier un rôle',
        'update-role'  => 'Mettre à jour un rôle',
        'role-details' => "Fiche rôle",
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'list-empty'   => 'La liste des rôles est vide.',
    'has-no-users' => "Ce rôle n'a pas d'utilisateurs.",

    'messages'     => [
        'created'  => [
            'title'   => 'Rôle créé !',
            'message' => 'Le rôle [:name] a été créé avec succès !',
        ],

        'updated'  => [
            'title'   => 'Rôle modifié !',
            'message' => 'Le rôle [:name] a été modifié avec succès !',
        ],

        'enabled'  => [
            'title'   => 'Rôle activé !',
            'message' => 'Le rôle [:name] a été activé avec succès !',
        ],

        'disabled' => [
            'title'   => 'Rôle désactivé !',
            'message' => 'Le rôle [:name] a été désactivé avec succès !',
        ],

        'deleted'  => [
            'title'   => 'Rôle supprimé !',
            'message' => 'Le rôle [:name] a été supprimé avec succès !',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Modals
     | -----------------------------------------------------------------
     */

    'modals' => [
        'enable' => [
            'title'   => 'Activer le rôle',
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-success">activer</span> ce rôle: <b>:name</b> ?',
        ],

        'disable' => [
            'title'   => 'Désactiver le rôle',
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-inverse">désactiver</span> ce rôle: <b>:name</b> ?',
        ],

        'delete' => [
            'title'   => 'Supprimer le rôle',
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-danger">supprimer</span> ce rôle: <b>:name</b> ?',
        ],
    ],
];
