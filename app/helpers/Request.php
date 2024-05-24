<?php

namespace Book\Shop\Helpers;

class Request
{
    protected static $instance = null;

    public string $requestMethod = '';
    public array $params = [];
    protected array $input = [];

    public function __construct()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $this->requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
            $input = $this->getInput();
            $this->input = [];

            // Parse the input data into an associative array
            if (function_exists('mb_parse_str')) {
                mb_parse_str($input, $this->input);
            } else {
                parse_str($input, $this->input);
            }
        }
    }

    public function getFile(string $fileIndex, $tempFolder = '/tmp'): ?string
    {
        $files = $_FILES ?: [];
        $file = $files[$fileIndex] ?? null;
        if ($file === null) {
            return null;
        }
        $result = $tempFolder . '/' . $file['name'];
        if (\copy($file['tmp_name'], $result)) {
            return $result;
        }
        return null;
    }

    public function get(?string $key = null)
    {
        if (null === $key && $this->isGet()) {
            return $_GET;
        }
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    public function post(?string $key = null)
    {
        if (null === $key && $this->isPost()) {
            return $_POST;
        }
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    /**
     * Checks if the request method is GET.
     */
    public function isGet(): bool
    {
        if (is_array($_GET) && !empty($_GET)) {
            return true;
        }
        return false;
    }

    /**
     * Checks if the request method is POST.
     */
    public function isPost(): bool
    {
        if (is_array($_POST) && !empty($_POST)) {
            return true;
        }
        return false;
    }

    /**
     * Retrieves the input data received in the request.
     */
    public function getInput(): string
    {
        return (string)file_get_contents('php://input');
    }
}
