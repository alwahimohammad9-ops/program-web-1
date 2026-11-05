
<?php

class CategoriesController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();

        $this->view('categories/index', [
            'title' => 'Data Kategori',
            'categories' => $this->model('Category')->all(),
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();

        $this->view('categories/create', [
            'title' => 'Tambah Kategori',
            'category' => [],
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('categories');
        }

        $input = array_map('trim', $_POST);

        if (empty($input['name'])) {
            $this->flash('danger', 'Nama kategori wajib diisi.');
            $this->redirect('categories/create');
        }

        $this->model('Category')->create([
            'name' => $input['name'],
            'description' => $input['description'] ?? '',
        ]);

        $this->flash('success', 'Kategori berhasil ditambahkan.');
        $this->redirect('categories');
    }

    public function edit(int $id): void
    {
        $this->requireLogin();

        $category = $this->model('Category')->find($id);

        if (!$category) {
            $this->redirect('categories');
        }

        $this->view('categories/edit', [
            'title' => 'Edit Kategori',
            'category' => $category,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('categories');
        }

        $id = (int) ($_POST['id'] ?? 0);
        $input = array_map('trim', $_POST);

        if ($id <= 0 || empty($input['name'])) {
            $this->flash('danger', 'Data kategori tidak valid.');
            $this->redirect('categories');
        }

        $this->model('Category')->update($id, [
            'name' => $input['name'],
            'description' => $input['description'] ?? '',
        ]);

        $this->flash('success', 'Kategori berhasil diperbarui.');
        $this->redirect('categories');
    }

    public function delete(int $id): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('categories');
        }

        $this->model('Category')->delete($id);

        $this->flash('success', 'Kategori berhasil dihapus.');
        $this->redirect('categories');
    }
}
