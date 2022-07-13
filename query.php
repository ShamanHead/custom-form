<?php

class HubSpot {

    private string $key;

    function __construct($key) {
        $this->key = $key;
    }

    public function addContact($email, $firstName, $lastName) {
        $properties = [
            [
                "property" => "email",
                "value" => $email
            ],
            [
                "property" => "firstname",
                "value" => $firstName
            ],
            [
                "property" => "lastname",
                "value" => $lastName
            ]
        ];

        $properties = json_encode($properties);

        $endpoint = 'https://api.hubapi.com/contacts/v1/contact?hapikey=' . $this->key;
 
        $headers = [
                    [CURLOPT_POST, 1],
                    [CURLOPT_POSTFIELDS, $properties],
        ];
        return $this->query($endpoint, $headers);
    }

    protected function query(string $url, array $headers = []): string
    {
        $curlSession = curl_init();

        curl_setopt($curlSession, CURLOPT_URL, $url);
        for ($i = 0; $i < count($headers); $i++) {
            curl_setopt($curlSession, $headers[$i][0], $headers[$i][1]);
        }
        $returningData = curl_exec($curlSession); 
        curl_close($curlSession);

        return $returningData;
    }
}
