<?php

/*
 * You can place your custom package configuration in here.
 */
return [

    /**
     * Removes in day
     * 
     * for tables that has soft deletes
     */
    'remove_in' => 1, //days

    /**
     * Models that will take effect
     * 
     * Use ['*'] to set all models
     */
    'only' => [
        'App\Models\User',
        'App\Models\Client'
    ],

];