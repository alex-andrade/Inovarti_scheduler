<?php
/**
 *
 * @category   Inovarti
 * @package    Inovarti_Scheduler
 * @author     Suporte <suporte@inovarti.com.br>
 */
class Inovarti_Scheduler_Block_Adminhtml_TimelineDetail extends Mage_Adminhtml_Block_Template {

	/**
	 * @var string path to default template
	 */
	protected $_template = 'inovarti_scheduler/timeline_detail.phtml';

	/**
	 * @var Inovarti_Scheduler_Model_Schedule
	 */
	protected $schedule;



	/**
	 * Set schedule
	 *
	 * @param Inovarti_Scheduler_Model_Schedule $schedule
	 * @return Inovarti_Scheduler_Block_Adminhtml_TimelineDetail
	 */
	public function setSchedule(Inovarti_Scheduler_Model_Schedule $schedule) {
		$this->schedule = $schedule;
		return $this;
	}



	/**
	 * Get schedule
	 *
	 * @return Inovarti_Scheduler_Block_Adminhtml_TimelineDetail
	 */
	public function getSchedule() {
		return $this->schedule;
	}

}
