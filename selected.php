<?php
include('database.php'); //

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM pets WHERE id = :id');
$stmt->execute(['id' => $id]);
$pet = $stmt->fetch();

if (!$pet) {
    die("Pet record not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pet['name'] ?> | Profile</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
    
        body {
            background-color: #c9fbfa;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* White inner container */
        .profile-container {
            background-color: #ffffff;
            padding: 40px 30px;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        /* Action buttons footer */
        .action-links {
            margin-top: 40px;
            margin: 10px;
        }

        .pet-name {
            color: #4392f1;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 28px;
            margin: 10px 0 15px 0;
        }

    </style>
</head>

<body>

    <div class="profile-container">         
        <img src="uploads/<?= $pet['image_path'] ?: 'default.jpg' ?>" 
             alt="<?= $pet['name'] ?>"
             class="img-responsive center-block" 
             style="width: 250px; height: 250px; object-fit: cover; border-radius: 60px; margin-bottom: 5px;">
        
        <div class="pet-name">
            <?= $pet['name'] ?>
        </div>

        <p class="text-info">Species: <strong><?= $pet['species'] ?></strong></p>
        <p class="text-info">Age: <strong><?= $pet['age'] ?></strong></p>
        <p class="text-info">Owner: <strong><?= $pet['owner_contact'] ?></strong></p>
        <p class="text-info">Description: <strong><?= $pet['description'] ?></strong></p>

        <div class="action-links">
            <button class="btn btn-success"><a href="index.php">Dashboard</a> </button>
           
            <button class="btn btn-warning"><a href="edit.php?id=<?= $pet['id'] ?>">Edit</a> </button>

            <form action="delete.php" method="POST" style="display:inline;">
                <input type="hidden" name="_method" value="delete"> <input type="hidden" name="id"
                    value="<?= $post['id'] ?>"> <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Delete this record?')">Delete</button>
            </form>
        </div>
    </div>

</body>

</html>