# Changelog

[//]: <> (
Types of changes
    Added for new Addeds.
    Changed for changes in existing functionality.
    Deprecated for soon-to-be removed Addeds.
    Removed for now removed Addeds.
    Fixed for any bug fixes.
    Security in case of vulnerabilities.
)

## [3.5.0](https://github.com/pdir/mobilede-bundle/tree/3.5.0) – 2024-05-13

- [Added] Add new fields emission, consumption and hybrid_plugin

## [3.4.0](https://github.com/pdir/mobilede-bundle/tree/3.4.0) – 2024-02-08

- [Added] Add option to combine filters
- [Added] Add option to show gross and net price
- [Fixed] Fix warnings in reader template
- [Fixed] Hide pseudo price if price is null
- [Changed] Change alias to mandatory and change translations

## [3.3.10](https://github.com/pdir/mobilede-bundle/tree/3.3.10) – 2024-01-17

- [Added] Add new field for loading space height
- [Added] Add missing emission and consumption fields
- [Fixed] Fix warning when creating a vehicle

## [3.3.9](https://github.com/pdir/mobilede-bundle/tree/3.3.9) – 2023-04-18

- [Added] Add seller inventory key in template
- [Added] Add energy class A++ and A+++

## [3.3.8](https://github.com/pdir/mobilede-bundle/tree/3.3.8) – 2023-03-06

- [Fixed] display problem of the gallery in the backend

## [3.3.7](https://github.com/pdir/mobilede-bundle/tree/3.3.7) – 2023-02-28

- [Added] Add placeholder image
- [Fixed] Fix vehicle class value and label
- [Fixed] Fix vehicle model filter for models which contain `'` or `.` (e.g. Kia cee'd or VW ID.Buzz)
- [Fixed] Remove duplicate images
- [Fixed] Fix error when vehicle has no images
- [Fixed] Fix showing unpublished vehicles
- [Fixed] Remove warnings

## [3.3.6](https://github.com/pdir/mobilede-bundle/tree/3.3.6) – 2023-02-21

- [Fixed] Check permissions return error in backend vehicle list (contao 4.9)
- [Changed] load css and js sources locally

## [3.3.5](https://github.com/pdir/mobilede-bundle/tree/3.3.5) – 2023-01-31

- [Fixed] ads with no images return false on api request

## [3.3.4](https://github.com/pdir/mobilede-bundle/tree/3.3.4) – 2022-12-07

- [Added] Add fallback for images
- [Added] Add permission check in button callback
- [Changed] Sort accounts
- [Changed] Published callback for accounts and vehicles
- [Changed] Change reader template to show seller data (replace `['value']` with `['@value']` and replace `$this->ad['seller']['logo-image']` with `$this->ad['seller']['logo-image']['representation']`)

## [3.3.3](https://github.com/pdir/mobilede-bundle/tree/3.3.3) – 2022-09-23

- [Added] add support for PHP 8
- [Changed] change default value of field pdirVehicleFilterByAccount
- [Changed] use new vehicle fields in template
- [Changed] refactor dca callbacks
- [Fixed] fix assets dir (use web or public)
- [Fixed] fix sql error on create account
- [Fixed] fix filter only view
- [Fixed] fix import with multiple accounts
- [Removed] remove all corner fields in dca
- [Removed] remove unused feature tag

## [3.3.2](https://github.com/pdir/mobilede-bundle/tree/3.3.2) – 2022-08-09

- [Fixed] account creation
- [Fixed] fix enabled button

## [3.3.1](https://github.com/pdir/mobilede-bundle/tree/3.3.1) – 2022-08-02

- [Fixed] fix demo data for Contao 4.13

## [3.3.0](https://github.com/pdir/mobilede-bundle/tree/3.3.0) – 2022-07-27

- [Changed] add seller info as json
- [Added] add new WLTP data [Information on Worldwide harmonized Light Duty Test Procedure](https://de.wikipedia.org/wiki/Worldwide_harmonized_Light_vehicles_Test_Procedure)
- [Added] add xxl image in detail view
- [Fixed] fix prices in dca for database schema update
- [Fixed] formatDate error in reader element
- [Fixed] Euro6D-TEMP in selection field

## [3.2.1](https://github.com/pdir/mobilede-bundle/tree/3.2.1) – 2021-12-02

- [Changed] set php version higher than 8.0

## [3.2.0](https://github.com/pdir/mobilede-bundle/tree/3.2.0) – 2021-10-22

- [Added] add pseudo price
- [Added] add vehicles to sitemap.xml
- [Added] add vehicle_model as filter
- [Added] add checkbox to show all filters expanded by default
- [Fixed] fix date format
- [Fixed] rename syscara fields for api sync

## [3.1.0](https://github.com/pdir/mobilede-bundle/tree/3.1.0) – 2021-06-30

- [Added] add energy class label and meta data in reader template

## [3.0.0](https://github.com/pdir/mobilede-bundle/tree/3.0.0) – 2021-06-02

- [Added] add new filters
- [Added] use free version for vehicle management
- [Added] add php 8 support
- [Changed] set contao 4.9 as minimum requirement

## [2.6.6](https://github.com/pdir/mobilede-bundle/tree/2.6.6) – 2020-10-26

- [Fixed] wrong array value
- [Fixed] remove unwanted php warnings in debug mode

## [2.6.5](https://github.com/pdir/mobilede-bundle/tree/2.6.5) – 2021-10-26

- [Added] recommendations added

## [2.6.4](https://github.com/pdir/mobilede-bundle/tree/2.6.4) – 2021-07-21

- [Fixed] fix image order

## [2.6.3](https://github.com/pdir/mobilede-bundle/tree/2.6.3) – 2021-07-20

- [Added] add fields for listing template

## [2.6.2](https://github.com/pdir/mobilede-bundle/tree/2.6.2) – 2021-07-17

- [Fixed] demo import

## [2.6.1](https://github.com/pdir/mobilede-bundle/tree/2.6.1) – 2021-06-15

- [Fixed] fix date
- [Added] update css
- [Fixed] fix image import

## [2.6.0](https://github.com/pdir/mobilede-bundle/tree/2.6.0) – 2021-04-14

- [Added] add support for multiple accounts
