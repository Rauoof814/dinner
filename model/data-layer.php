<?php

/*
 *  This is my data layer,
 *  IT belongs to the Model.
 */

class DataLayer
{

    // Get the meals fot the Dinner app
    static function getMeals()
    {

        return array('brunch', 'breakfast', 'lunch', 'dinner', 'desert', 'ice cream', 'drinks');
    }

    static function getCondiments()
    {

        return array('ketchup','mustard','sauce','sriracha', 'sour cream');
    }
}












