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
    'remove_in' => 30, //days

    /**
     * Models that will take effect
     * 
     * Use ['*'] to set all models
     */
    'only' => [
        'App\Models\User',
    ],

    /**
     * Enable the log
     * 
     * You can create another filesytems disks
     * and set it in the storage key
     */
    'log' => true,
    'storage' => 'local'

];