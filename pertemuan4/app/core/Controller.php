
<?php

class Controller {

    public function view(string $view, array $data = []): void {
        extract($data);
        require ROOT_PATH . '/app/views/' . $view . '.php';
    }

    public function model(string $model) {
        return new $model();
    }

    public function redirect(string $path): void {
        header('Location: ' . BASE_URL . '/' . ltrim($path, '/'));
        exit;
    }

    public function flash(string $type, string $message): void {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    // Proteksi halaman yang membutuhkan login
    public function requireLogin(): void {

        if (!isset($_SESSION['user'])) {

            $this->flash(
                'error',
                'Silakan login terlebih dahulu untuk mengakses halaman ini.'
            );

            $this->redirect('auth/login');
        }
    }

}
