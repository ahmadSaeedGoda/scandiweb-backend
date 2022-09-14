<?php
/**
 * Trait for RESTFUL APIs members 
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/RestfulUtilities-trait
 */

namespace Scandiweb\App\Http\Request\Traits;

/**
 * RestfulUtilities Trait
 * php version 7.4.0
 * 
 * @category App
 * @package  Scandiweb
 * @author   Masry <ahmad.saeed.goda@gmail.com>
 * @license  WTFPL <http://www.wtfpl.net/>
 * @link     https://docs-url-example.com/RestfulUtilities-trait
 */
trait RestfulUtilities
{
    private $_apiPrefix = 'api';
    private $_apiVersion = 'v1';

    /**
     * Setter for API Prefix
     *
     * @param string $prefix any URI to be used in Base URL
     * 
     * @return void
     */
    public function setAPIPrefix(string $prefix = 'api'): void
    {
        $this->_apiPrefix = $prefix;
    }

    /**
     * Getter for API Prefix
     *
     * @return string
     */
    public function getAPIPrefix(): string
    {
        return $this->_apiPrefix;
    }

    /**
     * Setter for API Version URI
     *
     * @param string $version any URI to be used in Base URL
     * 
     * @return void
     */
    public function setAPIVersion(string $version = 'v1'): void
    {
        $this->_apiVersion = $version;
    }

    /**
     * Getter for API Version
     *
     * @return string
     */
    public function getAPIVersion(): string
    {
        return $this->_apiVersion;
    }

    /**
     * Determines whther the client req asks for Json response
     *
     * @return boolean
     */
    public function wantsJson(): bool
    {
        if (empty($this->httpContentType)) {
            return false;
        }
        
        return $this->getMimeType($this->getFormat()) === $this->httpContentType;
    }
}
