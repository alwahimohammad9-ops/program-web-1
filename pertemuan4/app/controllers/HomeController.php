
<?php

class HomeController extends Controller
{
    public function index()
    {
        // Wajib login sebelum mengakses dashboard
        $this->requireLogin();

        $db = Database::getInstance()->getConnection();

        $items = $db->query("SELECT * FROM items ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

        $this->view('home/index', [
            'items' => $items
        ]);
    }
}
