<?php


/** My Controller class for the Dinner project
 *
 * 328/dinner/controllers/controller.php
 */

class Controller
{
    private $_f3; // Fat-Free Router

    function __construct($_f3)
    {
        $this->_f3 = $_f3;
    }

    function home()
    {
        //echo '<h1>Hello from My Diner App!</h1>';

        // Render a view page
        $view = new Template();
        echo $view->render('views/home-page.html');
    }

    function breakfast()
    {

        //echo '<h1>My Breakfast Menu</h1>';

        // Render a view page
        $view = new Template();
        echo $view->render('views/breakfast-menu.html');
    }

    function lunch()
    {
        //echo '<h1>My Breakfast Menu</h1>';

        // Render a view page
        $view = new Template();
        echo $view->render('views/lunch-menu.html');
    }


    function dinner()
    {

        //echo '<h1>My Breakfast Menu</h1>';

        // Render a view page
        $view = new Template();
        echo $view->render('views/dinner-menu.html');

    }



    function summary()
    {
        // Render a view page
        $view = new Template();
        echo $view->render('views/order-summary.html');


//    var_dump($f3->get('SESSION'));
        session_destroy();
    }


    function order1()
    {

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
                $this->_f3->set('errors["food"]', 'Please enter a food');
            }

            if (isset($_POST['meal']) and Validate::validMeal($_POST['meal']))
            {
                $meal = $_POST['meal'];
            }
            else
            {
                $this->_f3->set('errors["meal"]', 'Please enter a meal');
            }


            // Add the data to the session array
            $order = new Order($food, $meal);
            $this->_f3->set('SESSION.order', $order);

            // Old way (non OOP method)
//        $f3->set('SESSION.food', $food);
//        $f3->set('SESSION.meal', $meal);

            // If there are no errors, Send the user to the next form

            if (empty($this->_f3->get('errors')))
            {
                $this->_f3->reroute('order2');
            }


        }


        // Get the data from the model
        // and add it to the F3 hive
        $meals = DataLayer::getMeals();
        $this->_f3->set('meals', $meals);


        // Render a view page
        $view = new Template();
        echo $view->render('views/order1.html');
    }


    function order2()
    {


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
                $this->_f3->get('SESSION.order')->setCondiments($condiments);

                // Old Way
//            $f3->set('SESSION.condiments', $condiments);

                // Send the user to the next form
                $this->_f3->reroute('summary');
            } else {
                // Temporary
                echo "<p>Validation errors</p>";
            }
        }


        // Get the data from the model
        $conds = DataLayer::getCondiments();
        $this->_f3->set('conds', $conds);

        // Render a view page
        $view = new Template();
        echo $view->render('views/order2.html');

    }
}