<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>
*  			Michael Knoll <mimi@kaktusteam.de>
*  			
*  			
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Controller for the itemList
 *
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */
class Tx_Yag_Controller_ItemListController extends Tx_Yag_Controller_AbstractController {
	
	
	/**
	 * Holds instance of extlist context
	 * 
	 * @var Tx_Yag_Extlist_ExtlistContext
	 */
	protected $extListContext;
	
	
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Controller/Tx_Yag_Controller_AbstractController::initializeAction()
	 */
	public function initializeAction() {
		$extListConfig = $this->configurationBuilder->buildExtlistConfiguration();
		$this->extListContext = new Tx_Yag_Extlist_ExtlistContext($extListConfig->getExtlistSettingsByListId('itemList'), 'itemList');
	}
	
	
	
	/**
	 * Submit a filter and show the images
	 */
	public function submitFilterAction() {
		$this->extListContext->resetPagerCollection();
    	$this->forward('list');
	}

	
	
	/**
	 * Submit a filter and show the images
	 */
	public function resetFilterAction() {
    	$this->extListContext->resetFilterCollection();
    	$this->extListContext->resetPagerCollection();
    	$this->forward('list');
	}
	
	
	
	/**
	 * Show an Item List
	 *
	 * @param int $backFromItemUid sets the item if we come back from singleView
	 * @return string The rendered show action
	 */
	public function listAction($backFromItemUid = NULL) {		
	
		$this->extListContext->getPagerCollection()->setItemsPerPage($this->configurationBuilder->buildItemListConfiguration()->getItemsPerPage());
		
		if($backFromItemUid) {
			$this->extListContext->getPagerCollection()->setPageByRowIndex($backFromItemUid);
		}
		
		$this->extListContext->getPagerCollection()->setItemCount($this->extListContext->getDataBackend()->getTotalItemsCount());
		$pagerIdentifier = (empty($this->settings['pagerIdentifier']) ? 'default' : $this->settings['pagerIdentifier']);
		$pager = $this->extListContext->getPagerCollection()->getPagerByIdentifier($pagerIdentifier);
        
        $pageId = $_GET['id'];
        
        $this->view->assign('pageId', $pageId);
        $this->view->assign('pageIdVar', 'var pageId = ' . $pageId . ';');
		$this->view->assign('listData', $this->extListContext->getRenderedListData());
		$this->view->assign('pagerCollection', $pagerCollection);
		$this->view->assign('pager', $pager);
		
	}
	
}
?>