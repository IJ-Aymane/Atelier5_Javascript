<?php
$uploadDir = __DIR__ . "/uploads";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$action = $_GET['action'] ?? '';

if ($action === 'upload') {
    if (!isset($_FILES['file'])) {
        echo json_encode(['message' => 'Aucun fichier reçu.']);
        exit;
    }

    $file = $_FILES['file'];
    $target = $uploadDir . '/' . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $target)) {
        echo json_encode(['message' => 'Fichier téléchargé avec succès.']);
    } else {
        echo json_encode(['message' => 'Erreur lors du téléchargement.']);
    }

} elseif ($action === 'list') {
    $files = array_values(array_diff(scandir($uploadDir), ['.', '..']));
    echo json_encode($files);

} else {
    echo json_encode(['message' => 'Action invalide.']);
}
