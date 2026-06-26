<?php

class Provinsi
{
    private $conn;
    private $table = "provinsi";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /*
    |--------------------------------------------------------------------------
    | Ambil Semua Data
    |--------------------------------------------------------------------------
    */

    public function getAll()
    {
        $sql = "SELECT *
                FROM {$this->table}
                ORDER BY nama_provinsi ASC";

        return $this->conn->query($sql);
    }

    /*
    |--------------------------------------------------------------------------
    | Ambil Data Berdasarkan ID
    |--------------------------------------------------------------------------
    */

    public function getById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM {$this->table}
            WHERE id_provinsi = ?
        ");

        $stmt->bind_param("i", $id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    /*
    |--------------------------------------------------------------------------
    | Tambah Data
    |--------------------------------------------------------------------------
    */

    public function insert($nama)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO {$this->table}
            (nama_provinsi)
            VALUES (?)
        ");

        $stmt->bind_param("s", $nama);

        return $stmt->execute();
    }

    /*
    |--------------------------------------------------------------------------
    | Update Data
    |--------------------------------------------------------------------------
    */

    public function update($id, $nama)
    {
        $stmt = $this->conn->prepare("
            UPDATE {$this->table}
            SET nama_provinsi = ?
            WHERE id_provinsi = ?
        ");

        $stmt->bind_param("si", $nama, $id);

        return $stmt->execute();
    }

    /*
    |--------------------------------------------------------------------------
    | Hapus Data
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        $stmt = $this->conn->prepare("
            DELETE FROM {$this->table}
            WHERE id_provinsi = ?
        ");

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    public function search($keyword)
    {
        $keyword = "%{$keyword}%";

        $stmt = $this->conn->prepare("
            SELECT *
            FROM {$this->table}
            WHERE nama_provinsi LIKE ?
            ORDER BY nama_provinsi ASC
        ");

        $stmt->bind_param("s", $keyword);

        $stmt->execute();

        return $stmt->get_result();
    }

    /*
|--------------------------------------------------------------------------
| Cek Apakah Provinsi Masih Digunakan
|--------------------------------------------------------------------------
*/

    public function isUsed($id)
    {

        $stmt = $this->conn->prepare("
            SELECT COUNT(id_kota)
            FROM kota
            WHERE id_provinsi = ?
        ");

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $stmt->bind_result($total);

        $stmt->fetch();

        $stmt->close();

        return $total > 0;
    }

}