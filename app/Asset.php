<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $primaryKey = 'asset_id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asset_id', 'asset_name', 'asset_longname', 'description', 'issuance', 'issuance_normalized', 'divisible', 'locked', 'block_index', 'confirmed_at',
    ];

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = [
        'confirmed_at',
    ];

    /**
     * Update or Create Asset
     *
     * @param  arr  $message
     * @param  arr  $bindings
     * @return \App\Asset
     */
    public static function updateOrCreateAsset($message, $bindings)
    {
        try
        {
            if($bindings['status'] === 'valid')
            {
                if($asset = static::whereAssetName($bindings['asset'])->first())
                {
                    return $asset->updateAsset($message, $bindings);
                }
                else
                {
                    return static::createAsset($message, $bindings);
                }
            }
        }
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Asset: ' . $bindings['asset'] . ' ' . $message['message_index'] . ' ' . serialize($e->getMessage()));
        }
    }

    /**
     * Create Asset
     *
     * @param  arr  $message
     * @param  arr  $bindings
     * @return \App\Asset
     */
    public static function createAsset($message, $bindings)
    {
        try
        {
            return static::firstOrCreate([
                'asset_name' => $bindings['asset'],
            ],[
                'asset_id' => getAssetId($bindings['asset']),
                'asset_longname' => $bindings['asset_longname'],
                'description' => $bindings['description'],
                'issuance' => $bindings['quantity'],
                'issuance_normalized' => $bindings['divisible'] ? fromSatoshi($bindings['quantity']) : $bindings['quantity'],
                'divisible' => $bindings['divisible'],
                'locked' => $bindings['locked'],
                'block_index' => $bindings['block_index'],
                'confirmed_at' => $bindings['confirmed_at'],
            ]);
        }
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Asset: ' . $bindings['asset'] . ' ' . $message['message_index'] . ' ' . serialize($e->getMessage()));
        }
    }

    /**
     * Update Asset
     *
     * @param  arr  $message
     * @param  arr  $bindings
     * @return \App\Asset
     */
    public function updateAsset($message, $bindings)
    {
        try
        {
            if(isset($bindings['quantity']))
            {
                $issuance = $this->issuance + $bindings['quantity'];
                $issuance_normalized = $this->divisible ? $this->issuance_normalized + fromSatoshi($bindings['quantity']) : $this->issuance_normalized + $bindings['quantity'];

                if($issuance > 9223372036854775807)
                {
                    $issuance = 9223372036854775807;
                    $issuance_normalized = fromSatoshi(9223372036854775807);
                }
            }

            return $this->update([
                'description' => $bindings['description'],
                'issuance' => isset($issuance) ? $issuance : $this->issuance,
                'issuance_normalized' => isset($issuance_normalized) ? $issuance_normalized : $this->issuance_normalized,
                'locked' => ! $this->locked && $bindings['locked'] ? 1 : $this->locked,
            ]);
        }
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Asset: ' . $bindings['asset'] . ' ' . $message['message_index'] . ' ' . serialize($e->getMessage()));
        }
    }
}
