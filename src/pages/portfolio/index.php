<?php

// Start the session
session_start();

// Require the database connection
require_once "../../config/config.php";

// Require the portfolio related functions
require_once "../../utils/portfolio.php";

// Get the images to be displayed
$images = returnImage($conn);

// Get the number of rows for each section, to see if it's worth the section be printed or not
$numEducation = returnEducationRows($conn);
$numContact = returnContactRows($conn);
$numLanguage = returnLanguageRows($conn);

?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portefolio</title>
    <!-- FontAwesome Free 6.2.0 -->
    <link rel="stylesheet" href="../../assets/libs/fontawesome-free-6.2.0-web/css/fontawesome.css">
    <link rel="stylesheet" href="../../assets/libs/fontawesome-free-6.2.0-web/css/brands.css">
    <link rel="stylesheet" href="../../assets/libs/fontawesome-free-6.2.0-web/css/solid.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../assets/styles/bootstrap.min.css" />
    <link rel="stylesheet" href="../../assets/styles/portfolio.css" />
    <style>
        #hero {
            background:
                    linear-gradient(180deg, rgba(38, 50, 64, .8) 0%,
                    rgba(38, 50, 64, 1) 100%),
                    url('../../assets/images/<?= $images['header'] ?>');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .light-mode #hero {
            background:
                    linear-gradient(180deg, rgba(195, 191, 199, .8) 0%,
                    rgba(195, 191, 199, 1) 100%),
                    url('../../assets/images/<?= $images['header']; ?>');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        /* WebHost Stuff */
        img[src*="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"]{
            display: none !important;
        }
    </style>
    <!-- Light Theme Checker OnLoad -->
    <script src="../../assets/scripts/onload_portfolio.js"></script>
</head>
<body lang="en">

<!-- Progress Bar + Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="progress-container">
        <div class="progress-bar fixed-top" id="myBar"></div>
    </div>
    <div class="container-fluid">
        <a class="navbar-brand" href="">Portfolio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="#hero" aria-current="page" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#about-me" class="nav-link">About Me</a>
                </li>
                <?php if($numEducation > 0) { ?>
                <li class="nav-item">
                    <a href="#education" class="nav-link">Education</a>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="#contact-me-form" class="nav-link">Contact Me</a>
                </li>
                <li class="nav-item">
                <?php if(isset($_SESSION['id'])) { ?>
                    <a href="../statistics/" class="nav-link">CMS</a>
                <?php } else { ?>
                    <a href="../login/" class="nav-link">Login</a>
                <?php } ?>
                </li>
                <li class="nav-item">
                    <i class="nav-link fa-solid" id="toggleLight"></i>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<?php $hero = returnHeroData($conn); ?>
<header id="hero">
    <div class="info">
        <h1><span class="colored"><?= $hero['title']; ?></span></h1>
        <h3><?= $hero['description']; ?></h3>
        <div id="go-down">
            <button onclick="window.location.href='#about-me'"><i class="fa-solid fa-arrow-down"></i> See more</button>
        </div>
    </div>
</header>

<!-- About Me Section -->
<section id="about-me">
    <h1>More <span class="colored">About Me</span></h1>

    <div id="about-me-container">
        <!-- Mais Sobre Mim -->
        <div class="about-me-card">
            <h3>
                <p>My </p>
                <span class="colored">resume</span>
            </h3>
            <div class="about-me-info">
                <?php renderResumeData($conn); ?>
            </div>
        </div>

        <!-- O que Eu Ofereço -->
        <div class="about-me-card">
            <h3>
                <p>what am</p>
                <span class="colored">I offering</span>
            </h3>
            <div class="about-me-info skills-container">
                <div class="skills-card">
                    <h5>Soft Skills</h5>
                    <ul>
                        <?php renderSkillsData($conn, 1); ?>
                    </ul>
                </div>
                <div class="skills-card">
                    <h5>Hard Skills</h5>
                    <ul>
                        <?php renderSkillsData($conn, 2); ?>
                    </ul>
                </div>
                <?php if($numLanguage > 0) { ?>
                <div class="skills-card">
                    <h5>Languages</h5>
                    <?php renderLanguagesData($conn); ?>
                </div>
                <?php } ?>
            </div>
        </div>

        <!-- Foto -->
        <div class="about-me-card">
            <img src="../../assets/images/<?= $images['aboutMe']; ?>" alt="Foto" class="shadow-lg">
        </div>
    </div>
</section>

<!-- Education Section -->
<?php if($numEducation > 0) { ?>
<section id="education">
    <h1>My <span class="colored">Education</span></h1>

    <div id="education-container">
        <?php renderEducationData($conn); ?>
    </div>
</section>
<?php } ?>

<!-- Contact Me Form Section -->
<section id="contact-me-form">
    <h1>Let's have a <span class="colored">chat</span></h1>
    <h3>Send me a message.</h3>

    <?php if(isset($_SESSION['messageSuccess'])) {
        echo $_SESSION['messageSuccess'];
        unset($_SESSION['messageSuccess']);
    } elseif (isset($_SESSION['messageError'])) {
        echo $_SESSION['messageError'];
        unset($_SESSION['messageError']);
    } ?>

    <form action="../../server/portfolio.php" method="post" autocomplete="off">
        <div class="form-input">
            <label for="nameField">Name <span class="text-secondary">*</span></label>
            <input type="text" name="name" id="nameField" placeholder="John Doe" required>
        </div>
        <div class="form-input">
            <label for="emailField">E-mail <span class="text-secondary">*</span></label>
            <input type="email" name="email" id="emailField" placeholder="johndoe@company.com" required>
        </div>
        <div class="form-input">
            <label for="messageFeild">Message <span class="text-secondary">*</span></label>
            <textarea name="message" id="messageField" cols="30" rows="10" placeholder="Hi Hugo, pleased to talk to you..." required></textarea>
        </div>
        <button type="submit" name="sendMessageSubmit">
            <i class="fa-solid fa-paper-plane"></i> Send
        </button>
    </form>

    <?php if($numContact > 0) { ?>
    <div id="contacts-wrapper">
        <?php renderContacts($conn); ?>
    </div>
    <?php } ?>
</section>

<!-- Footer -->
<footer><?php renderFooter($conn); ?></footer>

<!-- Bootstrap, Popper & Main JS -->
<script src="../../assets/scripts/popper.min.js"></script>
<script src="../../assets/scripts/bootstrap.min.js"></script>
<script src="../../assets/scripts/portfolio_main.js"></script>
<script src="../../assets/scripts/portfolio_toggleLight.js"></script>

</body>
</html>
