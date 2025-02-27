# 🌐 **NIHON**

✨ **Why NIHON? What does it mean?**

Nihon is an online manga library designed to provide an organized and user-friendly way to explore and manage your favorite manga. The name Nihon was chosen as a play on words: in Japanese, Hon (本) means "book," and we wanted a name that reflects both our passion for manga and its cultural origins.

---

## 🚀 **Our Goal**

Create a comprehensive and user-friendly online manga library that allows users to browse, search, and borrow their favorite mangas. Nihon aims to provide a smooth and intuitive experience, following MVC principles for clean and scalable architecture, and ensuring a visually appealing and responsive UI.

## Ultimately, the goal is to make Nihon a go-to platform for manga enthusiasts, offering an organized, efficient, and enjoyable way to explore and track their favorite manga.

## 👥 **Project By**

This project is brought to you by an amazing team of developers:

- [@Mel00w](https://github.com/Mel00w)
- [@fab7669](https://github.com/fab7669)
- [@SamyMechiche](https://github.com/SamyMechiche)
- [@Jackmaa](https://github.com/Jackmaa)

---

## 📦 **Dependencies**

This project uses the following tools and libraries:

- ![Static Badge](https://img.shields.io/badge/composer-dependency_manager-blue)**[Composer](https://getcomposer.org/)**: A dependency manager for PHP.
- ![Static Badge](https://img.shields.io/badge/altorouter-router-green)**[AltoRouter](https://github.com/dannyvankooten/AltoRouter)**: A lightweight PHP router for handling URLs and routing.
- ![Static Badge](https://img.shields.io/badge/phpmailer-mailer-green)**[PHPMailer](https://github.com/PHPMailer/PHPMailer)**: A full-featured email creation and transfer class for PHP
- ![Static Badge](https://img.shields.io/badge/phpdotenv-envvraiables-green)**[PHPdotenv](https://packagist.org/packages/vlucas/phpdotenv)**: Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.
- ![Static Badge](https://img.shields.io/badge/GSAP-jsanimation-green)**[GSAP](https://gsap.com/)**: A wildly robust JavaScript animation library built for professionals

Add a composer.json to the root of your directory

```json
{
  "require": {
    "altorouter/altorouter": "1.1.0",
    "phpmailer/phpmailer": "^6.9",
    "vlucas/phpdotenv": "^5.6"
  },
  "autoload": {
    "classmap": ["entity/", "controller/", "model/", "view/"]
  }
}
```

You can install the dependencies by running:

```bash
composer install
```

```bash
npm install gsap
```
