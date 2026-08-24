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

### [3.9.0](https://github.com/pdir/mobilede-bundle/tree/3.9.0) – 2026-08-24

- [Added] New "Weight" field for the vehicle's curb weight.
- [Changed] Replaced `Connection::getSchemaManager()` with `Connection::createSchemaManager()` to ensure compatibility with Doctrine DBAL 4.
- [Changed] Updated the default "OffRoad" vehicle category label to "SUV/Geländewagen/Pickup".
- [Changed] Changed vehicle date formatting to display month/year (MM/YYYY) instead of the system date format.
- [Fixed] Fixed net price calculation
- [Fixed] Fixed display issues in the vehicle manager backend template, including the broken demo data import link
  [Fixed] Fixed incorrect icon display in the backend navigation
- [Removed] Removed the unused `price_vat_rating` field in favor of the existing `price_vat_rate` field.

### [3.8.1](https://github.com/pdir/mobilede-bundle/tree/3.8.1) – 2026-05-21

- [Fixed] CO₂ emissions are now correctly displayed even when the value is 0 (previously, zero values were not rendered)
- [Changed] Adjusted electric range output by removing the “EAER” label from translations to ensure a more consistent display across all vehicle types

### [3.8.0](https://github.com/pdir/mobilede-bundle/tree/3.8.0) – 2026-05-13

- [Added] Added support for mobile.de vehicle cost model data (fuel price, electricity price, energy costs, vehicle tax and CO₂ costs)
- [Changed] Updated `ce_mobilede_reader_redesign` template with cost model rendering and improved energy scale display
- [Changed] Updated energy efficiency scale rendering to include CO₂ class with discharged battery
- [Changed] Enhanced energy efficiency scale styling and visual presentation
- [Added] Added legal footnotes and references for WLTP consumption values and estimated CO₂ costs
- [Fixed] Fixed and completed English translations

### [3.7.1](https://github.com/pdir/mobilede-bundle/tree/3.7.1) – 2026-02-24

- [Changed] Adjusted emission_fuel_consumption_combined field to DECIMAL(5,2) UNSIGNED NULL
- [Fixed] Added `not-anchor` class to filter reset link to ensure compatibility with Eclipse theme
- [Fixed] Fixed mileage slider not displaying a value

### [3.7.0](https://github.com/pdir/mobilede-bundle/tree/3.7.0) – 2026-01-28

- [Changed] Refactor database to use new API endpoints
- [Changed] Improved and adapted mobile.de import (new specifics, rendering, updated mappings)
- [Changed] Updated templates, translations and reader views
- [Changed] Updated vehicle detail view styling (desktop & mobile)
- [Changed] Updated list view rendering and image handling (including manually added vehicles)
- [Changed] Updated emission and consumption data handling and rendering
- [Added] Multi-select support for radio and parking assistant fields
- [Fixed] Various styling issues (including Contao demo)
- [Changed] Cleanup: removed unused code and functions

## [3.6.0](https://github.com/pdir/mobilede-bundle/tree/3.6.0) – 2025-05-16

- [Added] Support for Contao 5.3 and higher
- [Added] New design for list and detail view
- [Removed] Support for Contao 4.4

## [3.5.2](https://github.com/pdir/mobilede-bundle/tree/3.5.2) – 2024-07-30

- [Fixed] Fix showing sorting field

## [3.5.1](https://github.com/pdir/mobilede-bundle/tree/3.5.1) – 2024-06-24

- [Fixed] Fix mobile range slider

## [3.5.0](https://github.com/pdir/mobilede-bundle/tree/3.5.0) – 2024-05-14

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
