
<?php

class ItemsController extends Controller
{
    // Menampilkan daftar barang
    public function index(): void
    {
        $this->requireLogin();

        $this->view('items/index', [
            'title' => 'Data Barang',
            'items' => $this->model('Item')->all(),
            'categories' => $this->model('Category')->all(),
        ]);
    }

    // Menampilkan form tambah barang
    public function create(): void
    {
        $this->requireLogin();

        $this->view('items/create', [
            'title' => 'Tambah Barang',
            'item' => [],
            'categories' => $this->model('Category')->all(),
        ]);
    }

    // Menyimpan barang baru
    public function store(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('items');
        }

        $input = array_map('trim', $_POST);
        $itemModel = $this->model('Item');

        if (
            empty($input['code']) ||
            empty($input['name']) ||
            empty($input['quantity']) ||
            empty($input['unit']) ||
            empty($input['price'])
        ) {
            $this->flash('danger', 'Data barang wajib diisi.');
            $this->redirect('items/create');
        }

        // Validasi kode barang duplikat
        if ($itemModel->codeExists($input['code'])) {
            $this->flash('danger', 'Kode barang sudah digunakan. Gunakan kode lain.');
            $this->redirect('items/create');
        }

        $itemModel->create([
            'code' => $input['code'],
            'name' => $input['name'],
            'category_id' => !empty($input['category_id']) ? $input['category_id'] : null,
            'quantity' => $input['quantity'],
            'unit' => $input['unit'],
            'price' => $input['price'],
            'entry_date' => !empty($input['entry_date']) ? $input['entry_date'] : null,
            'description' => $input['description'] ?? '',
        ]);

        $this->flash('success', 'Barang berhasil ditambahkan.');
        $this->redirect('items');
    }

    // Menampilkan halaman edit
    public function edit(int $id): void
    {
        $this->requireLogin();

        $item = $this->model('Item')->find($id);

        if (!$item) {
            $this->redirect('items');
        }

        $this->view('items/edit', [
            'title' => 'Edit Barang',
            'item' => $item,
            'categories' => $this->model('Category')->all(),
        ]);
    }

    // Memperbarui barang
    public function update(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('items');
        }

        $id = (int) ($_POST['id'] ?? 0);
        $input = array_map('trim', $_POST);
        $itemModel = $this->model('Item');

        if (
            $id <= 0 ||
            empty($input['code']) ||
            empty($input['name'])
        ) {
            $this->flash('danger', 'Data barang tidak valid.');
            $this->redirect('items');
        }

        // Validasi kode duplikat saat edit
        if ($itemModel->codeExists($input['code'], $id)) {
            $this->flash('danger', 'Kode barang sudah digunakan oleh barang lain.');
            $this->redirect('items/edit/' . $id);
        }

        $itemModel->update($id, [
            'code' => $input['code'],
            'name' => $input['name'],
            'category_id' => !empty($input['category_id']) ? $input['category_id'] : null,
            'quantity' => $input['quantity'],
            'unit' => $input['unit'],
            'price' => $input['price'],
            'entry_date' => !empty($input['entry_date']) ? $input['entry_date'] : null,
            'description' => $input['description'] ?? '',
        ]);

        $this->flash('success', 'Barang berhasil diperbarui.');
        $this->redirect('items');
    }

    // Menghapus barang
    public function delete(int $id): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('items');
        }

        $this->model('Item')->delete($id);

        $this->flash('success', 'Barang berhasil dihapus.');
        $this->redirect('items');
    }
}
