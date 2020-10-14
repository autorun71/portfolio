<?php


namespace Webkul\Region\Service;


use Webkul\Region\Repositories\ChannelRepository;
use Webkul\Region\Repositories\RegionPropsRepository;
use Webkul\Region\Repositories\RegionRepository;

abstract class CoreRegion
{
    /**
     * @var string|bool
     */
    protected $fullDomain = null;

    /**
     * @var string|bool
     */
    protected $urn = null;

    /**
     * @var string|bool
     */
    protected $url = null;

    /**
     * @var string|bool
     */
    protected $domain = null;

    /**
     * @var string|bool
     */
    protected $regionCode = null;

    /**
     * @var ChannelRepository
     */
    protected $channelRepository;

    /**
     * @var RegionRepository
     */
    protected $regionRepository;

    /**
     * @var RegionPropsRepository
     */
    protected $regionPropsRepository;

    /**
     * @var integer|bool
     */
    protected $channel = null;

    /**
     * @var integer|null
     */
    protected $statusPodDomain = null;

    /**
     * @var string
     */
    protected $region;

    public $status = 404;

    protected $regions;

    protected $props;

    public function __construct()
    {



        $this->channelRepository = app(ChannelRepository::class);
        $this->regionRepository = app(RegionRepository::class);
        $this->regionPropsRepository = app(RegionPropsRepository::class);



    }

    protected function init()
    {
        if (!$this->getChannelForDomain()) {
            return false;
        }

        $status = $this->statusPodDomain = (integer)$this->channelRepository->getStatusPoddomain($this->channel);

        if ($status > 0) {
            switch ($status) {
                case 1:
                    $this->getRegionForDomain();
                    break;

                case 2:
                    $this->getRegionForUrn();
                    if (!$this->checkDomain()) {
                        $this->reset();
                    }
            }
            if (!empty($this->region)) {
                $this->setProps();
                $this->status = 200;
            }


        }
        return $this;
    }

    protected function setDomain($domain)
    {
        $this->reset();
        $arDomain = self::clearDomain($domain);
        $this->fullDomain = $arDomain['domain'];
        $this->url = $arDomain['uri'];
        $this->urn = $arDomain['urn'];
    }

    public static function clearDomain($domain)
    {
        $uri = str_replace(['http://', 'https://'], '', $domain);
        $arDomain = explode('/', $uri);
        $domain = array_shift($arDomain);
        $urn = implode('/', $arDomain);
        return compact('uri', 'urn', 'domain');
    }

    private function getRegionForDomain()
    {
        $arDomain = (explode('.', $this->fullDomain));
        $parts = count($arDomain);
        $podDomain = 'default';
        if ($parts > 2 && $arDomain[$parts - 1] != 'www') {
            $podDomain = array_shift($arDomain);
            if ($podDomain == 'default') return false;
        }


        return $this->setRegion($podDomain);
    }

    private function getRegionForUrn()
    {
        $arUrn = (explode('/', $this->urn));
        $regionCode = array_shift($arUrn);
        $regionCode = $regionCode == 'api' ? 'default' : $regionCode;
        return $this->setRegion($regionCode);
    }

    private function setRegion($code)
    {
        $arRegion = $this->getRegionByCode($code);

        if ($arRegion['active']) {
            $this->region = $arRegion['region'];
            return true;
        }
        return false;
    }

    private function getChannelForDomain()
    {
        foreach ($this->channelRepository->getHosts() as $item) {
            $domain = $item['hostname'];
            if (preg_match('/.*' . $domain . '.*/i', $this->fullDomain, $match)) {
                $this->channel = $item['id'];
                $this->domain = $domain;
                return true;
                break;
            }
        }
        return false;
    }

    private function getRegionByCode($code)
    {
        $item = $this->regionRepository->getRegionByCode($code);
        $active = false;
        $region = [];
        if (!empty($item)) {
            $item = $item->toArray();
            foreach ($item['channels'] as $channel) {
                if ($channel['id'] == $this->channel) {
                    $active = true;
                }
            }
        }

        if ($active) {
            $region = [
                "id" => $item['id'],
                "name" => $item['name'],
                "alias" => $item['alias'],
                "enable" => $item['enable']
            ];
            $this->regionCode = $item['alias'];
        }
        return compact('active', 'region');
    }

    private function setProps()
    {
        $this->props = $this->regionPropsRepository->getPropsWithValueForRegionAndChannel($this->region['id'],
            $this->channel);
    }

    private function checkDomain()
    {
        $check = false;
        if ($this->domain == $this->fullDomain){
            $check = true;
        }

        return $check;
    }

    private function reset()
    {
        $this->fullDomain = null;
        $this->domain = null;
        $this->url = null;
        $this->urn = null;
        $this->regionCode = null;
        $this->channel = null;
        $this->statusPodDomain = null;
        $this->region = null;
        $this->props = null;
        $this->status = 404;
    }
}