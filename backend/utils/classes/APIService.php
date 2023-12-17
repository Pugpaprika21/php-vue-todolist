<?php

class APIService
{
    /*** @var array */
    private $env;

    public function __construct($env)
    {
        $this->env = $env;
    }

    /**
     * Set allowed HTTP method.
     *
     * @param string $method - The allowed HTTP method (default is 'POST').
     */
    public function setMethodAllowed($method = 'POST')
    {
        if ($_SERVER['REQUEST_METHOD'] != strtoupper($method)) {
            header('HTTP/1.1 405 Method Not Allowed');
            echo $this->setResponseJSON(['msg' => '405 Method Not Allowed']);
            exit;
        }
    }

    /**
     * Check API key for authorization.
     *
     * @param string $key - The API key to check for authorization.
     */
    public function setUnauthorized($key = "")
    {
        if ($this->env['APP_API_KEY'] != $key) {
            header('HTTP/1.1 401 Unauthorized');
            echo $this->setResponseJSON(['msg' => '401 Unauthorized'], 401);
            exit;
        }
    }

    /**
     * Check API key for authorization.
     *
     * @param string $key - The API key to check for authorization.
     */
    public function setAuthorization()
    {
        $header = $this->getRequest()['headers'];

        if (empty($header['Authorization']) && strstr($header, $this->env['APP_API_KEY']) != $this->env['APP_API_KEY']) {
            header('HTTP/1.1 401 Unauthorized');
            echo $this->setResponseJSON(['msg' => 'Authorization header not found...']);
            exit;
        }
    }

    /**
     * Set JSON response.
     *
     * @param array $data - The data to be included in the response.
     * @param int $statusCode - The HTTP status code (default is 200).
     */
    public function setResponseJSON($arr, $statusCode = 200)
    {
        if (!empty($arr['status'])) {
            $statusCode = $arr['status'];
        }

        http_response_code($statusCode);
        return json_encode(arr_upr(['data' => $arr]), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Get and merge various types of requests.
     *
     * @return array - The merged array of different request types.
     */
    public function getRequest()
    {
        return array_merge([
            'Post' => $_POST,
            'Any' => $_REQUEST,
            'FormFile' => $_FILES,
            'QueryString' => $_GET,
            'Ajax' => json_decode(file_get_contents('php://input'), true),
            'headers' => getallheaders()
        ]);
    }
}
