<?php

// Teacher's repo


// 328/diner/index.php
// This is my CONTROLLER!

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require the necessary files
require_once('vendor/autoload.php');
//require_once ('model/data-layer.php');
//require_once ('model/validate.php');
//require_once ('classes/order.php');


/* Test the validate class */
//if (Validate::validFood('tacos')){
//    echo "This is valid";
//}
/* Test the DataLayer class */
//var_dump(DataLayer::getMeals());


/* Test the Order class

echo "<pre>";
$order = new Order("pad thai", "lunch", ['soy Sauce']);
var_dump($order);

$order2 = new Order();
$order2->setFood('nachos');
$order2->setMeal('dinner');
$order2->setCondiments(['salsa', 'guacamole']);

var_dump($order2);

echo "</pre>";
*/

//$testFood = 'pho';
//echo validFood($testFood) ? "valid" : "not valid";
//var_dump(validFood($testFood));
//var_dump(getMeals());

// Instantiate the F3 Base class
$f3 = Base::instance();

// Define a default route
// https://tostrander.greenriverdev.com/328/hello-fat-free/
$f3->route('GET /', function () {
    //echo '<h1>Hello from My Diner App!</h1>';

    // Render a view page
    $view = new Template();
    echo $view->render('views/home-page.html');
});

// Breakfast menu
$f3->route('GET /menus/breakfast', function () {
    //echo '<h1>My Breakfast Menu</h1>';

    // Render a view page
    $view = new Template();
    echo $view->render('views/breakfast-menu.html');
});

// Lunch menu
$f3->route('GET /menus/lunch', function () {
    //echo '<h1>My Breakfast Menu</h1>';

    // Render a view page
    $view = new Template();
    echo $view->render('views/lunch-menu.html');
});

// Dinner menu
$f3->route('GET /menus/dinner', function () {
    //echo '<h1>My Breakfast Menu</h1>';

    // Render a view page
    $view = new Template();
    echo $view->render('views/dinner-menu.html');
});

// Order Summary
$f3->route('GET /summary', function ($f3) {


    // Write data to the database


    // Render a view page
    $view = new Template();
    echo $view->render('views/order-summary.html');


//    var_dump($f3->get('SESSION'));
    session_destroy();
});

// Order Form Part I
$f3->route('GET|POST /order1', function ($f3) {
    //echo '<h1>My Breakfast Menu</h1>';


    // Initialize some variables
    $food = "";
    $meal = "";
    // If the form has been posted
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        //echo "<p>You got here using the POST method</p>";
        //var_dump ($_POST);

        // Get the data from the post array

        if (Validate::validFood($_POST['food']))
        {
            $food = $_POST['food'];
        }

        else
        {
            $f3->set('errors["food"]', 'Please enter a food');
        }

        if (isset($_POST['meal']) and Validate::validMeal($_POST['meal']))
        {
            $meal = $_POST['meal'];
        }
        else
        {
            $f3->set('errors["meal"]', 'Please enter a meal');
        }


        // Add the data to the session array
        $order = new Order($food, $meal);
        $f3->set('SESSION.order', $order);

        // Old way (non OOP method)
//        $f3->set('SESSION.food', $food);
//        $f3->set('SESSION.meal', $meal);

        // If there are no errors, Send the user to the next form

        if (empty($f3->get('errors')))
        {
            $f3->reroute('order2');
        }


    }


    // Get the data from the model
    // and add it to the F3 hive
    $meals = DataLayer::getMeals();
    $f3->set('meals', $meals);


    // Render a view page
    $view = new Template();
    echo $view->render('views/order1.html');
});

// Order Form Part II
$f3->route('GET|POST /order2', function ($f3) {

//    var_dump($f3->get('SESSION'));

    // If the form has been posted
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        //var_dump($_POST);
        // Get the data from the post array
        if (isset($_POST['conds']))
            $condiments = implode(", ", $_POST['conds']);
        else
            $condiments = "None selected";

        // If the data valid
        if (true) {

            // Add the data to the session array
            $f3->get('SESSION.order')->setCondiments($condiments);

            // Old Way
//            $f3->set('SESSION.condiments', $condiments);

            // Send the user to the next form
            $f3->reroute('summary');
        } else {
            // Temporary
            echo "<p>Validation errors</p>";
        }
    }


    // Get the data from the model
    $conds = DataLayer::getCondiments();
    $f3->set('conds', $conds);

    // Render a view page
    $view = new Template();
    echo $view->render('views/order2.html');
});

// Run Fat-Free
$f3->run();





/*
// 328/Week2/dinner/index.php
// This is my CONTROLLER!

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require the autoload file
require_once ('vendor/autoload.php');

// Instantiate the F3 Base class
$f3 = Base::instance();

// Define a default route
// https://ayadgari.greenriverdev.com/328/Week2/dinner/index.php

$f3->route('GET /', function() {
//    echo '<h1>Hello Diner!</h1>';

    // Render a view page
    $view = new Template();
    echo $view->render('views/home-page.html');
});


// Breakfast menu
$f3->route('GET /menus/breakfast', function() {
//    echo '<h1>My Breakfast Menu!</h1>';

    // Render a view page
    $view = new Template();
    echo $view->render('views/breakfast-menu.html');
});

// Lunch menu
$f3->route('GET /menus/lunch', function() {
//    echo '<h1>My Breakfast Menu!</h1>';

    // Render a view page
    $view = new Template();
    echo $view->render('views/lunch-menu.html');
});

// Dinner menu
$f3->route('GET /menus/dinner', function() {
//    echo '<h1>My Breakfast Menu!</h1>';

    // Render a view page
    $view = new Template();
    echo $view->render('views/dinner-menu.html');
});

// Order Form Part I
$f3->route('GET|POST /order1', function($f3) {
//    echo '<h1>My Breakfast Menu!</h1>';


    // If the form has been posted
    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {

        global $f3;
        $f3 = $GLOBALS['f3'];

        echo "<p>You got here using the POST method</p>";
        var_dump($_POST);


        // Get the data from the post array

        $food = $_POST['food'];
        $meal = $_POST['meal'];
        // If the data valid
        if (true)
        {
            $f3->set('SESSION.food', $food);
            $f3->set('SESSION.meal', $meal);
        }

    }
    else
    {
        echo "<p>You got here using the GET method</p>";

    }
    // Render a view page
    $view = new Template();
    echo $view->render('views/order1.html');
});

// Order Form Part II
$f3->route('GET /order2', function() {
//    echo '<h1>My Breakfast Menu!</h1>';

    // Render a view page
    $view = new Template();
    echo $view->render('views/order2.html');
});


// Run Fat-Free
$f3->run();
*/


/*
// 328/Week2/diner/index.php
// This is my CONTROLLER!

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require the autoload file
require_once('vendor/autoload.php');

// Instantiate the F3 Base class
$f3 = Base::instance();

// Define a default route to home page
// https://ayadgari.greenriverdev.com/328/Week2/diner/

$f3->route('GET /', function () {
    //echo '<h1>Hello Diner!</h1>';

    // Render a view page
    $view = new Template();
    echo $view->render('views/home-page.html');
});

// define 2nd Route to breakfast menu
$f3->route('GET /menus/breakfast', function () {
    // echo '<h1>Welcome, This is Menu!</h1>';

    // Render a view page
    $view = new Template();
    echo $view->render('views/breakfast-menu.html');
});

// define 3rd Route to Lunch menu
$f3->route('GET /menus/lunch', function () {
    // echo '<h1>Welcome, This is Menu!</h1>';

    // Render a view page
    $view = new Template();
    echo $view->render('views/lunch-menu.html');
});

// define 4th Route to dinner menu
$f3->route('GET /menus/dinner', function () {
    // echo '<h1>Welcome, This is Menu!</h1>';

    // Render a view page
    $view = new Template();
    echo $view->render('views/dinner-menu.html');
});

// define 5th Route to Order1 menu
$f3->route('GET|POST /order1', function ($f3) {
    // echo '<h1>Welcome, This is Menu!</h1>';

    // If the form has been posted
    global $f3;
    // If the form has been posted
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        //echo "<p>You got here using the POST method</p>";
        //var_dump ($_POST);

        // Get the data from the post array
        $food = $_POST['food'];
        $meal = $_POST['meal'];

        // If the data valid
//        if (!empty($food) && !empty($meal))
//        {
//            // Add the data to the session array
//            $f3->set('SESSION.food', $food);
//            $f3->set('SESSION.meal', $meal);
//
//            // Send the user to the next form
//            $f3->reroute('order2');
//        }

//        if (!empty($food) && !isset($meal))
//        {
//            // Add the data to the session array
//            $f3->set('SESSION.food', $food);
//            $f3->set('SESSION.meal', $meal);
//
//            // Send the user to the next form
//            $f3->reroute('order2');
//        }

        if (true)
        {
            // Add the data to the session array
            $f3->set('SESSION.food', $food);
            $f3->set('SESSION.meal', $meal);

            // Send the user to the next form
            $f3->reroute('order2');
        }
        else
        {
            // Temporary
            echo "<p>Validation errors</p>";
        }
    }
    // Render a view page
    $view = new Template();
    echo $view->render('views/order1.html');
});

// define 4th Route to dinner menu
$f3->route('GET|POST /order2', function ($f3)
{

//    echo $f3->get('SESSION');

    var_dump($f3->get('SESSION'));
    // echo '<h1>Welcome, This is Menu!</h1>';


    // If the form has been posted
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        //echo "<p>You got here using the POST method</p>";
        var_dump ($_POST);

        // Get the data from the post array

        if (isset($_POST['conds']))
            $condiments = implode(", ", $_POST['conds']);
        else
            $condiments = "None selected";
//        $condiments = $_POST['conds'];
//        $meal = $_POST['meal'];

        // If the data valid
//        if (!empty($food) && !empty($meal))
//        {
//            // Add the data to the session array
//            $f3->set('SESSION.food', $food);
//            $f3->set('SESSION.meal', $meal);
//
//            // Send the user to the next form
//            $f3->reroute('order2');
//        }

//        if (!empty($food) && isset($meal))
//        {
//            // Add the data to the session array
//            $f3->set('SESSION.food', $food);
//            $f3->set('SESSION.meal', $meal);
//
//            // Send the user to the next form
//            $f3->reroute('order2');
//        }

        if (true)
        {
            // Add the data to the session array
            $f3->set('SESSION.condiments', $condiments);
//            $f3->set('SESSION.meal', $meal);

            // Send the user to the next form
            $f3->reroute('summary');
        }
        else
        {
            // Temporary
            echo "<p>Validation errors</p>";
        }
    }

    // Render a view page
    $view = new Template();
    echo $view->render('views/order2.html');
});

// define 2nd Route to breakfast menu
$f3->route('GET /summary', function ($f3) {
    // echo '<h1>Welcome, This is Menu!</h1>';

    var_dump($f3->get('SESSION'));

    // Render a view page
    $view = new Template();
    echo $view->render('views/order-summary.html');
});

// Run Fat-Free
$f3->run();

*/