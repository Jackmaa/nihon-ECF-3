<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo $manga->manga->getName(); ?></h1>
    <img src=".<?php echo $manga->manga->getThumbnail(); ?>" alt="<?php echo $manga->manga->getName(); ?>">
    <span><?php echo $manga->author ?></span>
    <?php foreach ($volumes as $volume): ?>
        <h2>Volume&nbsp;<?php echo $volume ?></h2>
    <?php endforeach; ?>
</body>
</html>