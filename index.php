<?php 
include('database.php'); 

$search = $_GET['search'] ?? '';

// Use !== '' to check if the string is NOT empty
if ($search !== '') {
    $sql = "SELECT * FROM pets WHERE species LIKE :search ORDER BY created_at DESC";
    $stm = $pdo->prepare($sql);
    $stm->execute(['search' => '%' . $search . '%']);
} else {
    $stm = $pdo->query('SELECT * FROM pets ORDER BY created_at DESC');
}

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
        .pet-card { background: #FFFFFF; border-radius: 8px; padding: 15px; margin-bottom: 30px; transition: 0.3s; }
        .pet-card:hover { transform: translateY(-5px); }
        .img-container { height: 180px; overflow: hidden; margin: -15px -15px 15px -15px; border-radius: 8px 8px 0 0; }
        .img-container img { width: 100%; height: 100%; object-fit: cover; }
        .navbar-form { border: none; box-shadow: none; }
    </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">PETCARE SYSTEM</a>
    </div>

    <form class="navbar-form navbar-left" role="search" method="GET" action="index.php">
      <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search pets by species" value="<?= htmlspecialchars($search) ?>">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </form>

    <ul class="nav navbar-nav navbar-right">
      <li>
        <a href="create.php" style="color: #C4FFFC;">
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Register Pet
        </a>
      </li>
    </ul>
  </div>
</nav>

<div class="container">
    <?php if (empty($pets)): ?>
        <div class="alert alert-warning">No pets found matching "<strong><?= htmlspecialchars($search) ?></strong>"</div>
    <?php endif; ?>

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
                <a href="selected.php?id=<?= $pet['id'] ?>" class="btn btn-info btn-block">Details</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>