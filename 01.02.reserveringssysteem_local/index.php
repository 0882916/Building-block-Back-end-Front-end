<?php

if (isset($_POST['login'])) {
    header('Location: login.php');
}

?>

<!doctype html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/navbar.style.css"/>
    <link rel="stylesheet" type="text/css" href="css/index.style.css"/>
</head>

<body>

<header>
    <div class="navigation">
        <div class="logo">
            <a href="index.php">
                <img src="http://boconsushiconcepts.com/wp-content/themes/bocon/images_temp/logo.png">
            </a>
        </div>

        <div class="menu">
            <ul class="menu-item">
                <li><a href="index.php">home</a></li>
                <li><a href="reservering.php">about</a></li>
                <li><a href="reservering.php">machines</a></li>
                <li><a href="reservering.php">food</a></li>
                <li><a href="r                <li><a href="reservering.php">news</a></li>
                <li><a href="reservering.php">contact</a></li>
            </ul>
        </div>

        <div class="language">
            <ul>
                <li class="flag-nl">
                    <img src="http://boconsushiconcepts.com/wp-content/plugins/sitepress-multilingual-cms/res/flags/nl.png"
                         alt="nl" title="Nederlands">
                </li>

                <li class="flag-en">
                    <img src="http://boconsushiconcepts.com/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                         alt="en" title="English">
                </li>

                <li class="flag-fr">
                    <img src="http://boconsushiconcepts.com/wp-content/plugins/sitepress-multilingual-cms/res/flags/fr.png"
                         alt="fr" title="Français">
                </li>

                <li class="flag-de">
                    <img src="http://boconsushiconcepts.com/wp-content/plugins/sitepress-multilingual-cms/res/flags/de.png"
                         alt="de" title="Deutch">
                </li>
            </ul>
        </div>
    </div>

</header>

<div class="border"></div>

<div class="image">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
          enctype="multipart/form-data">
        <div class="data-submit">
            <input id="login" type="submit" name="login" value="login"/>
        </div>
    </form>
    <div class="main-image">
        <img src="images/header.png">
    </div>
</div>

<div class="article">
    <div class="article-left">
        <div class="article-content">
            <h3>Bocon Sushi Concepts</h3>
            <p>Dagelijks verse Sushi – Concepten voor supermarkten, foodservice restaurants en
                snackcorners in benzinestations en streetfood kiosken.</p>
            <ul>eservering.php">concepts</a></li>

                <li><a>Hoe werkt 't?</a></li>
            </ul>
            <span><strong>News</strong></span>
            <ul>
                <li><a>Huur een robot voor € 99,- |Makito Brussel | Maki robot met loopband |
                        Demonstratiedag | Nieuw: Verpakkingsmachines | Sushi kant-en-klaar MAP |
                        Factsheet robots| Leasing | Persbericht</a></li>
            </ul>
        </div>
    </div>

    <div class="article-center">
        <div class="article-content">
            <h3>Een totaalconcept voor Sushi</h3>
            <ul>
                <li><a>Machines voor de rijst- en Sushi productie: een kosten- en tijdbesparende
                        technologie. Nu ook als lease aanbod.</a></li>
                <li><a>Producten voor efficiënt werken met voorgesneden ingrediënten en kant-en-klare
                        Sushi-rijst van restaurant kwaliteit.</a></li>
                <li><a>Advies voor het gebruik van de machines, het samenstellen van het menu tot de
                        opleiding van uw medewerkers.</a></li>
            </ul>
            <div class="span-container">
                <span><a href="reservering.php"><strong>Klik hier</strong></a> voor het maken van een afspraak om een
                kijkje te nemen naar onze machines in onze showroom</span>
            </div>
        </div>
    </div>

    <div class="article-right">
        <div class="article-content">
            <h3>Sushi ook in uw zaak</h3>
            <p>Sushi als gezond, trendy en modern product vind steets meer liefhebbers.</p>
            <p>Bocon Sushi Concepts maakt het mogelijk verse Sushi aan uw assortiment toe
                te voegen of uw bestaande Sushi productie te automatiseren</p>
            <ul>
                <li><a>Nieuw: Sushi kant-en-klaar MAP</a></li>
                <li><a>Automatiseren van uw productie</a></li>
                <li><a>Supermarkten</a></li>
                <li><a>Foodservice Horeca</a></li>
                <li><a>Street food: Sushi Burrito / Wrap / Sandwich</a></li>
                <li><a>Kant-en-klare Sushi rijst</a></li>
            </ul>

        </div>
    </div>
</div>

<footer>
    <strong>Bocon Sushi Concepts</strong>,
    Melbournestraat 76a, NL-3047 BJ Rotterdam,
    <a href="mailto:info@boconsushiconcepts.com">info@boconsushiconcepts.com</a>
</footer>

</body>

</html>
