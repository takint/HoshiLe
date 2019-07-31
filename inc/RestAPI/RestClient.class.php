<?php

// https://stackoverflow.com/questions/6213509/send-json-post-using-php

class RestClient {
    public static function call($method, $url, $json = null) {
        $options = array(
            'http' => array(
                'method' => $method,
                'content' => is_null($json) ? '' : json_encode($json),
                'header' => "Content-Type: application/json\r\n" .
                            "Accept: application/json\r\n"
            )
        );
        $content = stream_context_create($options);
        $result = file_get_contents($url, false, $content);
        return json_decode($result);
    }
}

?>