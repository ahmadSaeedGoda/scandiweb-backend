<?php
/**
 * Database Connection Boot
 * php version 7.4.0
 * 
 * @category Database
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/DatabaseManager
 */

namespace Scandiweb\Database;

use Illuminate\Database\Capsule\Manager as Capsule;
use Scandiweb\Database\Configuration\Configuration;

/**
 * Database Connection Boot
 * php version 7.4.0
 * 
 * @category Database
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/DatabaseManager
 * @final
 * @uses     Capsule::addConnection
 * @uses     Capsule::setAsGlobal
 * @uses     Capsule::bootEloquent
 */
final class DatabaseManager
{
    /**
     * Acts as the very outer container of all DB functionalities
     * 
     * @var Capsule
     */
    private Capsule $_capsule;

    /**
     * To retrieve/get the configurations attributes of different/multi DB Drivers
     * 
     * @var array
     */
    private array $_driversConfig = [];

    /**
     * To retrieve/get the configurations attributes of the MYSQL Driver
     */
    private const MYSQL_CONFIG = 'mysql';

    /**
     * Create instance
     */
    public function __construct(Configuration $config)
    {
        $this->_init($config);
        $this->_boot();
    }

    /**
     * Initialize required props of obj
     *
     * @return void
     */
    private function _init(Configuration $config)
    {
        $this->_capsule = new Capsule;
        $this->_driversConfig[self::MYSQL_CONFIG] = $config;
    }

    /**
     * As per Illuminate docs, add connection first, then boot.
     * Setting as Global is optional though.
     *
     * @return void
     */
    private function _boot()
    {
        $mysqlConfig = $this->_getMysqlConfig();

        $this->_capsule->addConnection(
            [
                "driver"     =>  $mysqlConfig->getDatabaseDriver(),
                "host"       =>  $mysqlConfig->getHost(),
                "port"       =>  $mysqlConfig->getPort(),
                "database"   =>  $mysqlConfig->getDatabaseName(),
                "username"   =>  $mysqlConfig->getDatabaseUsername(),
                "password"   =>  $mysqlConfig->getDatabasePassword(),
            ]
        );

        $this->_capsule->bootEloquent();
    }

    /**
     * Gets the required Config Object for MYSQL Driver from previously registered
     * or Creates a new one
     *
     * @return Configuration
     */
    private function _getMysqlConfig(): Configuration
    {
        return $this->_driversConfig[self::MYSQL_CONFIG];
    }
}
