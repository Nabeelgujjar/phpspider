<?php


namespace Mubin\Spider\Client;

use Mubin\Spider\Helper\Helper;

class Client
{
    protected $options = [];
    protected $helper;

    public function __construct(Helper $helper)
    {
        $this->options = config('client');
        $this->helper = $helper;
    }

    public function get($url, $options = [])
    {
        $options = $this->helper->defaults($options);
        $cookie = $options['cookie'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_ENCODING, isset($options['encoding']) ? $options['encoding'] : null);

        if (isset($options['header']) && !empty($options['header'])) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $options['header']);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,isset($options['transfer']) ? $options['transfer'] : null);
        curl_setopt($ch, CURLOPT_PROXY, isset($options['proxy']) ? $options['proxy'] : null);
        curl_setopt($ch, CURLOPT_TIMEOUT, isset($options['timeout']) ? $options['timeout'] : null);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, isset($options['follow_location']) ? $options['follow_location'] : null);
        curl_setopt($ch, CURLOPT_MAXREDIRS, isset($options['redirects']) ? $options['redirects'] : null);
        curl_setopt($ch, CURLOPT_USERAGENT, isset($options['user-agent']) ? $options['user-agent'] : null);
        curl_setopt($ch, CURLOPT_COOKIEJAR, realpath($cookie));
        curl_setopt($ch, CURLOPT_COOKIEFILE, realpath($cookie));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, isset($options['ssl']) ? $options['ssl'] : false);
        if (isset($options['referrer']) && $options['referrer'] != false) {
            curl_setopt($ch, CURLOPT_REFERER, $options['referrer']);
        } else {
            curl_setopt($ch, CURLOPT_REFERER, $url);
        }

        $data = curl_exec($ch);
        $info = curl_getinfo($ch);
        if ($options['debug']) {
            print_r($info);
        }
        curl_close($ch);
        if ($info['http_code'] == 200) {
            return $data;
        } else {
            return json_decode(['error' => 'Unable to get data', 'status_code' => $info['http_code'], 'request_url' => $url]);
        }
    }

    public function post($url, $options)
    {
        $options = $this->helper->defaults($options);
        $cookie = $options['cookie'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_ENCODING, $this->options['encoding']);

        if (isset($options['header']) && !empty($options['header'])) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $options['header']);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, isset($options['proxy']) ? $options['proxy'] : null);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, isset($options['transfer']) ? $options['transfer'] : null);
        curl_setopt($ch, CURLOPT_TIMEOUT, isset($options['timeout']) ? $options['timeout'] : null);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, isset($options['follow_location']) ? $options['follow_location'] : null);
        curl_setopt($ch, CURLOPT_MAXREDIRS, isset($options['redirects']) ? $options['redirects'] : null);
        curl_setopt($ch, CURLOPT_USERAGENT, isset($options['user-agent']) ? $options['user-agent'] : null);
        curl_setopt($ch, CURLOPT_COOKIEJAR, realpath($cookie));
        curl_setopt($ch, CURLOPT_COOKIEFILE, realpath($cookie));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, isset($options['ssl']) ? $options['ssl'] : false);
        if (isset($options['referrer']) && $options['referrer'] != false) {
            curl_setopt($ch, CURLOPT_REFERER, $options['referrer']);
        } else {
            curl_setopt($ch, CURLOPT_REFERER, $url);
        }
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $options['body']);

        $data = curl_exec($ch);
        $info = curl_getinfo($ch);
        if ($options['debug']) {
            print_r($info);
        }
        curl_close($ch);
        if ($info['http_code'] == 200) {
            return $data;
        } else {
            return json_decode(['error' => 'Unable to get data', 'status_code' => $info['http_code'], 'request_url' => $url]);
        }
    }
}