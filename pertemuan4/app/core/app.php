
<?php

class App
{
    protected string $controller = 'HomeController';
    protected string $method = 'index';
    protected array $params = [];

    public function __construct()
    {
        $url = $this->parseURL();

        // Tentukan controller berdasarkan URL
        if (!empty($url[0])) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }

        // Tentukan lokasi file controller
        $controllerFile = ROOT_PATH . '/app/controllers/'
            . $this->controller . '.php';

        // Periksa apakah file controller tersedia
        if (!file_exists($controllerFile)) {
            $this->notFound();
            return;
        }

        // Muat file controller
        require_once $controllerFile;

        // Pastikan class controller tersedia
        if (!class_exists($this->controller)) {
            $this->notFound();
            return;
        }

        // Buat objek controller
        $controllerClass = $this->controller;
        $this->controller = $controllerClass;

        $controllerObject = new $controllerClass();

        // Tentukan method berdasarkan URL
        if (!empty($url[1])) {
            if (!method_exists($controllerObject, $url[1])) {
                $this->notFound();
                return;
            }

            $this->method = $url[1];
            unset($url[1]);
        }

        // Ambil parameter URL
        $this->params = $url
            ? array_values($url)
            : [];

        // Jalankan controller dan method
        call_user_func_array(
            [$controllerObject, $this->method],
            $this->params
        );
    }

    public function parseURL(): array
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');

            return explode(
                '/',
                filter_var($url, FILTER_SANITIZE_URL)
            );
        }

        return [];
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo '<h1>404 Not Found</h1>';
    }
}
