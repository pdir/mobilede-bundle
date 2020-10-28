Mobile.de Inserate für Contao
=============================
Mobile.de Ads for Contao
==================================

[![Latest Stable Version](https://poser.pugx.org/pdir/mobilede-bundle/v/stable)](https://packagist.org/packages/pdir/mobilede-bundle)
[![Total Downloads](https://poser.pugx.org/pdir/mobilede-bundle/downloads)](https://packagist.org/packages/pdir/mobilede-bundle)
[![License](https://poser.pugx.org/pdir/mobilede-bundle/license)](https://packagist.org/packages/pdir/mobilede-bundle)

Über
----

Eine Erweiterung mit Filtern und Funktionen um den mobile.de Fahrzeugbestand
auf der eigenen Website anzuzeigen.<br>
Alle Inserate werden direkt aus der mobile.de* API ausgelesen und in der Erweiterung
übersichtlich dargestellt. Umfangreiche Filter- & Sortierungsfunktionen runden die
Listenansicht ab. Die Detailansicht enthält alle Fahrzeuginformationen und einen schlanken
Produkt-Slider. Auf Wunsch können auch zusätzliche Funktionen integriert werden.
Fragen Sie uns an.

Ihre Vorteile
* Listenansicht mit umfangreichen Filter- und Sortierungsfunktionen
* Detailansicht mit Contao Bildslider
* Empfohlenes Objekt
* Automatischer Abgleich der Fahrzeuge über mobile.de* API
* Templates und Design können auf gewohnte "Contao Art" angepasst werden
* garantierte Unterstützung der letzten bzw. aktuellen Contao LTS Version

Mehr Informationen
https://pdir.de/mobile-de-integration-fuer-contao-cms.html

About
-----

An extension with filters and functions around the mobile.de vehicle stock
on your own website.<br>
All ads will be read directly from the mobile.de * API and will clearly presented in extension.
Extensive filter & sort functions complete the List view. The detailed view
contains all vehicle information and a lean one
Product Slider. On request, additional functions can be integrated.
Ask us.

Your advantages
* List view with extensive filtering and sorting functions
* Detail view with Contao picture slider
* Recommended object
* Automatic comparison of vehicles via mobile.de * API
* Templates and design can be adapted to the usual "Contao Art"
* Guaranteed support of the latest or current version of Contao LTS

More information
https://pdir.de/mobile-de-integration-fuer-contao-cms.html

Screenshot
-----------

![screenshot](https://user-images.githubusercontent.com/10244240/36735287-1c4633c0-1bd6-11e8-9771-bbdf89f2a1f7.png)

System requirements
-------------------

* [Contao 3](https://contao.org/de/download.html)
* [Contao 4](https://github.com/contao/managed-edition) or higher

Installation & Configuration
----------------------------

see documentation at https://docs.pdir.de/mobilede/mobilede_inserate.html

Demo
----

https://demo.pdir.de/mobile-de-inserate-demo.html

See this Extension in the Contao Extension-Repository
-----------------------------------------------------

https://contao.org/de/erweiterungsliste/view/pdirMobileDe.10000099.de.html


License
-------
This is a commercial extension for Contao Open Source CMS<br>
You can buy a license at https://pdir.de/mobilede<br>
2017-2018 pdir GmbH - All-rights-reserved<br>


ToDo
---------------


History
-------
- Version 1.0.12 // Behebt Probleme bei der Auswahl von individuellen Templates und beim ausblenden der Filter
- Version 1.0.5 // Unterstützung von Contao 4 und des Contao Manager
- Version 1.0.2 // Ausgabe der mobile.de API Fehlermeldungen direkt auf der Seite
- Version 1.0.1 // Diese Version behebt kleinere Fehler in der Listenansicht
- Version 1.0.0 // Erste Version für Contao 3.5 veröffentlicht

*mobile.de sowie das mobile.de Logo sind eingetragene Warenzeichen einer Drittpartei und stehen in keiner Verbindung zur pdir GmbH oder der mobile.de* Erweiterung für Contao. Die Erweiterung verwendet die mobile.de* API zum Import der Fahrzeugdaten.
DIES IST EINE DEMO VERSION, DIE DURCH DEN KAUF EINER LIZENZ ZUR VOLLVERSION UMGEWANDELT WERDEN KANN.


Developing & Pull Request
-------------------------
Run the PHP-CS-Fixer and the unit tests before you make a pull request to the bundle:

    vendor/bin/php-cs-fixer fix -v
    vendor/bin/phpunit

Generate getter and setter

    vendor/app/console doctrine:generate:entities Pdir/MobileDeBundle/Entity/Ad

Run cypress tests against demo data

    npm run cypress:open or yarn run cypress open


Bildnachweise für Demodaten
-------------------------

* Mercedes AMG Sportwagen / amg-1880381_1280.jpg: [PIRO4D](https://pixabay.com/de/users/PIRO4D)@[Pixabay](https://pixabay.com/de/illustrations/amg-mercedes-auto-sls-sportwagen-1880381/)
* Audi A8 Sportwagen rot / audi-1890494_1280.jpg: [PIRO4D](https://pixabay.com/de/users/PIRO4D)@[Pixabay](https://pixabay.com/de/illustrations/audi-sportwagen-auto-a8-rot-1890494/)
* Citroen Ente / auto-3091234_1280.jpg: [GuentherDillingen](https://pixabay.com/de/users/GuentherDillingen)@[Pixabay](https://pixabay.com/de/photos/auto-oldtimer-citroen-ente-fenster-3091234/)
* Mazda weiß / automobile-1840414_1920.jpg: [Pexels](https://pixabay.com/de/users/Pexels)@[Pixabay](https://pixabay.com/de/photos/automobil-auto-mazda-stra%C3%9Fe-1840414/)
* VW Käfer rot / automotive-1846910_1280.jpg: [Pexels](https://pixabay.com/de/users/Pexels)@[Pixabay](https://pixabay.com/de/photos/automobil-vw-k%C3%A4fer-auto-stadt-1846910/)
* BMW blau / bmw-768688_1280.jpg: [Free-Photos](https://pixabay.com/de/users/Photos)@[Pixabay](https://pixabay.com/de/photos/bmw-auto-fahrzeug-transport-stra%C3%9Fe-768688/)
* BMW Sportwagen schwarz / bmw-918408_1280.jpg: [Free-Photos](https://pixabay.com/de/users/Free-Photos)@[Pixabay](https://pixabay.com/de/photos/bmw-auto-front-sportwagen-918408/)
* BMW Coupe Oldtimer / bmw-3807243_1280.jpg: [emkanicepic](https://pixabay.com/de/users/emkanicepic)@[Pixabay](https://pixabay.com/de/photos/bmw-coupe-oldtimer-auto-sportwagen-3807243/)
* VW Käfer grau / city-1284508_1280.jpg: [Pexels](https://pixabay.com/de/users/Pexels)@[Pixabay](https://pixabay.com/de/photos/stadt-auto-fahrzeug-jahrgang-1284508/)
* Jaguar Sportwagen / jaguar-1256572_1280.jpg: [Various-Photography](https://pixabay.com/de/users/Various-Photography)@[Pixabay](https://pixabay.com/de/photos/jaguar-sportwagen-schnell-automobil-1256572/)
* Trabant mit Wohnwagen / oldtimer-1195112_1280.jpg: [bernswaelz](https://pixabay.com/de/users/bernswaelz)@[Pixabay](https://pixabay.com/de/photos/oldtimer-alte-autos-trabbi-trabant-1195112/)
* Seat Ibiza / seat-2266976_1280.jpg: [mettmett](https://pixabay.com/de/users/mettmett)@[Pixabay](https://pixabay.com/de/photos/seat-ibiza-sc-de-sport-stadtauto-2266976/)
* Jaguar XJ8 / car-2182792_1920.jpg: [dgeldart](https://pixabay.com/de/users/dgeldart)@[Pixabay](https://pixabay.com/de/photos/auto-jaguar-xj8-2182792/)
* Ford Sportwagen / car-3072403_1920.jpg: [Toby_Parsons](https://pixabay.com/de/users/Toby_Parsons)@[Pixabay](https://pixabay.com/de/photos/auto-fahrzeug-antrieb-3072403/)
