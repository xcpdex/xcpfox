<?php

function fromSatoshi($satoshi)
{
    return bcdiv((int)(string)$satoshi, 100000000, 8);
}

function toSatoshi($decimal)
{
    return bcmul(sprintf("%.8f", (float)$decimal), 100000000, 0);
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

function getAssetId($asset_name)
{
    if($asset_name === 'BTC')
    {
        return 0;
    }
    elseif($asset_name === 'XCP')
    {
        return 1;
    }
    elseif(substr($asset_name, 0, 1) === 'A')
    {
        return substr($asset_name, 1);
    }
    else
    {
        $b26d = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $asset_name = str_split($asset_name);

        $n = 0;
        foreach($asset_name as $c)
        {
            $n *= 26;
            $n += strpos($b26d, $c);
        }

        return $n;
    }
}