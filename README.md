# 🌐 **NIHON**

## 🚀 **Our Goal**

---

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
- ![Static Badge](https://img.shields.io/badge/phpmailer-router-green)**[PHPMailer](https://github.com/PHPMailer/PHPMailer)**: A full-featured email creation and transfer class for PHP
- ![Static Badge](https://img.shields.io/badge/phpdotenv-router-green)**[PHPdotenv](https://packagist.org/packages/vlucas/phpdotenv)**: Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.
- ![Static Badge](https://img.shields.io/badge/GSAP-green)**[GSAP](https://gsap.com/)**: A wildly robust JavaScript animation library built for professionals

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
