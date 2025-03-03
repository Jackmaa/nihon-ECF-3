<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="<?php echo $this->router->generate('update', ['id' => $data->getId_manga()]); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name ="id" value="<?= $data->getId_manga()?>">
    <div>            
        <label for="name">Name: </label>
        <input type="text" name="name" id="name" value="<?= $data->getName()?>">
    </div>
    <div>            
        <label for="description">Description: </label>
        <textarea name="description" id=" descirption"><?= $data->getDescription()?></textarea>
    </div>
    <div>            
        <label for="published_date">Realeased on: </label>
        <input type="date" name="published_date" id="published_date" value="<?= $data->getPublished_date()->format('Y-m-d')?>">
    </div>
    <div>            
        <label for="thumbnail">Pick a thumbnail: </label>
        <input type="file" name="thumbnail" id="thumbnail">
    </div>
    <button type='submit'>oui</button>
</form>
</body>
</html>