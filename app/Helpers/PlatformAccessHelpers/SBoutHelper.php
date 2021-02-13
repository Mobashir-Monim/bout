<?php

namespace App\Helpers\PlatformAccessHelpers;

use App\Helpers\Helper;
use Carbon\Carbon;
use App\Models\Config;

class SBoutHelper extends Helper
{
    protected $mode;
    protected $credentials;
    
    public function __construct($mode, $request = null)
    {
        if ($mode == 'login') {
            $this->storeRequestCredentials($request);
        } else {
            $this->createCredentialArray();
        }
    }

    public function storeRequestCredentials($request)
    {
        $this->credentials = [
            'id' => $request->client_id,
            'hash' => $request->client_secret,
            'email' => $request->email,
        ];

        $this->renew = $request->renew;
    }

    public function createCredentialArray()
    {
        $config = Config::find('sbout')->configs;

        $this->credentials = [
            'id' => $config['credentials']['client_id'],
            'hash' => hash('sha512', $config['credentials']['client_secret']),
            'email' => $config['credentials']['user'],
            'renew' => Carbon::parse($config['credentials']['expires_at'])
        ];
    }
}