document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.querySelector('input[name="password"]');

    const togglePasswordButton = document.querySelector(".togglePassword");
    const eyeIcon = togglePasswordButton.querySelector('img');

    togglePasswordButton.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            if(document.querySelector('input[name="password_verify"]')){
                const passwordVerifyInput = document.querySelector('input[name="password_verify"]');
                passwordVerifyInput.type = 'text';
                setTimeout(function() {
                    passwordVerifyInput.type = 'password';
                }, 3000); // Masquer après 3 secondes
            }
            passwordInput.type = 'text';
            eyeIcon.src = 'public/asset/img/oeil.svg'; // Change l'image pour oeil ouvert
            setTimeout(function() {
                passwordInput.type = 'password';

                eyeIcon.src = 'public/asset/img/oeilferme.svg'; // Remet l'image pour oeil fermé
            }, 3000); // Masquer après 3 secondes
        } else {
            if(document.querySelector('input[name="password_verify"]')){
                const passwordVerifyInput = document.querySelector('input[name="password_verify"]');
                passwordVerifyInput.type = 'password';
            }

            passwordInput.type = 'password';
            eyeIcon.src = 'public/asset/img/oeilferme.svg'; // Remet l'image pour oeil fermé
        }
    });
    
});

