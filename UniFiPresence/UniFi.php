<?php

class UniFi
{
    private $url;
    private $username;
    private $password;

    public function __construct($url, $username, $password)
    {
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
    }

    public function isClientActive($mac)
    {
        $client_list = $this->getActiveClientList();
        if ($client_list == null) {
            return false;
        }
        foreach ($client_list->data as $client) {
            if ($mac == $client->mac) {
                return true;
            }
        }
        return false;
    }

    private function getActiveClientList()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/unifi_cookie');
        curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/unifi_cookie');
        curl_setopt($ch, CURLOPT_SSLVERSION, 1); //set TLSv1 (SSLv3 is no longer supported)

        # authenticate against unifi controller
        curl_setopt($ch, CURLOPT_URL, $this->url . '/api/login');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
                'username' => $this->username, 'password' => $this->password
            )) . ':');
        curl_exec($ch);

        # client stats
        curl_setopt($ch, CURLOPT_URL, $this->url . '/api/s/default/stat/sta');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'json={}');
        $response = curl_exec($ch);

        # logout
        curl_setopt($ch, CURLOPT_URL, $this->url . '/logout');
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, NULL);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_exec($ch);

        curl_close($ch);
        unset($ch);

        if ($response !== false) {
            return json_decode($response);
        }
        return null;
    }
}
