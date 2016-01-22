<?php

return [

  /**
   * Should we send errors to Airbrake
   */
  'enabled'             => true,

  /**
   * Airbrake API key
   */
  'api_key'             => '6e24fe7e9906ef1d07138da38487bc64',

  /**
   * Should we send errors async
   */
  'async'               => false,

  /**
   * Which enviroments should be ingored? (ex. local)
   */
  'ignore_environments' => ['local', 'testing', 'development'],

  /**
   * Ignore these exceptions
   */
  'ignore_exceptions'   => [],

  /**
   * Connection to the airbrake server
   */
  'connection'          => [

    'host'      => 'helio-errbit.herokuapp.com',

    'port'      => '443',

    'secure'    => true,

    'verifySSL' => true
  ]

];
