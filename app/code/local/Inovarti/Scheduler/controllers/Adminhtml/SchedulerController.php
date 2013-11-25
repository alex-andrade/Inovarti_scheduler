<?php

require_once Mage::getModuleDir('controllers', 'Inovarti_Scheduler').'/Adminhtml/AbstractController.php';

/**
 *
 * @category   Inovarti
 * @package    Inovarti_Scheduler
 * @author     Suporte <suporte@inovarti.com.br>
 */
class Inovarti_Scheduler_Adminhtml_SchedulerController extends Inovarti_Scheduler_Adminhtml_AbstractController {



	/**
	 * Mass action: delete
	 *
	 * @return void
	 */
	public function deleteAction() {
		$ids = $this->getRequest()->getParam('schedule_ids');
		foreach ($ids as $id) {
			$schedule = Mage::getModel('cron/schedule')->load($id)->delete(); /* @var $schedule Mage_Cron_Model_Schedule */
		}
		Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Deleted task(s) "%s"', implode(', ', $ids)));
		$this->_redirect('*/*/index');
	}

}
