<?php
include('database.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $species = htmlspecialchars($_POST['species'] ?? '');
    $age = (int)$_POST['age'];
    $owner = htmlspecialchars($_POST['owner_contact'] ?? '');
    $desc = htmlspecialchars($_POST['description'] ?? '');

    // Image upload logic
    $image_name = 'default.jpg';
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
       // put uploaded file to uploads folder
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image_name);
    }

    $sql = "INSERT INTO pets (name, species, age, owner_contact, description, image_path) 
            VALUES (:name, :species, :age, :owner, :description, :image_path)";

    $stmt = $pdo->prepare($sql);
    $params = [
        'name' => $name,
        'species' => $species,
        'age' => $age,
        'owner' => $owner,
        'description' => $desc,
        'image_path' => $image_name
    ];

    $stmt->execute($params);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pet Registration</title>
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

        .form-container {
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
        <div class="pet-name">New Pet Registration</div>
        
        <form method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Pet Photo</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="form-group">
                <label>Pet Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Tiger" required>
            </div>

            <div class="form-group">
                <label>Species</label>
                <input type="text" name="species" class="form-control" placeholder="e.g. Cat" required>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Age</label>
                        <input type="number" name="age" class="form-control" required>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label>Owner Contact Info</label>
                        <input type="text" name="owner_contact" class="form-control" placeholder="Name or Number" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Temperament, medical notes, etc."></textarea>
            </div>

            <hr>
            <div class="text-center">
                <button type="submit" name="submit" class="btn btn-success btn-lg">Add Pet</button>
                <a href="index.php" class="btn btn-danger btn-lg">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>