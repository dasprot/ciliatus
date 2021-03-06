<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 23.07.2016
 * Time: 15:18
 */

namespace App\Http\Transformers;


/**
 * Class TerrariumTransformer
 * @package App\Http\Transformers
 */
class TerrariumTransformer extends Transformer
{
    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        $return = [
            'id'    => $item['id'],
            'name'  => isset($item['name']) ? $item['name'] : '',
            'display_name' => $item['display_name'],
            'room_id' => $item['room_id'],
            'timestamps' => $this->parseTimestamps($item)
        ];

        $return = $this->addCiliatusSpecificFields($return, $item);
        $return = $this->addSensorSpecificFields($return, $item);

        if (isset($item['capabilities'])) {
            $return['capabilities'] = $item['capabilities'];
        }

        return $return;
    }
}