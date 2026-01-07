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
2017-2022 pdir GmbH - All-rights-reserved<br>


*mobile.de sowie das mobile.de Logo sind eingetragene Warenzeichen einer Drittpartei und stehen in keiner Verbindung zur pdir GmbH oder der mobile.de* Erweiterung für Contao. Die Erweiterung verwendet die mobile.de* API zum Import der Fahrzeugdaten.
DIES IST EINE DEMO VERSION, DIE DURCH DEN KAUF EINER LIZENZ ZUR VOLLVERSION UMGEWANDELT WERDEN KANN.


Developing & Pull Request
-------------------------
Run the PHP-CS-Fixer and the unit tests before you make a pull request to the bundle:

    vendor/bin/ecs check src tests
    vendor/bin/phpstan analyse
    vendor/bin/phpunit --colors=always

Run cypress tests against demo data

    npm run cypress:open or yarn run cypress open


Contao Themes
-------------------------

| [![MATE Theme](https://contao-themes.net/files/contao-themes-net/screenshots/mate%20theme/fahrzeugmanager/mate_fahrzeugmanager_1.png)](https://contao-themes.net/theme-detail/mate.html) | ![Platzhalter](https://contao-themes.net/files/contao-themes-net/screenshots/platzhalter.png) | ![Platzhalter](https://contao-themes.net/files/contao-themes-net/screenshots/platzhalter.png) |
|:---:|:---:|:---:|
| [**MATE Theme**](https://contao-themes.net/theme-detail/mate.html) <br> [Demo](https://mate.pdir.de/fahrzeuge/vertikales-layout.html) |  |  |
