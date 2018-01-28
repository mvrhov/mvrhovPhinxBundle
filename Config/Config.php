<?php
namespace mvrhov\PhinxBundle\Config;

use Phinx\Config\Config as PhinxConfig;

class Config extends PhinxConfig {

    public function __construct(array $configArray, $configFilePath = null)
    {
        if (array_key_exists('environments', $configArray) && is_array($configArray['environments'])) {
            $configArray['environments'] = $this->preprocessEnvironmentsConfiguration($configArray['environments']);
        }

        return parent::__construct($configArray, $configFilePath);
    }

    private function preprocessEnvironmentsConfiguration(array $environments)
    {
        foreach ($environments as $environment => $environmentData) {
            if (!is_array($environmentData)) {
                //This is some key like: ("default_database" => "default"),
                //not an actual environment definition.
                continue;
            }

            if (!array_key_exists('url', $environmentData)) {
                //This environment likely contains (host, name, user, pass, port) like Phinx expects.
                //No need to try and parse those out of a 'url' config value.
                continue;
            }

            $matches = null;
            if (!preg_match('/^([^:]+):\/\/([^:]+):([^@]+)@([^\/]+)\/(.+?)$/', $environmentData['url'], $matches)) {
                throw new \Exception('Cannot parse database URI.');
            }
            list ($_fullMatch, $adapter, $dbUsername, $dbPassword, $dbHostAndPort, $dbName) = $matches;

            $dbHost = $dbHostAndPort;
            $dbPort = 3306;
            if (preg_match('/^([^:]+):(\d+)$/', $dbHostAndPort, $dbHostMatches)) {
                $dbHost = $dbHostMatches[1];
                $dbPort = (int) $dbHostMatches[2];
            }

            unset($environmentData['url']);

            $environmentData['adapter'] = $adapter;
            $environmentData['name'] = $dbName;
            $environmentData['host'] = $dbHost;
            $environmentData['port'] = $dbPort;
            $environmentData['user'] = $dbUsername;
            $environmentData['pass'] = $dbPassword;

            $environments[$environment] = $environmentData;
        }

        return $environments;
    }

}
