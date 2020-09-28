<?php

declare(strict_types=1);

namespace Pdir\MobileDeBundle\Entity;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Pdir\MobileDeBundle\Annotation\Vehicle as Veh;

/**
 * @ORM\Entity(repositoryClass="Pdir\MobileDeBundle\Repository\VehicleRepository")
 * @ORM\Table(name="tl_vehicle")
 * @Annotation
 */
class Vehicle extends DcaDefault
{
    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;

    public const DELIVERY_COST_NOT_INCLUDED = 0;
    public const DELIVERY_COST_INCLUDED = 1;

    public const PRICE_NOT_VATABLE = 0;
    public const PRICE_VATABLE = 1;

    /**
     * @ORM\Column(name="published", type="smallint")
     * @Veh(name="published", mandatory=true, enum={
     *      "INACTIVE" = Vehicle::STATUS_INACTIVE,
     *      "ACTIVE" = Vehicle::STATUS_ACTIVE,
     * })
     *
     * @var int
     */
    public $published = self::STATUS_INACTIVE;

    /**
     * @ORM\Column(name="name", type="text")
     *
     * @var string
     */
    public $name = '';

    /**
     * @ORM\Column(name="alias", type="text")
     *
     * @var string
     */
    public $alias = '';

    /**
     * @ORM\ManyToOne(targetEntity="Pdir\MobileDeBundle\Entity\VehicleAccount", inversedBy="vehicles")
     * @ORM\JoinColumn(name="vehicle_account", referencedColumnName="id", onDelete="CASCADE")
     *
     * @var VehicleAccount
     */
    public $account = '';

    /**
     * @ORM\Column(name="dealer_price_amount", type="decimal", precision=10, scale=2, nullable=true)
     *
     * @var ?float
     */
    public $dealerPriceAmount;

    /**
     * @ORM\Column(name="consumer_price_amount", type="decimal", precision=10, scale=2, nullable=true)
     *
     * @var ?float
     */
    public $consumerPriceAmount;

    /**
     * @ORM\Column(name="price_included_delivery_costs", type="boolean", nullable=true)
     * @Veh(name="price_included_delivery_costs", enum={
     *      "INCLUDED" = Vehicle::DELIVERY_COST_INCLUDED,
     *      "NOTINCLUDED" = Vehicle::DELIVERY_COST_NOT_INCLUDED,
     * })
     *
     * @var bool|null
     */
    public $priceIncludedDeliveryCosts = self::DELIVERY_COST_NOT_INCLUDED;

    /**
     * @ORM\Column(name="price_vatable", type="boolean", nullable=true)
     * @Veh(name="price_vatable", enum={
     *      "VATABLE" = Vehicle::PRICE_VATABLE,
     *      "NOTVATABLE" = Vehicle::PRICE_NOT_VATABLE,
     * })
     *
     * @var bool|null
     */
    public $priceVatable = self::PRICE_NOT_VATABLE;

    /**
     * @ORM\Column(name="price_vat_rating", type="text")
     *
     * @var string
     */
    public $priceVatRating = '';

    /**
     * @ORM\Column(name="price_currency", type="text")
     *
     * @var string
     */
    public $priceCurrency = '';

    /**
     * @ORM\Column(name="price_rating", type="text")
     *
     * @var string
     */
    public $priceRating = '';

    /**
     * @ORM\Column(name="creation_date", type="datetime")
     *
     * @var \DateTime
     */
    public $creationDate;

    /**
     * @ORM\Column(name="modification_date", type="datetime")
     *
     * @var \DateTime
     */
    public $modificationDate;

    /**
     * @ORM\Column(name="vehicle_class", type="text")
     *
     * @var string
     */
    public $vehicleClass = '';

    /**
     * @ORM\Column(name="vehicle_category", type="text")
     *
     * @var string
     */
    public $vehicleCategory = '';

    /**
     * @ORM\Column(name="vehicle_make", type="text")
     *
     * @var string
     */
    public $vehicleMake = '';

    /**
     * @ORM\Column(name="vehicle_model", type="text")
     *
     * @var string
     */
    public $vehicleModel = '';

    /**
     * @ORM\Column(name="vehicle_model_description", type="text")
     *
     * @var string
     */
    public $vehicleModelDescription = '';

    /**
     * @ORM\Column(name="vehicle_free_text", type="text")
     *
     * @var string
     */
    public $vehicleFreeText = '';

    /**
     * @ORM\Column(name="vehicle_damage", type="text")
     *
     * @var string
     */
    public $vehicleDamage = '';

    /**
     * @ORM\Column(name="specifics_exterior_color", type="text")
     *
     * @var string
     */
    public $specificsExteriorColor = '';

    /**
     * @ORM\Column(name="specifics_metallic", type="text")
     *
     * @var string
     */
    public $specificsMetallic = '';

    /**
     * @ORM\Column(name="specifics_manufacturer_color_name", type="text")
     *
     * @var string
     */
    public $specificsManufacturerColorName = '';

    /**
     * @ORM\Column(name="specifics_mileage", type="text")
     *
     * @var string
     */
    public $specificsMileage = '';

    /**
     * @ORM\Column(name="specifics_exhaust_inspection", type="text")
     *
     * @var string
     */
    public $specificsExhaustInspection = '';

    /**
     * @ORM\Column(name="specifics_general_inspection", type="text")
     *
     * @var string
     */
    public $specificsGeneralInspection = '';

    /**
     * @ORM\Column(name="specifics_delivery_date", type="text")
     *
     * @var string
     */
    public $specificsDeliveryDate = '';

    /**
     * @ORM\Column(name="specifics_delivery_period", type="text")
     *
     * @var string
     */
    public $specificsDeliveryPeriod = '';

    /**
     * @ORM\Column(name="specifics_door_count", type="text")
     *
     * @var string
     */
    public $specificsDoorCount = '';

    /**
     * @ORM\Column(name="specifics_first_registration", type="text")
     *
     * @var string
     */
    public $specificsFirstRegistration = '';

    /**
     * @ORM\Column(name="specifics_emission_class", type="text")
     *
     * @var string
     */
    public $specificsEmissionClass = '';

    /**
     * @ORM\Column(name="specifics_emission_sticker", type="text")
     *
     * @var string
     */
    public $specificsEmissionSticker = '';

    /**
     * @ORM\Column(name="specifics_fuel", type="text")
     *
     * @var string
     */
    public $specificsFuel = '';

    /**
     * @ORM\Column(name="specifics_power", type="text")
     *
     * @var string
     */
    public $specificsPower = '';

    /**
     * @ORM\Column(name="specifics_hsn", type="text")
     *
     * @var string
     */
    public $specificsHsn = '';

    /**
     * @ORM\Column(name="specifics_tsn", type="text")
     *
     * @var string
     */
    public $specificsTsn = '';

    /**
     * @ORM\Column(name="specifics_schwacke_code", type="text")
     *
     * @var string
     */
    public $specificsSchwackeCode = '';

    /**
     * @ORM\Column(name="specifics_gearbox", type="text")
     *
     * @var string
     */
    public $specificsGearbox = '';

    /**
     * @ORM\Column(name="specifics_climatisation", type="text")
     *
     * @var string
     */
    public $specificsClimatisation = '';

    /**
     * @ORM\Column(name="specifics_licensed_weight", type="text")
     *
     * @var string
     */
    public $specificsLicensedWeight = '';

    /**
     * @ORM\Column(name="specifics_axles", type="text")
     *
     * @var string
     */
    public $specificsAxles = '';

    /**
     * @ORM\Column(name="specifics_load_capacity", type="text")
     *
     * @var string
     */
    public $specificsLoadCapacity = '';

    /**
     * @ORM\Column(name="specifics_num_seats", type="text")
     *
     * @var string
     */
    public $specificsNumSeats = '';

    /**
     * @ORM\Column(name="specifics_operating_hours", type="text")
     *
     * @var string
     */
    public $specificsOperatingHours = '';

    /**
     * @ORM\Column(name="specifics_installation_height", type="text")
     *
     * @var string
     */
    public $specificsInstallationHeight = '';

    /**
     * @ORM\Column(name="specifics_lifting_capacity", type="text")
     *
     * @var string
     */
    public $specificsLiftingCapacity = '';

    /**
     * @ORM\Column(name="specifics_lifting_height", type="text")
     *
     * @var string
     */
    public $specificsLiftingHeight = '';

    /**
     * @ORM\Column(name="specifics_construction_year", type="text")
     *
     * @var string
     */
    public $specificsConstructionYear = '';

    /**
     * @ORM\Column(name="specifics_construction_date", type="text")
     *
     * @var string
     */
    public $specificsConstructionDate = '';

    /**
     * @ORM\Column(name="specifics_cubic_capacity", type="text")
     *
     * @var string
     */
    public $specificsCubicCapacity = '';

    /**
     * @ORM\Column(name="specifics_driving_mode", type="text")
     *
     * @var string
     */
    public $specificsDrivingMode = '';

    /**
     * @ORM\Column(name="specifics_driving_cab", type="text")
     *
     * @var string
     */
    public $specificsDrivingCab = '';

    /**
     * @ORM\Column(name="specifics_condition", type="text")
     *
     * @var string
     */
    public $specificsCondition = '';

    /**
     * @ORM\Column(name="specifics_usage_type", type="text")
     *
     * @var string
     */
    public $specificsUsageType = '';

    /**
     * @ORM\Column(name="specifics_wheel_formula", type="text")
     *
     * @var string
     */
    public $specificsWheelFormula = '';

    /**
     * @ORM\Column(name="specifics_number_of_bunks", type="text")
     *
     * @var string
     */
    public $specificsNumberOfBunks = '';

    /**
     * @ORM\Column(name="specifics_hydraulic_installation", type="text")
     *
     * @var string
     */
    public $specificsHydraulicInstallation = '';

    /**
     * @ORM\Column(name="specifics_europallet_storage_spaces", type="text")
     *
     * @var string
     */
    public $specificsEuropalletStorageSpaces = '';

    /**
     * @ORM\Column(name="specifics_dimension_length", type="text")
     *
     * @var string
     */
    public $specificsDimensionLength = '';

    /**
     * @ORM\Column(name="specifics_dimension_width", type="text")
     *
     * @var string
     */
    public $specificsDimensionWidth = '';

    /**
     * @ORM\Column(name="specifics_dimension_height", type="text")
     *
     * @var string
     */
    public $specificsDimensionHeight = '';

    /**
     * @ORM\Column(name="specifics_shipping_volume", type="text")
     *
     * @var string
     */
    public $specificsShippingVolume = '';

    /**
     * @ORM\Column(name="specifics_loading_space_length", type="text")
     *
     * @var string
     */
    public $specificsLoadingSpaceLength = '';

    /**
     * @ORM\Column(name="specifics_loading_space_width", type="text")
     *
     * @var string
     */
    public $specificsLoadingSpaceWidth = '';

    /**
     * @ORM\Column(name="specifics_identification_number", type="text")
     *
     * @var string
     */
    public $specificsIdentificationNumber = '';

    /**
     * @ORM\Column(name="specifics_interior_color", type="text")
     *
     * @var string
     */
    public $specificsInteriorColor = '';

    /**
     * @ORM\Column(name="specifics_interior_type", type="text")
     *
     * @var string
     */
    public $specificsInteriorType = '';

    /**
     * @ORM\Column(name="specifics_airbag", type="text")
     *
     * @var string
     */
    public $specificsAirbag = '';

    /**
     * @ORM\Column(name="specifics_number_of_previous_owners", type="text")
     *
     * @var string
     */
    public $specificsNumberOfPreviousOwners = '';

    /**
     * @ORM\Column(name="specifics_countryVersion", type="text")
     *
     * @var string
     */
    public $specificsCountryVersion = '';

    /**
     * @ORM\Column(name="specifics_videoUrl", type="text")
     *
     * @var string
     */
    public $specificsVideoUrl = '';

    /**
     * @ORM\Column(name="specifics_parking_assistants", type="text")
     *
     * @var string
     */
    public $specificsParkingAssistants = '';

    /**
     * @ORM\Column(name="specifics_speed_control", type="text")
     *
     * @var string
     */
    public $specificsSpeedControl = '';

    /**
     * @ORM\Column(name="specifics_radio", type="text")
     *
     * @var string
     */
    public $specificsRadio = '';

    /**
     * @ORM\Column(name="specifics_daytime_running_lamps", type="text")
     *
     * @var string
     */
    public $specificsDaytimeRunningLamps = '';

    /**
     * @ORM\Column(name="specifics_sliding_door_type", type="text")
     *
     * @var string
     */
    public $specificsSlidingDoorType = '';

    /**
     * @ORM\Column(name="specifics_headlight_type", type="text")
     *
     * @var string
     */
    public $specificsHeadlightType = '';

    /**
     * @ORM\Column(name="specifics_bending_lights_type", type="text")
     *
     * @var string
     */
    public $specificsBendingLightsType = '';

    /**
     * @ORM\Column(name="specifics_breakdown_service", type="text")
     *
     * @var string
     */
    public $specificsBreakdownService = '';

    /**
     * @ORM\Column(name="specifics_battery", type="text")
     *
     * @var string
     */
    public $specificsBattery = '';

    /**
     * @ORM\Column(name="specifics_trailer_coupling_type", type="text")
     *
     * @var string
     */
    public $specificsTrailerCouplingType = '';

    /**
     * @ORM\Column(name="specifics_trim_line", type="text")
     *
     * @var string
     */
    public $specificsTrimLine = '';

    /**
     * @ORM\Column(name="specifics_model_range", type="text")
     *
     * @var string
     */
    public $specificsModelRange = '';

    /**
     * @ORM\Column(name="specifics_first_models_production_date", type="text")
     *
     * @var string
     */
    public $specificsFirstModelsProductionDate = '';

    /**
     * @ORM\Column(name="specifics_battery_capacity", type="text")
     *
     * @var string
     */
    public $specificsBatteryCapacity = '';

    /**
     * @ORM\Column(name="emission_fuel_consumption_envkv_compliant", type="text")
     *
     * @var string
     */
    public $emissionFuelConsumptionEnvkvCompliant = '';

    /**
     * @ORM\Column(name="emission_fuel_consumption_energy_efficiency_class", type="text")
     *
     * @var string
     */
    public $emissionFuelConsumptionEnergyEfficiencyClass = '';

    /**
     * @ORM\Column(name="emission_fuel_consumption_co2_emission", type="text")
     *
     * @var string
     */
    public $emissionFuelConsumptionCo2Emission = '';

    /**
     * @ORM\Column(name="emission_fuel_consumption_inner", type="text")
     *
     * @var string
     */
    public $emissionFuelConsumptionInner = '';

    /**
     * @ORM\Column(name="emission_fuel_consumption_outer", type="text")
     *
     * @var string
     */
    public $emissionFuelConsumptionOuter = '';

    /**
     * @ORM\Column(name="emission_fuel_consumption_combined", type="text")
     *
     * @var string
     */
    public $emissionFuelConsumptionCombined = '';

    /**
     * @ORM\Column(name="emission_fuel_consumption_petrol_type", type="text")
     *
     * @var string
     */
    public $emissionFuelConsumptionPetrolType = '';

    /**
     * @ORM\Column(name="emission_fuel_consumption_combined_power_consumption", type="text")
     *
     * @var string
     */
    public $emissionFuelConsumptionCombinedPowerConsumption = '';

    /**
     * @ORM\Column(name="emission_fuel_consumption_unit", type="text")
     *
     * @var string
     */
    public $emissionFuelConsumptionUnit = '';

    /**
     * @ORM\Column(name="images", type="blob")
     *
     * @var string
     */
    public $images = '';

    /**
     * @ORM\Column(name="api_images", type="text")
     *
     * @var string
     */
    public $apiImages = '';

    /**
     * @ORM\Column(name="orderSRC", type="blob")
     *
     * @var string
     */
    public $orderSRC = '';

    /**
     * @ORM\Column(name="features", type="text")
     *
     * @var string
     */
    public $features = '';
}
