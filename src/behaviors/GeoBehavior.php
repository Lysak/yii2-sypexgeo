<?php

namespace lysak\behaviors;

use lysak\components\SypexGeo;
use yii\base\Behavior;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\web\Request;

/**
 * Class GeoBehavior is the behavior for {@see Request} class that provides functions of detecting
 * request geo information based on it's IP address.
 */
class GeoBehavior extends Behavior
{
    /**
     * If string, than the name of the application component
     * If array - configuration for SypexGeo class.
     *
     * @var array|string
     */
    public $config = 'sypexGeo';

    /**
     * @var SypexGeo
     */
    protected $sypexGeo;

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        if (\is_string($this->config)) {
            $this->sypexGeo = \Yii::$app->get($this->config);
        }

        if (\is_array($this->config)) {
            $this->sypexGeo = \Yii::createObject(\array_merge([
                'class' => SypexGeo::class,
            ], $this->config));
        }
    }

    /**
     * @param Component $owner
     *
     * @throws InvalidConfigException
     */
    public function attach($owner): void
    {
        if (!$owner instanceof Request) {
            throw new InvalidConfigException('GeoBehavior can be only attached to the yii\web\Request and it\'s children');
        }

        parent::attach($owner);
    }

    /**
     * @return array|bool false if city is not detected
     */
    public function getCity()
    {
        return $this->sypexGeo->getCity($this->getIP());
    }

    /**
     * @return array
     */
    public function getCountry()
    {
        return $this->sypexGeo->getCountry($this->getIP());
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->sypexGeo->getCountryId($this->getIP());
    }

    /**
     * @return array
     */
    public function getCityFull()
    {
        return $this->sypexGeo->getCityFull($this->getIP());
    }

    /**
     * @return null|string
     */
    protected function getIP()
    {
        /** @var Request $owner */
        $owner = $this->owner;

        return $owner->getUserIP();
    }
}
