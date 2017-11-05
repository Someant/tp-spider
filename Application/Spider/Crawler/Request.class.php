<?php
namespace Spider\Crawler;

use Spider\Listeners\EventListener;
use Spider\Scheduler\Scheduler;
use Think\Controller;
use Predis;
use Think\Exception;

/**
 * Lib spider 爬虫基础类
 */
class Request
{

    protected $url;   //目标URL
    private $data;
    private $curl;
    protected $dnsCache = 0;    //CURL DNS缓存
    protected $ua = [];
    protected $cookies = [];
    protected $timezone = 'Asia/Shanghai';
    protected $header = [
        ['User-Agent: Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; SV1)'],
        ['User-Agent:Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36'],
        ['Mozilla/5.0 (compatible; U; ABrowse 0.6; Syllable) AppleWebKit/420+ (KHTML, like Gecko)']
    ];
    protected $redis;
    private $_response;
    private $_url;

    public function __construct()
    {
        date_default_timezone_set($this->timezone);
        $this->curl = curl_init();

        $config = C('REDIS');
        $this->redis = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => $config['host'],
            'port'   => $config['port'],
            'password' => $config['password'],
        ]);
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }

    //return data
    public function getData()
    {
        return $this->data;
    }

    public function getRequest($url, $parameter = array())
    {
        $i = 0;
        foreach ($parameter as $key => $val) {
            if ($i == 0) {
                $url .= '?' . $key . '=' . $val;
            } else {
                $url .= '&' . $key . '=' . $val;
            }
            $i++;
        }

        if ($this->isHaveParam($url)){
            foreach(C('ROUTE_INFO')['param'] as $key => $param){
                $url = str_replace('{' . $key . '}', $param, $url);
            }
        }
        
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->header[rand(0, 2)]);  //设置头信息的地方
        curl_setopt($this->curl, CURLOPT_HEADER, 0);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 60);

        $this->_url = $url;
        $data = curl_exec($this->curl);
        preg_match('/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}/',$url,$matches);
        
        // 检查是否有错误发生
        if (curl_errno($this->curl)) {
            addMyLog('Curl url: ' . $url, 'curl_error');
            addMyLog('Curl error: ' . curl_error($this->curl), 'curl_error');
            addMyLog('Curl info: ' . print_r(curl_getinfo($this->curl),true), 'curl_error');
            if (empty($this->redis->get('spider:'.$matches[0]))){
                //sendMessageToMe($url . '采集失败！info：' . curl_error($this->curl));
                EventListener::setMessage([
                    'url' => $matches[0],
                    'message' => curl_error($this->curl),
                ]);
                EventListener::curlErrorEvent();

            }
            throw new Exception("{$matches[0]} Url request failed:".curl_error($this->curl));
        }else{
            $this->redis->set('spider:'.$matches[0],time());
            $this->redis->expire('spider:'.$matches[0],30*60);
        }

        return $this->_response = $data;
    }

    public function postRequest($url, $message = '')
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HEADER, 0);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $message);
        curl_setopt($this->curl, CURLOPT_DNS_CACHE_TIMEOUT, $this->dnsCache);
        $data = curl_exec($this->curl);

        return $data;
    }

    public static function get($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        $data = curl_exec($curl);

        if (curl_errno($curl)){
            throw new Exception("{$url} Url request failed:".curl_error($curl));
        }

        curl_close($curl);
        return $data;
    }

    public static function post($url, $message)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST,1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $message);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        $data = curl_exec($curl);

        if (curl_errno($curl)){
            throw new Exception("{$url} Url request failed:".curl_error($curl));
        }

        $log = [
            'url' => $url,
            'message' => $message,
            'response' => $data,
        ];
        addMyLog(print_r($log,true),'notice_post');

        curl_close($curl);
        return $data;
    }

    public function isHaveParam($str)
    {
        $isMatched = preg_match('/{.*}/', $str, $matches);

        if (count($matches) > 0){
            return true;
        }

        return false;
    }

    public function validDataHasChange()
    {
        $cache_name = 'lock:url:data:'.$this->_url;
        $old_md5 = S($cache_name);
        $new_md5 = md5($this->_response);

        if (!$old_md5){
            S($cache_name,$new_md5,300);
            return true;
        }

        if ($old_md5 == $new_md5){
            return false;
        }
        S($cache_name,$new_md5,300);
        return true;
    }

    public function getFullRequestUrl()
    {
        return $this->_url;
    }
}
