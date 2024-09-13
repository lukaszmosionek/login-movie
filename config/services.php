<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'jwt_secret' => env('JWT_SECRET', 'f9ea3f4c3dae14785cd54fa5b1c9bdbe30dc5c1132d855c601c3cdcf7a188cd3b804ef130a7f48e89d0760830a9919bcb93193f3b93509d0df1a14de92042d3b09d471b9c866df4cc44f7b0f96d715ac7a8c5b45c06e46fd2d55e726fbd3fddf65ee452c5d07fc42a08c881b579a6601120aaa52d277963aba3e97d721ca7ff7e3ec8a1ed945f1dc9efe20dbd3ee6ac675e91da026cdf64ac605585a3e879f0d34ce82513b942be4ea34b094743f42e72d710466ddfec8b0da5280cd74f848fbd73f66fc193c293e687995402fea574384106fb0e8cf82c45d0e64f99efac71065d69280b04142a3952c6268f77c5847aaa67ee90b02c486e41fe4231af7ad1f')

];
