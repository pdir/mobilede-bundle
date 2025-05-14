<?php

declare(strict_types=1);

/*
 * mobile.de bundle for Contao Open Source CMS
 *
 * Copyright (c) 2025 pdir / digital agentur // pdir GmbH
 *
 * @package    mobilede-bundle
 * @link       https://pdir.de/mobilede.html
 * @license    proprietary / pdir license - All-rights-reserved - commercial extension
 * @author     Mathias Arzberger <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\MobileDeBundle\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;

class VehicleMigration extends AbstractMigration
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->getSchemaManager();

        // If the database table itself does not exist we should do nothing
        if (!$schemaManager->tablesExist(['tl_mobile_ad'])) {
            return false;
        }

        return true;
    }

    public function run(): MigrationResult
    {
        $stmt = $this->connection->prepare('RENAME TABLE tl_mobile_ad TO tl_vehicle');

        $stmt->execute();

        $stmt = $this->connection->prepare('ALTER TABLE tl_vehicle RENAME COLUMN ad_id TO vehicle_id');

        $stmt->execute();

        return new MigrationResult(
            true,
            'Table tl_mobile_ad renamed to tl_vehicle and column ad_id renamed to vehicle_id'
        );
    }
}
