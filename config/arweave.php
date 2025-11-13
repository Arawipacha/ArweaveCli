<?php

return [
    /*
     * The protocol to connect to the Arweave node with.
     * Can be 'http' or 'https'.
     */
    'protocol' => env('ARWEAVE_PROTOCOL', 'http'),

    /*
     * The Arweave node IP address or hostname to connect to.
     */
    'host' => env('ARWEAVE_HOST', '127.0.0.1'),

    /*
     * The network port to use.
     * Default should be 1984, 443, or 80.
     */
    'port' => env('ARWEAVE_PORT', 1984),
];
