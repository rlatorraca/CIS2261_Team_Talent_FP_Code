<?php
/**
 * Created by PhpStorm.
 * Author: Steve Martin
 * Purpose: This is the button class.
 * Date: 2018-10-26
 *
 */

class Button
{
    // Private variables declared here. Defines button attributes for external use.
    private $buttonName;
    private $buttonValue;
    private $buttonStyle;

    // Constructor with empty values.
    function __construct()
    {
        $this->buttonName = "";
        $this->buttonValue = "";
        $this->buttonStyle = "";
    }

    // Magic setter method for setting each of the above mentioned attributes.
    function __set($whichOne, $whatVal)
    {
        $this->$whichOne = $whatVal;
    }

    // Magic getter method for getting the button object.
    function __get($whichItem)
    {
        return $this->$whichItem;
    }

    // Displaye function when calling a button to appear.
    function display()
    {
        echo "<input type='submit' class='button button2' value='" . $this->buttonValue . "' style='" . $this->buttonStyle . "' name='" . $this->buttonName . "' />";
    }

}

?>


