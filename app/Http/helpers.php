<?php

function fromSatoshi($satoshi)
{
    return bcdiv((int)(string)$satoshi, 100000000, 8);
}

function toSatoshi($decimal)
{
    return bcmul(sprintf("%.8f", (float)$decimal), 100000000, 0);
}

function getAddressType($address)
{
    if(strpos($address, '_') !== false)
    {
        return 'multisig';
    }
    elseif($address[0] === '1')
    {
        return 'p2pkh';
    }
    elseif($address[0] === '3')
    {
        return 'p2sh';
    }
    elseif($address[0] === 'b')
    {
        return 'bech32';
    }

    return 'unknown';
}

function getAssetType($issuance)
{
    if($issuance->asset_longname)
    {
        return 'subasset';
    }
    elseif($issuance->asset[0] === 'A')
    {
        return 'numeric';
    }

    return 'asset';
}

function getBetType($type)
{
    switch($type)
    {
        case 0:
            return 'Bullish CFD';
        case 1:
            return 'Bearish CFD';
        case 2:
            return 'Equal';
        case 3:
            return 'Not Equal';
    }
}

function getKeyFromRequest($keyword, $request)
{
    return $keyword . '_' . $request->input('page', 1) . '_' . $request->input('per_page', 10);
}

function getTitleFromType($type)
{
    if($type === 'rps') return 'RPS';
    if($type === 'btcpays') return 'BTCPay';
    if($type === 'rpsresolves') return 'RPS Resolve';

    return str_replace('Rps ', 'RPS ', ucfirst(title_case(str_singular($type))));
}

function getModelNameFromType($type)
{
    if($type === 'rps') return '\\App\\Rps';
    if($type === 'rpsresolves') return '\\App\\Rpsresolve';

    return '\\App\\' . ucfirst(camel_case(str_singular($type)));
}

function getCreateLookupKeys($message, $bindings)
{
    // Symmetric Keys
    if(in_array($message['category'], ['bets', 'broadcasts', 'btcpays', 'burns', 'cancels', 'destructions', 'dividends', 'issuances', 'orders', 'rps', 'rpsresolves', 'sends']))
    {
        $model_key = $bindings_key = 'tx_index';
    }
    elseif($message['category'] === 'order_matches' || $message['category'] === 'bet_matches' || $message['category'] === 'rps_matches')
    {
        $model_key = $bindings_key = 'id';
    }
    elseif($message['category'] === 'order_expirations' || $message['category'] === 'bet_expirations' || $message['category'] === 'rps_expirations')
    {
        $model_key = $bindings_key = str_replace('_expirations', '_index', $message['category']);
    }
    elseif($message['category'] === 'order_match_expirations' || $message['category'] === 'bet_match_expirations' || $message['category'] === 'rps_match_expirations')
    {
        $model_key = $bindings_key = str_replace('_expirations', '_id', $message['category']);
    }
    elseif($message['category'] === 'bet_match_resolutions')
    {
        $model_key = $bindings_key = str_replace('_resolutions', '_id', $message['category']);
    }

    // Credits, Debits, Replace
    if(! isset($model_key)) return false;

    return [
        'model_key' => $model_key,
        'bindings_key' => $bindings_key,
    ];
}

function getUpdateLookupKeys($message, $bindings)
{
    // Symmetric Keys
    if($message['category'] === 'bets' || $message['category'] === 'orders')
    {
        $model_key = $bindings_key = 'tx_hash';
    }
    elseif($message['category'] === 'rps')
    {
        $model_key = $bindings_key = 'tx_index';
    }
    else
    {
        $model_key = $bindings_key = str_replace('_matches', '_match_id', $message['category']);
    }

    // Divergent Keys
    if($message['category'] === 'order_matches' || $message['category'] === 'bet_matches' || $message['category'] === 'rps_matches')
    {
        $model_key = 'id';
    }

    // Edge Case Keys
    if($message['category'] === 'rps' && ! isset($bindings[$bindings_key]))
    {
        // RPS seems to use tx_index OR tx_hash
        $model_key = $bindings_key = 'tx_hash';
    }

    return [
        'model_key' => $model_key,
        'bindings_key' => $bindings_key,
    ];
}

function remove_keys($item)
{
    return strlen($item) > 1;
}

function getBadgeColor($type)
{
    switch($type) {
        case 'Send':
            return 'badge-primary';
            break;
        case 'Order':
            return 'badge-success';
            break;
        case 'Issuance':
            return 'badge-warning';
            break;
        case 'Cancel':
            return 'badge-danger';
            break;
        case 'Broadcast':
            return 'badge-dark';
            break;
        case 'Bet':
            return 'badge-dark';
            break;
        case 'Burn':
            return 'badge-danger';
            break;
        case 'Dividend':
            return 'badge-success';
            break;
        default:
            return 'badge-secondary';
    }
}