<?php declare(strict_types=1);

namespace App\Helper;

class FakeIpHelper
{
    /**
     * source: https://udger.com/resources/ip-list/fake_crawler
     */
    private const IPS = [
        '176.102.146.141',
        '88.248.23.216',
        '79.127.33.147',
        '76.174.154.221',
        '213.170.77.134',
        '78.107.239.115',
        '205.185.223.147',
        '186.250.176.149',
        '124.41.211.178',
        '181.129.47.27',
        '109.95.64.6',
        '94.24.91.186',
        '186.0.93.68',
        '132.191.10.242',
        '54.160.164.241',
        '200.35.56.89',
        '168.181.168.14',
        '93.227.247.116',
        '202.131.248.94',
        '111.206.198.19',
        '54.166.103.62',
        '177.66.61.187',
        '190.145.76.18',
        '212.90.59.242',
        '197.210.145.187',
        '5.166.236.2',
        '203.217.170.130',
        '222.186.57.163',
        '104.238.97.44',
        '170.238.41.16',
    ];

    public static function get(): string
    {
        return self::IPS[array_rand(self::IPS)];
    }
}