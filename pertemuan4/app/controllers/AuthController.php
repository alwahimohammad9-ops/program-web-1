
<?php

class AuthController extends Controller
{
    public function login()
    {
        // Jika sudah login, arahkan ke dashboard
        if (isset($_SESSION['user'])) {
            $this->redirect('');
        }

        // Proses login
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $db = Database::getInstance()->getConnection();

            $stmt = $db->prepare(
                "SELECT * FROM users WHERE username = ? LIMIT 1"
            );

            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {

                session_regenerate_id(true);

                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role']
                ];

                $this->redirect('');
            }

            $error = 'Username atau password salah.';

            $this->view('auth/login', [
                'error' => $error
            ]);

            return;
        }

        $this->view('auth/login');
    }

    public function logout()
    {
        $_SESSION = [];

        session_destroy();

        $this->redirect('auth/login');
    }
}
