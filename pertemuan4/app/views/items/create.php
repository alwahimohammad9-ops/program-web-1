
<?php
$title = 'Tambah Barang';

require ROOT_PATH . '/app/views/layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Tambah Barang</h3>
        <small class="text-muted">Tambahkan data barang inventaris</small>
    </div>

    <a href="<?= BASE_URL ?>/items" class="btn btn-outline-secondary">
        Kembali
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">

        <form action="<?= BASE_URL ?>/items/store" method="POST">

            <div class="mb-3">
                <label class="form-label">Kode Barang *</label>
                <input type="text" name="code" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Barang *</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-select">
                    <option value="">Pilih Kategori</option>

                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>">
                            <?= e($category['name']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah *</label>
                <input type="number" name="quantity" class="form-control" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Satuan *</label>
                <input type="text" name="unit" class="form-control" value="unit" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga *</label>
                <input type="number" name="price" class="form-control" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Masuk</label>
                <input type="date" name="entry_date" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan
            </button>

            <a href="<?= BASE_URL ?>/items" class="btn btn-secondary">
                Batal
            </a>

        </form>

    </div>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
