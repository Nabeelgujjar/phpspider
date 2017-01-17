<?php

namespace Mubin\Spider\Helper;

class Helper
{
    /**
     * Method checks the Storage path for the provided cookie file, if not found, will create new cookie
     * file with .cookie extension in Storage -> cookies folder.
     * @param $cookie  string   Cookie filename.
     * @return string   path to cookie file.
     */
    public function verifyCookieFile($cookie)
    {
        if (!Storage::has(sprintf('cookies/%s.cookie', $cookie))) {
            Storage::put(sprintf('cookies/%s.cookie', $cookie), '');
        }
        $cookie = sprintf(storage_path('app/cookies/%s.cookie'), $cookie);
        return $cookie;
    }

    /**
     * Method to check either options set or not, if not, load defaults.
     * @param $options array
     * @return array
     */
    public function defaults($options)
    {

        if (!isset($options['cookie']) || empty($options['cookie'])) {
            $options['cookie'] = 'cookie';
        }
        $options['cookie'] = $this->verifyCookieFile($options['cookie']);
        if (!isset($options['debug'])) {
            $options['debug'] = false;
        }
        if (!isset($options['user-agent'])) {
            $options['user-agent'] = config('client.user-agent:chrome');
        }
        return $options;
    }
}