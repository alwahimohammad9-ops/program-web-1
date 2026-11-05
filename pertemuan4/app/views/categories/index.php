
<?php
$title = 'Data Kategori';

require ROOT_PATH . '/app/views/layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Data Kategori</h3>
        <small class="text-muted">Daftar kategori barang inventaris</small>
    </div>

    <a href="<?= BASE_URL ?>/categories/create"
       class="btn btn-primary">
        + Tambah Kategori
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">

                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Barang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($categories)): ?>

                        <?php foreach ($categories as $index => $category): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>

                                <td><?= e($category['name']) ?></td>

                                <td><?= e($category['description'] ?? '-') ?></td>

                                <td><?= e($category['item_count']) ?></td>

                                <td>
                                    <a href="<?= BASE_URL ?>/categories/edit/<?= $category['id'] ?>"
                                       class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form action="<?= BASE_URL ?>/categories/delete/<?= $category['id'] ?>"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                                        <button type="submit"
                                                class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>

                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">
                                Belum ada kategori.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
