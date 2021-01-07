<?php

namespace lysak\components;

use lysak\domain\SxGeo;
use yii\base\Component;

/**
 * Class SypexGeo is the wrapper for the SxGeo class that provides ability to use it as
 * application component.
 *
 * @property SxGeo $sxGeo Direct access to the SxGeo class
 */
class SypexGeo extends Component
{
    /**
     * @var SxGeo
     */
    protected $_sxGeo;

    /**
     * Path to to the database file for Sypex Geo.
     *
     * @var string
     */
    public $database;

    /**
     * Access mode to the Sypex database.
     *
     * @var int
     */
    public $accessMode = SxGeo::SXGEO_FILE;

    /**
     * @param null|string $ip
     *
     * @return array|bool false if city is not detected
     */
    public function getCity($ip)
    {
        return $this->getSxGeo()->getCity($ip);
    }

    /**
     * @param null|string $ip
     *
     * @return array
     */
    public function getCountry($ip)
    {
        return $this->getSxGeo()->getCountry($ip);
    }

    /**
     * @param null|string $ip
     *
     * @return int
     */
    public function getCountryId($ip)
    {
        return $this->getSxGeo()->getCountryId($ip);
    }

    /**
     * @param null|string $ip
     *
     * @return array
     */
    public function getCityFull($ip)
    {
        return $this->getSxGeo()->getCityFull($ip);
    }

    /**
     * @return SxGeo
     */
    public function getSxGeo()
    {
        if (null === $this->_sxGeo) {
            $this->_sxGeo = new SxGeo(\Yii::getAlias($this->database), $this->accessMode);
        }

        return $this->_sxGeo;
    }
}
