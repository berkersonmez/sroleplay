<?php

/**
 * Creates list of messages and returns as JSON.
 * Also decodes JSON with Javascript and creates HTML messages.
 */
class C_Ajax {
    private $messageList = array();

    public function addMessage($message) {
        $this->messageList[] = $message;
    }

    private function responseTypeToInt($type) {
        if ($type == "error") {
            $type = -1;
        } else if ($type == "success") {
            $type = 1;
        } else if ($type == "warning") {
            $type = 2;
        }
        return $type;
    }

    private function constructJSON($type, $response) {
        return json_encode(array($type => $response));
    }

    private function responseJSON($type, $response)
    {
        //header('Content-type: application/json');
        echo $this->constructJSON($this->responseTypeToInt($type), $response);
    }

    public function printResponse($type) {
        $this->responseJSON($type, $this->messageList);
    }

    public static function jsFormResponseParser() {
        ?>
        var ajaxSuccess = false;
        function ajaxResponse(data) {
            var content = "";
            $.each(data, function(key, val) {
                if (key == -1) {
                    content += '<div class="alert alert-error"><ul>';
                } else if (key == 1) {
                    ajaxSuccess = true;
                    content += '<div class="alert alert-success"><ul>';
                } else if (key == 2) {
                    content += '<div class="alert"><ul>';
                }
                $.each(val, function(key2, val2) {
                    content+= '<li>'+val2+'</li>';
                });
                content+='</ul></div>'
            });
            return content;
        }
    <?
    }

}