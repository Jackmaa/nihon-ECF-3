<?php
$title            = 'Nihon | ' . $manga->manga->getName();
$meta_description = $manga->manga->getName() . 'it a great manga';
$scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\header.js"];
ob_start();
?>
<main>
<h1><?php echo $manga->manga->getName(); ?></h1>
<img src=".<?php echo $manga->manga->getThumbnail(); ?>" alt="<?php echo $manga->manga->getName(); ?>">
<span><?php echo $manga->author ?></span>
</main>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view\base_html.php';
?>