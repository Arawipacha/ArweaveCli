<?php

//use \Arweave\Cli\Arweave;
use \Arweave\Cli\ArweaveCli;
use \Arweave\Cli\Support\Wallet;

include __DIR__ . '/vendor/autoload.php';

$arweave = new ArweaveCli('https', 'arweave.net', '443');

$jwk = json_decode(file_get_contents('keys/arweave-key-tD-NfxYM24xMqUTV_e6G8El7V4GmM5F7Hjio32c_KEM.json'), true);

$wallet =  new Wallet($jwk);

$file= "2_ff3f14665283c4f0b6c58ddd92f0d5df.png";
$image =  file_get_contents($file); 
//var_dump($image);
var_dump('data: '.mime_content_type($file).';base64,'. $image);
//return ;
$tx = $arweave->createTransaction($wallet, [
    //'target' => 'nQoflnhlpZwYuSHVQGYGTo41WR8MxBFfF9DNNbApoIp',
    'data' =>  $image,
    //'quantity' => '10',
    'tags' => [
        'Content-Type'=> mime_content_type($file)
        //'test-key' => 'test-value',
        
    ]
]);

// Dump the encoded transaction
var_dump($tx);

// Verify the signature
var_dump($tx->verify());

// Commit the transaction to the network - once sent this can't be undone.
$arweave->api()->commit($tx);

// Wait a few seconds for the tx to propagate
//sleep(50);
/*


//$status = $arweave->api()->getTransaction($tx->getAttribute('id'));
$transaction_id="VI-4HbMepKmFcXeXJWfatZyMqRGMG-smhwoGmFG-RNg";

$status = $arweave->api()->getTransaction($transaction_id);

$encoded_data = $status->getAttribute('data');

$original_data = base64_decode(\Arweave\SDK\Support\Helpers::base64urlDecode($encoded_data));

var_dump($original_data);
// Now print the status
var_dump($status);

*/
// Get transaction ids
/*
$transactionIds = $arweave->api()->arql([
    'op' => 'equals',
    'expr1' => 'App-Name',
    'expr2' => 'arweaveapps'
]);

// Dump the transaction ids
var_dump($transactionIds);
*/
