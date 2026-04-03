<?php
include('database.php');

// 1. Fetch the existing pet data
$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare('SELECT * FROM pets WHERE id = :id');
$stmt->execute(['id' => $id]);
$pet = $stmt->fetch();

// 2. Handle the Update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_method'] ?? '') === 'put') {
    // Keep current image unless a new one is uploaded
    $img = $pet['image_path'];
    if (!empty($_FILES['image']['name'])) {
        $img = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $img);
    }

    // Capture all form inputs
    $params = [
        'n'   => htmlspecialchars($_POST['name']),
        's'   => htmlspecialchars($_POST['species']),
        'a'   => (int)$_POST['age'], // This was missing from your form
        'o'   => htmlspecialchars($_POST['owner_contact']), // This was missing
        'd'   => htmlspecialchars($_POST['description']),
        'i'   => $img,
        'id'  => $id
    ];

    $sql = "UPDATE pets SET 
            name = :n, 
            species = :s, 
            age = :a, 
            owner_contact = :o, 
            description = :d, 
            image_path = :i 
            WHERE id = :id";
    
    $pdo->prepare($sql)->execute($params);
    header("Location: index.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Pet | <?= $pet['name'] ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background-color: #c9fbfa;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container{
            background-color: #ffffff;
            padding: 40px 30px;
            width: 100%;
            max-width: 600px;
        }

        .pet-name {
            color: #4392f1;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 28px;
            margin: 0 0 25px 0;
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="form-container">
        <div class="pet-name">Update Pet Information</div>
        
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="put">
            
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Pet Name</label>
                    <input type="text" name="name" class="form-control" value="<?= $pet['name'] ?>" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Species</label>
                    <input type="text" name="species" class="form-control" value="<?= $pet['species'] ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label>Age (Years)</label>
                    <input type="number" name="age" class="form-control" value="<?= $pet['age'] ?>" required>
                </div>
                <div class="col-md-8 form-group">
                    <label>Owner Contact Info</label>
                    <input type="text" name="owner_contact" class="form-control" value="<?= $pet['owner_contact'] ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Description / Notes</label>
                <textarea name="description" class="form-control" rows="4"><?= $pet['description'] ?></textarea>
            </div>

            <div class="form-group">
                <label>Change Photo (Optional)</label>
                <input type="file" name="image" class="form-control">
                <p class="help-block">Current: <?= $pet['image_path'] ?></p>
            </div>

            <hr>
            <div class="text-center">
                <button type="submit" class="btn btn-success btn-lg">Update Records</button>
                <a href="index.php" class="btn btn-danger btn-lg">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>