<?php

return [

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes' => [
        'expired' => 'Expiré',
    ],

    /* -----------------------------------------------------------------
     |  Titles
     | -----------------------------------------------------------------
     */

    'titles' => [
        'password-resets'      => 'Réinitialisation des MDPs',
        'password-resets-list' => 'Liste des réinitialisations de mot de passe',
    ],

    /* -----------------------------------------------------------------
     |  Actions
     | -----------------------------------------------------------------
     */

    'actions' => [
        'clear-expired' => 'Effacer les expirés',
        'delete-all'    => 'Supprimer tout',
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'list-empty'   => 'La liste de réinitialisation du mot de passe est vide.',

    'messages' => [
        'cleared' => [
            'title'   => 'Les réinitialisations du mot de passe sont effacées !',
            'message' => 'Toutes les réinitialisations du mot de passe expirées ont été effacées avec succès !',
        ],

        'deleted' => [
            'title'   => 'Les réinitialisations du mot de passe sont supprimées !',
            'message' => 'Toutes les réinitialisations de mot de passe ont été supprimées avec succès !',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Modals
     | -----------------------------------------------------------------
     */

    'modals' => [
        'clear' => [
            'title'   => 'Effacer toutes les réinitialisations du mot de passe expirées',
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-warning">effacer</span> toutes les réinitialisations du mot de passe expirées ?',
        ],

        'delete' => [
            'title'   => 'Supprimer toutes les réinitialisations de mot de passe',
            'message' => 'Êtes-vous sûr de vouloir <span class="label label-danger">supprimer</span> toutes les réinitialisations de mot de passe ?',
        ],
    ],

];
