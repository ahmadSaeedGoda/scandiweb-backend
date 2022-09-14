<?php
/**
 * Database Configurations
 * php version 7.4.0
 * 
 * @category Database
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/Configuration
 */

namespace Scandiweb\Database\Configuration;

/**
 * Database Configuration Class
 * php version 7.4.0
 * 
 * @category Database
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/Configuration
 */
class Configuration
{
    protected string    $databaseDriver;
    protected string    $host = 'localhost';
    protected int       $port = 3306;
    protected string    $databaseName;
    protected string    $databaseUsername;
    protected string    $databasePassword;
    protected ?string   $unix_socket;
    protected ?string   $charset;
    protected ?string   $collation;
    protected ?string   $timezone;
    protected ?array    $modes;
    protected ?string   $strict;
    protected array     $driverOptions = [];

    /**
     * Create Object that carries all configs of DB
     * 
     * @param string      $databaseDriver   e.g mysql(Engine)
     * @param string      $host             e.g localhost(URL where DB is installed)
     * @param int         $port             e.g 3306
     * @param string      $databaseName     e.g Name of DB Instance
     * @param string      $databaseUsername e.g admin
     * @param string      $databasePassword e.g secret
     * @param string|null $unix_socket      e.g /var/run/mysqld/mysql.sock
     * @param string|null $charset          e.g utf8mb4
     * @param string|null $collation        e.g utf8mb4_0900_ai_ci
     * @param string|null $timezone         e.g "+00:00"
     * @param array|null  $modes            e.g ALLOW_INVALID_DATES
     * @param string|null $strict           e.g 'STRICT_TRANS_TABLES' or ''
     * @param array       $driverOptions    e.g --ssl
     */
    public function __construct(
        ?string $databaseDriver,
        ?string $host,
        ?int $port,
        ?string $databaseName,
        ?string $databaseUsername,
        ?string $databasePassword,
        ?string $unix_socket = null,
        ?string $charset = null,
        ?string $collation = null,
        ?string $timezone = null,
        ?array $modes = null,
        ?string $strict = null,
        array $driverOptions = []
    ) {
        $this->databaseDriver   = $databaseDriver;
        $this->host             = $host;
        $this->port             = $port;
        $this->databaseName     = $databaseName;
        $this->databaseUsername = $databaseUsername;
        $this->databasePassword = $databasePassword;
        $this->unix_socket      = $unix_socket;
        $this->charset          = $charset;
        $this->collation        = $collation;
        $this->timezone         = $timezone;
        $this->modes            = $modes;
        $this->strict           = $strict;
        $this->driverOptions    = $driverOptions;
    }

    /**
     * Getter for DatabaseDriver
     *
     * @return string|null
     */
    function getDatabaseDriver(): ?string
    {
        return $this->databaseDriver;
    }

    /**
     * Getter for Host
     *
     * @return string|null
     */
    function getHost(): ?string
    {
        return $this->host;
    }

    /**
     * Getter for Port
     *
     * @return integer|null
     */
    function getPort(): ?int
    {
        return $this->port;
    }

    /**
     * Getter for DatabaseName
     *
     * @return string|null
     */
    function getDatabaseName(): ?string
    {
        return $this->databaseName;
    }

    /**
     * Getter for DatabaseUsername
     *
     * @return string|null
     */
    function getDatabaseUsername(): ?string
    {
        return $this->databaseUsername;
    }

    /**
     * Getter for DatabasePassword
     *
     * @return string|null
     */
    function getDatabasePassword(): ?string
    {
        return $this->databasePassword;
    }

    /**
     * Getter for Socket
     *
     * @return string|null
     */
    function getSocket(): ?string
    {
        return $this->unix_socket;
    }

    /**
     * Getter for Charset
     *
     * @return string|null
     */
    function getCharset(): ?string
    {
        return $this->charset;
    }

    /**
     * Getter for Collation
     *
     * @return string|null
     */
    function getCollation(): ?string
    {
        return $this->collation;
    }

    /**
     * Getter for Timezone
     *
     * @return string|null
     */
    function getTimezone(): ?string
    {
        return $this->timezone;
    }

    /**
     * Getter for Modes
     *
     * @return array|null
     */
    function getModes(): ?array
    {
        return $this->modes;
    }

    /**
     * Getter for Strict
     *
     * @return string|null
     */
    function getStrict(): ?string
    {
        return $this->strict;
    }

    /**
     * Getter for DriverOptions
     *
     * @return array
     */
    function getDriverOptions(): array
    {
        return $this->driverOptions;
    }

    /**
     * Setter For Socket
     *
     * @param string $unix_socket e.g /var/run/mysqld/mysql.sock
     * 
     * @return Configuration
     */
    function setSocket(string $unix_socket): Configuration
    {
        $this->unix_socket = $unix_socket;
        return $this;
    }

    /**
     * Setter For DatabaseDriver
     *
     * @param string $databaseDriver e.g mysql(Engine)
     * 
     * @return Configuration
     */
    function setDatabaseDriver(string $databaseDriver): Configuration
    {
        $this->databaseDriver = $databaseDriver;
        return $this;
    }

    /**
     * Setter For Host
     *
     * @param string $host e.g localhost(URL where DB is installed)
     * 
     * @return Configuration
     */
    function setHost(string $host): Configuration
    {
        $this->host = $host;
        return $this;
    }

    /**
     * Setter For Port
     *
     * @param integer $port e.g 3306
     * 
     * @return Configuration
     */
    function setPort(int $port): Configuration
    {
        $this->port = $port;
        return $this;
    }

    /**
     * Setter For DatabaseName
     *
     * @param string $databaseName e.g Name of DB Instance
     * 
     * @return Configuration
     */
    function setDatabaseName(string $databaseName): Configuration
    {
        $this->databaseName = $databaseName;
        return $this;
    }

    /**
     * Setter For DatabaseUsername
     *
     * @param string $databaseUsername e.g admin
     * 
     * @return Configuration
     */
    function setDatabaseUsername(string $databaseUsername): Configuration
    {
        $this->databaseUsername = $databaseUsername;
        return $this;
    }

    /**
     * Setter For DatabasePassword
     *
     * @param string $databasePassword e.g secret
     * 
     * @return Configuration
     */
    function setDatabasePassword(string $databasePassword): Configuration
    {
        $this->databasePassword = $databasePassword;
        return $this;
    }

    /**
     * Setter For Charset
     *
     * @param string $charset e.g utf8mb4
     * 
     * @return Configuration
     */
    function setCharset(string $charset): Configuration
    {
        $this->charset = $charset;
        return $this;
    }

    /**
     * Setter For Collation
     *
     * @param string $collation e.g utf8mb4_0900_ai_ci
     * 
     * @return Configuration
     */
    function setCollation(string $collation): Configuration
    {
        $this->collation = $collation;
        return $this;
    }

    /**
     * Setter For Timezone
     *
     * @param string $timezone e.g "+00:00"
     * 
     * @return Configuration
     */
    function setTimezone(string $timezone): Configuration
    {
        $this->timezone = $timezone;
        return $this;
    }

    /**
     * Setter For Modes
     *
     * @param array $modes e.g ALLOW_INVALID_DATES
     * 
     * @return Configuration
     */
    function setModes(array $modes): Configuration
    {
        $this->modes = $modes;
        return $this;
    }

    /**
     * Setter For Strict
     *
     * @param string $strict e.g 'STRICT_TRANS_TABLES' or ''
     * 
     * @return Configuration
     */
    function setStrict(string $strict): Configuration
    {
        $this->strict = $strict;
        return $this;
    }

    /**
     * Setter For DriverOptions
     *
     * @param array $driverOptions e.g [--ssl, ...]
     * 
     * @return Configuration
     */
    function setDriverOptions(array $driverOptions): Configuration
    {
        $this->driverOptions = $driverOptions;
        return $this;
    }
}
