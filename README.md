# webshop

Deze webshop werd ontwikkeld als opdracht voor het vak Mobiel & Internet 4 door [Samuel Debruyn](http://sa.muel.be).
De webshop is beschikbaar op [mijn webserver](http://webshop.sa.muel.be).

## Features

* responsive design: werkt op alle schermformaten (getest op iPad 2, Asus Slider, Nexus 5, Nexus 4, Galaxy Nexus, Nexus S, iPhone 4S, Asus X53Sv, MacBook Pro, telkens in Google Chrome, Mozilla Firefox en Apple Safari) - Sommige administratieve taken kunnen enkel op grote schermen uitgevoerd worden zonder veel te moeten scrollen.
* cross-browser: Werkt in alle moderne browsers en Internet Explorer 7 of nieuwer (met CSS-hacks voor IE 7)
* r-mails bij registratie, bestelling, betaling van bestelling, verzending van bestelling en wachtwoord vergeten
* valid HTML 5
* valid CSS 3 (met uitzondering van [IE7 hacks](http://stackoverflow.com/questions/4563651/what-does-an-asterisk-do-in-a-css-property-name))
* valid i18n (W3C internationalization validator)
* MobileOK (85% op W3C MobileOK checker)
* snelle laadtijden door minified CSS en JavaScript
* gestructureerde code dankzij MVC-structuur
* veilig: wachtwoorden worden geëncrypteerd opgeslagen met een security salt en beschermd tegen SQL injecties
* gebruik van cache om schaalbaarheid te verbeteren

## Installatie

### Requirements

*   PHP 5.2.8 of nieuwer (geschreven voor PHP 5.5)
*   MySQL 5 met innoDB
*   PDO-drivers voor MySQL in PHP
*   Apache webserver, liefst op Linux (.htaccess wordt gebruikt en mod_rewrite moet ingeschakeld zijn)

### Database

Voer de volgende SQL statements uit om je tabellen aan te maken.

    CREATE TABLE IF NOT EXISTS `categories` (
      `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `picture` varchar(255) DEFAULT NULL,
      `description` text,
      `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `CATEGORY_TITLE` (`title`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;
    
    CREATE TABLE IF NOT EXISTS `products` (
      `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `price` decimal(10,2) unsigned NOT NULL,
      `category_id` tinyint(3) unsigned NOT NULL,
      `description` text,
      `picture` varchar(255) DEFAULT NULL,
      `stock` mediumint(8) unsigned DEFAULT '1',
      `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `PRODUCT_TITLE` (`title`),
      KEY `CATEGORY_ID` (`category_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;
    
    CREATE TABLE IF NOT EXISTS `purchased_products` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `purchase_id` mediumint(8) unsigned NOT NULL,
      `product_id` smallint(5) unsigned NOT NULL,
      `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `PURCHASE_ID` (`purchase_id`),
      KEY `PRODUCT_ID` (`product_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9080 ;
    
    CREATE TABLE IF NOT EXISTS `purchases` (
      `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
      `user_id` smallint(5) unsigned NOT NULL,
      `payed` tinyint(1) DEFAULT '0',
      `shipped` tinyint(1) DEFAULT '0',
      `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `USER_ID` (`user_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;
    
    CREATE TABLE IF NOT EXISTS `users` (
      `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
      `username` varchar(20) NOT NULL,
      `password` varchar(256) NOT NULL,
      `first_name` varchar(100) NOT NULL,
      `last_name` varchar(100) NOT NULL,
      `email` varchar(200) NOT NULL,
      `address` text NOT NULL,
      `admin` tinyint(1) DEFAULT '0',
      `reset_key` varchar(256) DEFAULT NULL,
      `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `USER_NAME` (`username`),
      UNIQUE KEY `USER_EMAIL` (`email`),
      UNIQUE KEY `REAL_NAME` (`first_name`,`last_name`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;
    
    
    ALTER TABLE `products`
      ADD CONSTRAINT `cat id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
    
    ALTER TABLE `purchased_products`
      ADD CONSTRAINT `product cascading` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
      ADD CONSTRAINT `purchases cascading` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
    
    ALTER TABLE `purchases`
      ADD CONSTRAINT `user id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

Pas nu onderstaand statement aan (vooral e-mailadres en gebruikersnaam) en voer het ook uit om een eerste beheerder aan te maken. Vul geen wachtwoord (vul gewoon 0 in) in, maar kies wel een correct e-mailadres. Gebruik dan na installatie de optie 'Wachtwoord vergeten' om een wachtwoord in te stellen.

    INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `address`, `admin`, `reset_key`, `modified`) VALUES (NULL, 'hier uw gebruikersnaam', '0', 'hier uw voornaam', 'hier uw achternaam', 'hier uw e-mail@adres', 'hier uw straatadres', '1', NULL, NULL);
    
### Configuratie

Open de map `/app/Config/`. In het bestand `Core.php` zijn de 4 aan te passen regels apart gemarkeerd tussen comments. In de tweede regel moet de volledige URL naar de hoofdmap van de webshop staan en daaronder moeten 2 security salts ingevuld worden om wachtwoorden veilig te kunnen opslaan. Zowel voor salt als voor cipherseed vind je  een waarde op http://www.sethcardoza.com/tools/random-password-generator/

Maak nadien een nieuw bestand aan en vul gegevens over de database in, het bestand moet `Database.php` heten en in de map `/app/Config` zitten.

    <?php
    
    class DATABASE_CONFIG {
    
    	public $default = array(
    	
    	//******************************************//
    	
    		
    		'host' => 'localhost', // hier uw server
    		'login' => 'gebruikersnaam',
    		'password' => 'gebruikerswachtwoord',
    		'database' => 'databasenaam',
    		'port' => 3306, // hier uw serverpoort
    	
    	//*******************************************//
    	
    		'datasource' => 'Database/Mysql',
    		'persistent' => false,
    		'prefix' => '',
    		'encoding' => 'utf8'
    	);
    
    }
    
De webshop zou nu moeten werken. Eventueel kan er voorbeelddata geladen worden uit meegeleverde bestanden.


## Gebruikte tools & frameworks

*   [CakePHP](http://www.cakephp.org) - The rapid development PHP framework
*   [DebugKit](https://github.com/cakephp/debug_kit) - DebugKit provides a debugging toolbar and enhanced debugging tools for CakePHP applications.
*   [Aptana Studio 3](http://www.aptana.com/) - Build web applications quickly and easily using the industry’s leading web application IDE. Aptana Studio harnesses the flexibility of Eclipse and focuses it into a powerful web development engine.
*   [glyphicons](http://glyphicons.com/) - GLYPHICONS is a library of precisely prepared monochromatic icons and symbols, created with an emphasis on simplicity and easy orientation.
*   [Source Sans Pro](http://www.google.com/fonts/specimen/Source+Sans+Pro) - Source® Sans Pro, Adobe's first open source typeface family, was designed by Paul D. Hunt. It is a sans serif typeface intended to work well in user interfaces.
*   [Responsive Tabs](https://github.com/jellekralt/Responsive-Tabs) - This jQuery plugin provides responsive tab functionality. The tabs transform to an accordion when it reaches a CSS breakpoint.
*   [Initializr](http://www.initializr.com/) - Initializr is an HTML5 templates generator to help you getting started with a new project based on HTML5 Boilerplate. It generates for you a clean customizable template with just what you need to start!
*   [jQuery](http://jquery.com/) - jQuery is a fast, small, and feature-rich JavaScript library. It makes things like HTML document traversal and manipulation, event handling, animation, and Ajax much simpler with an easy-to-use API that works across a multitude of browsers. With a combination of versatility and extensibility, jQuery has changed the way that millions of people write JavaScript.
*   [Modernizr](http://modernizr.com/) - Modernizr is a JavaScript library that detects HTML5 and CSS3 features in the user’s browser.
*   [HTML5 Boilerplate](http://html5boilerplate.com/) - HTML5 Boilerplate helps you build fast, robust, and adaptable web apps or sites. Kick-start your project with the combined knowledge and effort of 100\. of developers, all in one little package.
*   [Respond.js](https://github.com/scottjehl/Respond) - The goal of this script is to provide a fast and lightweight (3kb minified / 1kb gzipped) script to enable responsive web designs in browsers that don't support CSS3 Media Queries - in particular, Internet Explorer 8 and under. It's written in such a way that it will probably patch support for other non-supporting browsers as well (more information on that soon)
*   [Minify](https://code.google.com/p/minify/) - Minify is a PHP5 app that helps you follow several of Yahoo!'s Rules for High Performance Web Sites. It combines multiple CSS or Javascript files, removes unnecessary whitespace and comments, and serves them with gzip encoding and optimal client-side cache headers.
*   [Stupid jQuery Table Sort](http://joequery.github.io/Stupid-Table-Plugin/) - This is a stupidly simple, absurdly lightweight jQuery table sorting plugin. As long as you understand basic JavaScript sorting, you can make this plugin do as much or as little as you want.
