<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the GServers Component
 */
class GServersViewGServers extends JView {

    // Overwriting JView display method
    function display($tpl = null) {
    
        // Get menu parameter
        $itemid = JRequest::getint( 'Itemid' );
        $menu =   &JSite::getMenu();
        $item = $menu->getItem($itemid);
        if($item) $this->param_servertype = $item->params->get('servertype');
        else $this->param_servertype = "";
        
        // Display the view
        parent::display($tpl);
    }
}
