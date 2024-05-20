<?php


/*
 *  Validate data for the dinner app
 *
 */

// Return true if food contains at least 3 chars

class Validate
{

    // TODO: ADD PHP doc blocks
    static function validFood($food)
    {
        return strlen(trim($food)) >= 3;
    }

// Return true if the meal is valid
    static function validMeal($meal)
    {
        return in_array($meal, DataLayer::getMeals());
    }
}
