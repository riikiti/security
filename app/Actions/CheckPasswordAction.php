<?php

namespace App\Actions;

use GuzzleHttp\Client;

class CheckPasswordAction
{
    public Client $client;
    private string $url;

    public function __construct()
    {
        $this->client = new Client();
        $this->url = config('app.passwordApi');
    }

    public function checkPassword(string $password)
    {
        $hash = sha1($password);
        $first_hash = substr($hash, 0, 5);
        $check_hash = strtoupper(substr($hash, 5));
        $this->url = $this->url . $first_hash;
        $response = $this->client->get($this->url);
        $body = $response->getBody();
        $data = $body->getContents();
        $array = explode("\r\n", $data);

        $results = [];

        foreach ($array as $line) {
            $parts = explode(":", $line);
            $results[] = [
                'code' => $parts[0],
                'value' => intval($parts[1])
            ];
        }
        foreach ($results as $result) {
            if ($result['code'] == $check_hash) {
                return response()->json(['status' => 'find success', 'enters' => $result['value']]);
            }
        }

        return response()->json(['status' => 'didnt find', 'data' => []]);
    }
}
