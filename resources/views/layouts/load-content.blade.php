<!-- load-content.php -->
<?php
if (!isset($_POST['menu'])) {
    exit('No menu specified');
}

$menu = $_POST['menu'];
$validMenus = ['dashboard', 'level', 'user', 'kategori', 'barang', 'supplier', 'stok', 'penjualan'];

if (!in_array($menu, $validMenus)) {
    exit('Invalid menu specified');
}

// Set the active menu in session if needed
session_start();
$_SESSION['activeMenu'] = $menu;

// Include the appropriate content file
$contentFile = "content/{$menu}.php";
if (file_exists($contentFile)) {
    include $contentFile;
} else {
    echo "<h2>Content for '{$menu}' not found</h2>";
}
?>