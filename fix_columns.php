<?php
$mysqli = new mysqli('localhost', 'root', '', 'kost_db', 3306);
if ($mysqli->connect_error) {
    echo "Connect Error: " . $mysqli->connect_error . "\n";
    exit(1);
}
echo "Connected successfully to MySQL kost_db!\n";

$res = $mysqli->query("SHOW COLUMNS FROM tb_tipe_kamar");
$columns = [];
while ($row = $res->fetch_assoc()) {
    $columns[] = $row['Field'];
}
echo "Current columns in tb_tipe_kamar: " . implode(', ', $columns) . "\n";

$added = [];
if (!in_array('foto_1', $columns)) {
    $mysqli->query("ALTER TABLE tb_tipe_kamar ADD COLUMN foto_1 VARCHAR(255) NULL AFTER fasilitas");
    $added[] = 'foto_1';
}
if (!in_array('foto_2', $columns)) {
    $mysqli->query("ALTER TABLE tb_tipe_kamar ADD COLUMN foto_2 VARCHAR(255) NULL AFTER foto_1");
    $added[] = 'foto_2';
}
if (!in_array('foto_3', $columns)) {
    $mysqli->query("ALTER TABLE tb_tipe_kamar ADD COLUMN foto_3 VARCHAR(255) NULL AFTER foto_2");
    $added[] = 'foto_3';
}

if (!empty($added)) {
    echo "Successfully added columns: " . implode(', ', $added) . "\n";
} else {
    echo "Columns foto_1, foto_2, foto_3 already exist.\n";
}
