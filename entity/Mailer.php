<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once './vendor/autoload.php';

class Mailer {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->configureMailer();
    }

    private function configureMailer() {
        $this->mail->CharSet = 'UTF-8';
        $this->mail->isSMTP();
        $this->mail->Host = 'sandbox.smtp.mailtrap.io'; // Configuration du serveur SMTP de Mailtrap
        $this->mail->SMTPAuth = true;
        $this->mail->Port = 2525;
        $this->mail->Username = '227c72b022dd6d'; // Ton identifiant Mailtrap
        $this->mail->Password = '5bf5ecbe5ffe93'; // Ton mot de passe Mailtrap
    }

    public function sendVerificationEmail($email, $verificationLink, $username) {
        try {
            $this->mail->setFrom('do-not-replyNihon@gmail.com', 'Nihon');
            $this->mail->addAddress('destinataire@example.com', 'user'); // Adresse de test Mailtrap
            $this->mail->addAttachment('asset/img/Group 10.svg');
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Confirme ton inscription à NIHON ! 📖✨';
            $this->mail->Body = '<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
                Salut ' . $username . ', <br><br>
                Bienvenue sur <strong>NIHON</strong>, ta nouvelle mangathèque en ligne ! 🎉 <br>
                Avant de commencer ton aventure parmi nos milliers de mangas, il ne te reste plus qu’une étape : confirmer ton adresse e-mail. <br><br>
                Clique sur le bouton ci-dessous pour activer ton compte :<br><br>
                <a href="' . $verificationLink . '" style="background-color: #cc392b; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">✅ Confirmer mon compte</a><br><br>
                Si le bouton ne fonctionne pas, copie et colle ce lien dans ton navigateur :<br>
                <a href="' . $verificationLink . '" style="color: #cc392b;">' . $verificationLink . '</a><br><br>
                Si tu n’es pas à l’origine de cette inscription, ignore simplement cet e-mail.<br><br>
                À très bientôt sur <strong>NIHON</strong> ! 📚🔥<br><br>
                L’équipe <strong>NIHON</strong>
            </p>';
            $this->mail->AltBody = 'Salut ' . $username . ', Bienvenue sur NIHON. Clique sur ce lien pour vérifier votre email : ' . $verificationLink;

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return $this->mail->ErrorInfo;
        }
    }
}
?>
