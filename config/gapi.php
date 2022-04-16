<?php

return [
    'cred' => [
        "type" => env("GOOGLE_ACCOUNT_TYPE"),
        "project_id" => env("GOOGLE_PROJECT_ID"),
        "private_key_id" => env("GOOGLE_PRIVATE_KEY_ID"),
        "private_key" => env("GOOGLE_PRIVATE_KEY"),
        "client_email" => env("GOOGLE_ACCOUNT_MAIL"),
        "client_id" => env("GOOGLE_ACCOUNT_CLIENT_ID"),
        "auth_uri" => env("GOOGLE_AUTH_URI"),
        "token_uri" => env("GOOGLE_TOKEN_URI"),
        "auth_provider_x509_cert_url" => env("GOOGLE_AUTH_CERTS_URL"),
        "client_x509_cert_url" => env("GOOGLE_CERTS_URL"),
    ]
];