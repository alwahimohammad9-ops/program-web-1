
<?php
$title = 'Data Barang';

require ROOT_PATH . '/app/views/layouts/header.php';

$categories = array_unique(array_filter(
    array_column($items ?? [], 'category_name')
));
sort($categories);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Data Barang</h3>
        <small class="text-muted">Daftar barang inventaris sekolah</small>
    </div>

    <a href="<?= BASE_URL ?>/items/create" class="btn btn-primary">
        + Tambah Barang
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">

        <h5 class="mb-3">
            Total Barang: <span id="totalBarang"><?= count($items ?? []) ?></span>
        </h5>

        <!-- Pencarian dan Filter -->
        <div class="row g-3 mb-4">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Cari Barang</label>
                <input
                    type="text"
                    id="searchBarang"
                    class="form-control"
                    placeholder="Cari kode atau nama barang..."
                >
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Filter Kategori</label>

                <select id="filterKategori" class="form-select">
                    <option value="">Semua Kategori</option>

                    <?php foreach ($categories as $category): ?>
                        <option value="<?= e($category) ?>">
                            <?= e($category) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

        </div>

        <!-- Tabel Barang -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">

                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="tabelBarang">

                    <?php if (!empty($items)): ?>

                        <?php foreach ($items as $index => $item): ?>

                            <tr
                                data-code="<?= e($item['code']) ?>"
                                data-name="<?= e($item['name']) ?>"
                                data-category="<?= e($item['category_name'] ?? '-') ?>"
                            >
                                <td class="nomor"><?= $index + 1 ?></td>
                                <td><?= e($item['code']) ?></td>
                                <td><?= e($item['name']) ?></td>
                                <td><?= e($item['category_name'] ?? '-') ?></td>
                                <td><?= e($item['quantity']) ?></td>
                                <td><?= e($item['unit']) ?></td>
                                <td><?= rupiah($item['price']) ?></td>

                                <td>
                                    <a
                                        href="<?= BASE_URL ?>/items/edit/<?= $item['id'] ?>"
                                        class="btn btn-warning btn-sm"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="<?= BASE_URL ?>/items/delete/<?= $item['id'] ?>"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus barang ini?')"
                                    >
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="8" class="text-center">
                                Belum ada data barang.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

            <div
                id="tidakDitemukan"
                class="alert alert-warning text-center d-none"
            >
                Barang tidak ditemukan.
            </div>

        </div>

        <!-- Informasi dan Navigasi Halaman -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3">

            <small class="text-muted" id="infoHalaman">
                Menampilkan data barang
            </small>

            <nav aria-label="Navigasi halaman barang">
                <ul class="pagination mb-0" id="pagination"></ul>
            </nav>

        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchBarang');
    const filterKategori = document.getElementById('filterKategori');
    const tabelBarang = document.getElementById('tabelBarang');
    const totalBarang = document.getElementById('totalBarang');
    const tidakDitemukan = document.getElementById('tidakDitemukan');
    const pagination = document.getElementById('pagination');
    const infoHalaman = document.getElementById('infoHalaman');

    const semuaBaris = Array.from(
        tabelBarang.querySelectorAll('tr[data-code]')
    );

    const perHalaman = 10;
    let halamanAktif = 1;

    function tampilkanBarang() {

        const keyword = searchInput.value.toLowerCase().trim();
        const kategori = filterKategori.value.toLowerCase();

        const hasilFilter = semuaBaris.filter(function (row) {

            const code = row.dataset.code.toLowerCase();
            const name = row.dataset.name.toLowerCase();
            const category = row.dataset.category.toLowerCase();

            const cocokPencarian =
                code.includes(keyword) || name.includes(keyword);

            const cocokKategori =
                kategori === '' || category === kategori;

            return cocokPencarian && cocokKategori;
        });

        const total = hasilFilter.length;
        const totalHalaman = Math.ceil(total / perHalaman);

        if (totalHalaman === 0) {
            halamanAktif = 1;
        } else if (halamanAktif > totalHalaman) {
            halamanAktif = totalHalaman;
        }

        const awal = (halamanAktif - 1) * perHalaman;
        const akhir = awal + perHalaman;

        const barisTampil = hasilFilter.slice(awal, akhir);

        // Sembunyikan semua baris
        semuaBaris.forEach(function (row) {
            row.style.display = 'none';
        });

        // Tampilkan baris sesuai halaman
        barisTampil.forEach(function (row, index) {
            row.style.display = '';
            row.querySelector('.nomor').textContent = awal + index + 1;
        });

        totalBarang.textContent = total;

        tidakDitemukan.classList.toggle(
            'd-none',
            total > 0
        );

        if (total > 0) {
            infoHalaman.textContent =
                'Menampilkan ' + (awal + 1) + '–' +
                Math.min(akhir, total) + ' dari ' + total + ' barang';
        } else {
            infoHalaman.textContent = 'Tidak ada data barang';
        }

        buatPagination(totalHalaman);
    }

    function buatPagination(totalHalaman) {

        pagination.innerHTML = '';

        if (totalHalaman <= 1) {
            return;
        }

        // Tombol Sebelumnya
        tambahTombol(
            'Sebelumnya',
            halamanAktif - 1,
            halamanAktif === 1
        );

        // Nomor halaman
        for (let i = 1; i <= totalHalaman; i++) {

            tambahTombol(
                i,
                i,
                false,
                i === halamanAktif
            );

        }

        // Tombol Selanjutnya
        tambahTombol(
            'Selanjutnya',
            halamanAktif + 1,
            halamanAktif === totalHalaman
        );
    }

    function tambahTombol(label, halaman, disabled, active = false) {

        const li = document.createElement('li');
        li.className = 'page-item';

        if (disabled) {
            li.classList.add('disabled');
        }

        if (active) {
            li.classList.add('active');
        }

        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'page-link';
        button.textContent = label;
        button.disabled = disabled;

        button.addEventListener('click', function () {

            halamanAktif = halaman;
            tampilkanBarang();

        });

        li.appendChild(button);
        pagination.appendChild(li);
    }

    searchInput.addEventListener('input', function () {
        halamanAktif = 1;
        tampilkanBarang();
    });

    filterKategori.addEventListener('change', function () {
        halamanAktif = 1;
        tampilkanBarang();
    });

    tampilkanBarang();

});
</script>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
