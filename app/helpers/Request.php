<?php

namespace Book\Shop\Helpers;

class Request
{
    protected static $instance = null;

    public $requestMethod = '';
    public $params = [];
    protected $input = [];

    public function __construct()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $this->requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
            $input = $this->getInput();
            $this->input = [];

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

    public function getInput(): string
    {
        return (string)file_get_contents('php://input');
    }
}
