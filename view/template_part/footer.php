<footer>
        <p>Join us</p>
        <div class="flex1">
            <div class="flex">
                <a href="#"><img src="<?= BASE_URL ?>public\asset\img\Insta.svg" alt="insta"></a>
                <a href="#"><img src="<?= BASE_URL ?>public\asset\img\facebook.svg" alt="facebook"></a>
                <a href="#"><img src="<?= BASE_URL ?>public\asset\img\x.svg" alt="twitter"></a>
            </div>
            <div>
                <a href="#"><img src="<?= BASE_URL ?>public\asset\img\logo.svg" class=logo alt="logo"></a>
            </div>
        </div>
        <div class="copyright">
            <div>
                <a href="#">Terms</a>
                <a href="#">Privacy</a>
                <a href="#">Security</a>
                <a href="#">Contact</a>
            </div>        
            <p>© 2025 Nihon. All right reserved.</p>
        </div>
    </footer>
    <?php foreach ($scripts as $script) { 
    $isExternal = preg_match('/^https?:\/\//', $script); // Checks if the link starts with http:// or https://
    ?>
    <script src="<?= $isExternal ? $script : BASE_URL . $script ?>"></script>
<?php } ?>

</body>
</html>