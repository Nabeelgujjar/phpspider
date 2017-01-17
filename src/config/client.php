<?php

return [
    'user-agent:chrome' => 'Mozilla/5.0 (Windows NT 6.4; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2225.0 Safari/537.36',
    'user-agent:ie' => 'Mozilla/5.0 (Windows; U; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)',
    'user-agent:ff' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1',
    /* curl return headers. */
    'header' => false,
    /* curl return transfer. */
    'transfer' => true,
    /* timeout[seconds]. */
    'timeout' => 20,
    /* follow location. */
    'follow_location' => true,

    /* max redirects. */
    'redirects' => 10,

    /* encoding. */

    'encoding' => 'gzip,deflate,sdch',

    /**
     * Verify SSL
     */
    'ssl' => true,
];