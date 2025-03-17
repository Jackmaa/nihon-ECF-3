<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $meta_description; ?>">
    <?php foreach ($scripts as $script): ?>
        <script src="<?php echo $script; ?>"></script>
    <?php endforeach; ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>public/asset/css/styles.css">
</head>
<body>
    <?php if ($title == 'Nihon | Login' || $title == 'Nihon | Register'): ?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $meta_description; ?>">
    <?php foreach ($scripts as $script): ?>
        <script src="<?php echo $script; ?>"></script>
    <?php endforeach; ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>public/asset/css/styles.css">
</head>
<body id="css-body">
    <?php else :
        include_once './view/template_part/header.php';
    ?>
    <?php endif;?>
    <section>
        <?php echo $content; ?>
    </section>
    <?php include_once './view/template_part/footer.php'; ?>
</body>
</html>