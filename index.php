<?php 
include('database.php'); 
$stm = $pdo->query('SELECT * FROM pets ORDER BY created_at DESC');
$pets = $stm->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PetCare | Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">


    <style>
        body { background-color: #C4FFFC; color: #242424; }
        .navbar { background-color: #242424; border: none; border-radius: 0; }
        .navbar-brand { color: #FFFFFF !important; font-weight: bold; }
        .pet-card { background: #FFFFFF; border-radius: 8px; padding: 15px; margin-bottom: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: 0.3s; }
        .pet-card:hover { transform: translateY(-5px); }
        .img-container { height: 180px; overflow: hidden; margin: -15px -15px 15px -15px; border-radius: 8px 8px 0 0; }
        .img-container img { width: 100%; height: 100%; object-fit: cover; }
        .btn-primary { background-color: #4392f1; border: none; }
    </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container">
    <a class="navbar-brand" href="index.php">PETCARE SYSTEM</a>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="create.php" style="color: #C4FFFC;">+ Register Pet</a></li>
    </ul>
  </div>
</nav>

<div class="container">
    <div class="row">
        <?php foreach ($pets as $pet): ?>
        <div class="col-sm-6 col-md-4">
            <div class="pet-card">
                <div class="img-container">
                    <img src="uploads/<?= $pet['image_path'] ?: 'default.jpg' ?>" alt="Pet">
                </div>
                <h4 style="color: #4392f1; font-weight: bold;"><?= $pet['name'] ?></h4>
                <p><span class="label label-info"><?= $pet['species'] ?></span></p>
                <p><strong>Owner:</strong> <?= $pet['owner_contact'] ?></p>
                <a href="selected.php?id=<?= $pet['id'] ?>" class="btn btn-primary btn-sm btn-block">Details</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>