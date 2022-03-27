<?php

namespace Arweave\Cli;

use Exception;
use Arweave\Cli\Support\API;
use Arweave\Cli\Support\Wallet;
use Arweave\Cli\Support\Helpers;
use Arweave\Cli\Support\Transaction;

class ArweaveCli
{

    /**
     * Arweave API object.
     *
     * @var \Arweave\Cli\Support\API
     */
    protected $api;

    /**
     * Arweave node hostname or IP address
     *
     * @var string
     */
    protected $host;

    /**
     * @param string $protocol 'http' or 'https'
     * @param string $host IP address or hostname
     * @param int $port Port number
     */
    public function __construct($protocol, $host, $port)
    {
        $this->api = new API($protocol, $host, $port);
    }

    public function api(): API {
        return $this->api;
    }

    /**
     * Create a new transaction object from a given wallet and piece of data.
     *
     * @param  Wallet $wallet Sending wallet
     *
     * @param  string $data Data to be added to the transaction
     *
     * @return \Arweave\Cli\Support\Transaction
     */
    public function createTransaction(Wallet $wallet, $attributes): Transaction
    {

        if (!$attributes || !is_array($attributes)) {
            throw new Exception('Invalid transaction attributes passed');
        }

        $encoded_tags = array_map(function($name) use ($attributes){
            return [
                'name' => Helpers::base64urlEncode(base64_encode($name)),
                'value' => Helpers::base64urlEncode(base64_encode($attributes['tags'][$name]))
            ];
        }, array_keys($attributes['tags'] ?? []));

        $transaction = new Transaction([
            'last_tx'  => $this->api->getTransactionAnchor(),
            'owner'    => $wallet->getOwner(),
            'tags'     => $encoded_tags,
            'target'   => $attributes['target'] ?? '',
            'quantity' => $attributes['quantity'] ?? '0',
            'data'     => Helpers::base64urlEncode(base64_encode($attributes['data'] ?? '')),
            'reward'   => $attributes['reward'] ?? 
                $this->api->getReward(
                    strlen($attributes['data'] ?? ''),
                    $attributes['target'] ?? null
                ),
        ]);

        $transaction->sign($wallet);

        return $transaction;
    }
}
