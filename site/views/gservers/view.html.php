<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the GServers Component
 */
class GServersViewGServers extends JView
{
    // Overwriting JView display method
    function display($tpl = null) 
    {
        $itemid = JRequest::getint( 'Itemid' );
        die($itemid);
//         $menu = new mosMenu( $database );
//         $menu->load( $Itemid );
//         $params = new mosParameters( $menu->params );

        // Display the view
        parent::display($tpl);
    }
}
