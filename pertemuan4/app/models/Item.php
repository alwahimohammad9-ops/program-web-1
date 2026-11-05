
<?php

class Item extends Model
{
    protected string $table = 'items';

    // Menampilkan semua barang
    public function all(): array
    {
        return $this->db->query(
            "SELECT i.*, c.name AS category_name
            FROM items i
            LEFT JOIN categories c ON i.category_id = c.id
            ORDER BY i.name"
        )->fetchAll();
    }

    // Mengecek apakah kode barang sudah digunakan
    public function codeExists(string $code, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM items WHERE code = :code";
        $params = ['code' => $code];

        if ($excludeId !== null) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn() > 0;
    }

    // Menambahkan barang baru
    public function create(array $data): bool
    {
        return $this->db->prepare(
            "INSERT INTO items
            (code, name, category_id, quantity, unit, price, entry_date, description)
            VALUES
            (:code, :name, :category_id, :quantity, :unit, :price, :entry_date, :description)"
        )->execute($data);
    }

    // Mengubah data barang
    public function update(int $id, array $data): bool
    {
        $data['id'] = $id;

        return $this->db->prepare(
            "UPDATE items SET
            code = :code,
            name = :name,
            category_id = :category_id,
            quantity = :quantity,
            unit = :unit,
            price = :price,
            entry_date = :entry_date,
            description = :description
            WHERE id = :id"
        )->execute($data);
    }
}
