<?php
    /**
     * Created by PhpStorm.
     * Company: Team Talent 2.0
     * Authors: John, Rodrigo, Sara, Steve
     * Date: 2/14/2019
     *
     * This is a button class, used in a variety of places to maintain consistency with buttons
     *
     * This page requires: stars.css, index.php.
     *
     */

    class Button
    {
        // Private variables declared here. Defines button attributes for external use.
        private $buttonName;
        private $buttonValue;
        private $buttonStyle;
        private $buttonWeb;

        // Constructor with empty values.
        function __construct()
        {
            $this->buttonName = "";
            $this->buttonValue = "";
            $this->buttonStyle = "";
            $this->buttonWeb = "";
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
            echo "<input type='submit' onclick='" . $this->buttonWeb . "' class='button button2' value='" . $this->buttonValue . "' style='" . $this->buttonStyle . "' name='" . $this->buttonName . "' />";
        }

    }

?>


