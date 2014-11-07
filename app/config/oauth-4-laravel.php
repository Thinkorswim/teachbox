<?php
return array( 

    /*
    |--------------------------------------------------------------------------
    | oAuth Config
    |--------------------------------------------------------------------------
    */

    /**
     * Storage
     */
    'storage' => 'Session', 

    /**
     * Consumers
     */
    'consumers' => array(

        /**
         * Facebook
         */
        'Facebook' => array(
            'client_id'     => '324304421082355',
            'client_secret' => 'e7e24698177a6aa88f771a795a0fa48b',
            'scope'         => array('email'),
        ),      

    )

);