<?php
include_once dirname(__FILE__) . '/HessianPhp/HessianClient.php';
include_once dirname(__FILE__) . '/HessianPhp/HessianOptions.php';

class ApiFactory
{

    /**
     *
     * @var Zookeeper
     */
    private $zookeeper;

    private $zkAddress;

    /**
     * Constructor
     *
     * @param string $address
     *            CSV list of host:port values (e.g. "host1:2181,host2:2181")
     */
    public function __construct($address = null)
    {
        if ($address) {
            $this->zkAddress = $address;
        } else {
            // $dubboConfig = new DubboConfig();
            // $this->zkAddress = $dubboConfig->dubboRegistryAddress;
            $dubboConfig = pc_base::load_config('api');
            $this->zkAddress = $dubboConfig['hessian']['zookeeperAddress'];
        }
        
        $this->zookeeper = new Zookeeper($this->zkAddress);
    }

    public function getAllProviders()
    {
        return $this->getChildren('/dubbo');
    }

    public function getProviders($api)
    {
        return $this->getChildren('/dubbo/' . $api . '/providers');
    }

    public function getRouters($api)
    {
        return $this->getChildren('/dubbo/' . $api . '/routers');
    }

    public function getHessianProviders($api)
    {
        $providers = $this->getProviders($api);
        $hessianProviders = array();
        if ($providers && count($providers) > 0) {
            foreach ($providers as $i => $provider) {
                // echo $provider . '\n';
                if (substr($provider, 0, 7) === 'hessian') {
                    // before
                    // decode��hessian%3A%2F%2F10.71.88.241%3A7011%2Fcom.hnair.opcnet.api.ods.dsp.GetDspReleaseApi
                    $p = urldecode($provider);
                    // urldecode��hessian://10.71.88.241:7011/com.hnair.opcnet.api.ods.dsp.GetDspReleaseApi
                    $pos = strpos($p, '?');
                    if ($pos > 0) {
                        $p = substr($p, 7, $pos - 7);
                        // echo $p . "\n";
                        $hessianProviders[] = 'http' . $p;
                    }
                }
            }
            
            // start to check route
            if (count($hessianProviders) > 0) {
                // get routers
                $routers = $this->getRouters($api);
                if (! $routers || count($routers) == 0) {
                    // no routers, return all matched providers
                    return $hessianProviders;
                }
                
                // TODO: sort by priority
                
                // process routers
                foreach ($routers as $i => $rawRoute) {
                    $dr = new DubboRouter($rawRoute);
                    echo "router\n";
                    var_dump($dr);
                }
            }
        }
        return $hessianProviders;
    }

    public function getApi($api, $options = null)
    {
        $providerUrls = $this->getHessianProviders($api);
        // print('get api provders: ' . $api . "...\r\n");
        if ($providerUrls && count($providerUrls) > 0) {
            
            $i = rand(0, count($providerUrls) - 1);
            // print('api provider selected: ' . $providerUrls[$i] . "...\r\n");
            return new HessianClient($providerUrls[$i], $options);
        } else {
            throw new Exception("could not find any provider for $api, protocol=hessian, zkServer=$this->zkAddress.");
        }
    }

    /**
     * Get the value for the node
     *
     * @param string $path
     *            the path to the node
     *            
     * @return string null
     */
    public function get($path)
    {
        if (! $this->zookeeper->exists($path)) {
            return null;
        }
        return $this->zookeeper->get($path);
    }

    /**
     * List the children of the given path, i.e.
     * the name of the directories
     * within the current node, if any
     *
     * @param string $path
     *            the path to the node
     *            
     * @return array the subpaths within the given node
     */
    public function getChildren($path)
    {
        if (strlen($path) > 1 && preg_match('@/$@', $path)) {
            // remove trailing /
            $path = substr($path, 0, - 1);
        }
        return $this->zookeeper->getChildren($path);
    }
}

class DubboRouter
{

    private $routeUrl;

    private $rule;

    public function __construct($rawRouteUrl)
    {
        if ($rawRouteUrl) {
            $this->routeUrl = urldecode($rawRouteUrl);
            $this->parseRoute();
        }
    }

    public function parseRoute()
    {
        // route://0.0.0.0/com.hnair.opcnet.api.ods.hr.HrOrgAndEmpApi?category=routers&dynamic=false&enabled=true&force=true&name=com.hnair.opcnet.api.ods.hr.HrOrgAndEmpApi:1.0.0
        // blackwhitelist&priority=0&router=condition&rule=consumer.host+%21%3D+10.71.88.241%2C10.72.16.129%2C10.2.101.54%2C10.2.101.52%2C10.72.16.131%2C10.72.16.132%2C10.72.16.130%2C172.16.113.236+%3D%3E+false&runtime=false&version=1.0.0
        $pos = strpos($this->routeUrl, '&rule=');
        if ($pos > 0) {
            $len = strlen($this->routeUrl);
            $rule = substr($this->routeUrl, $pos + 6, $len - $pos);
            
            $pos = strpos($rule, '&');
            if ($pos > 0) {
                $rule = substr($rule, 0, $pos);
            }
            
            $this->rule = urldecode($rule);
        }
    }

    public function doRoute()
    {}
}
?>
