<?php

namespace App\Repositories;

use App\Event;

/**
 * Class AnimalFeedingEventRepository
 * @package App\Repositories
 */
class AnimalFeedingEventRepository extends Repository {

    /**
     * AnimalFeedingRepository constructor.
     * @param Event|null $scope
     */
    public function __construct(Event $scope = null)
    {

        $this->scope = $scope ? : new Event();
        $this->addCiliatusSpecificFields();

    }

    /**
     * @return Event
     */
    public function show()
    {
        $animal_feeding = $this->scope;

        $animal_feeding->animal = is_null($animal_feeding->belongsTo_object()) ? null : $animal_feeding->belongsTo_object()->toArray();

        return $animal_feeding;
    }

}