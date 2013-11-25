<?php

/**
 *
 * @category   Inovarti
 * @package    Inovarti_Scheduler
 * @author     Suporte <suporte@inovarti.com.br>
 */
class Inovarti_Scheduler_Block_Adminhtml_Scheduler_Grid extends Mage_Adminhtml_Block_Widget_Grid {



	/**
	 * Constructor. Set basic parameters
	 */
	public function __construct() {
		parent::__construct();
		$this->setId('scheduler_grid');
		$this->setUseAjax(false);
		$this->setDefaultSort('scheduled_at');
		$this->setDefaultDir('DESC');
		$this->setSaveParametersInSession(true);
	}



	/**
	 * Preparation of the data that is displayed by the grid.
	 *
	 */
	protected function _prepareCollection() {
		$collection = Mage::getModel('cron/schedule')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}



	/**
	 * Add mass-actions to grid
	 *
	 * @return Inovarti_Scheduler_Block_Adminhtml_Cron_Grid
	 */
	protected function _prepareMassaction() {
		$this->setMassactionIdField('schedule_id');
		$this->getMassactionBlock()->setFormFieldName('schedule_ids');
		$this->getMassactionBlock()->addItem('delete', array(
			'label' => Mage::helper('inovarti_scheduler')->__('Delete'),
			'url' => $this->getUrl('*/*/delete'),
		));
		return $this;
	}



	/**
	 * Preparation of the requested columns of the grid
	 *
	 */
	protected function _prepareColumns() {

		$viewHelper = $this->helper('inovarti_scheduler/data');

		$this->addColumn('job_code', array (
			'header' => Mage::helper('inovarti_scheduler')->__('Code'),
			'index' => 'job_code',
			'type' => 'options',
			'options' => Mage::getModel('inovarti_scheduler/collection_crons')->toOptionHash()
		));
		$this->addColumn('created_at', array (
			'header' => Mage::helper('inovarti_scheduler')->__('Created'),
			'index' => 'created_at',
			'frame_callback' => array($viewHelper, 'decorateTimeFrameCallBack')
		));
		$this->addColumn('scheduled_at', array (
			'header' => Mage::helper('inovarti_scheduler')->__('Scheduled'),
			'index' => 'scheduled_at',
			'frame_callback' => array($viewHelper, 'decorateTimeFrameCallBack')
		));
		$this->addColumn('executed_at', array (
			'header' => Mage::helper('inovarti_scheduler')->__('Executed'),
			'index' => 'executed_at',
			'frame_callback' => array($viewHelper, 'decorateTimeFrameCallBack')
		));
		$this->addColumn('finished_at', array (
			'header' => Mage::helper('inovarti_scheduler')->__('Finished'),
			'index' => 'finished_at',
			'frame_callback' => array($viewHelper, 'decorateTimeFrameCallBack')
		));
		$this->addColumn('messages', array (
			'header' => Mage::helper('inovarti_scheduler')->__('Messages'),
			'index' => 'messages',
			'frame_callback' => array($this, 'decorateMessages')
		));
		$this->addColumn('status', array (
			'header' => Mage::helper('inovarti_scheduler')->__('Status'),
			'index' => 'status',
			'frame_callback' => array($viewHelper, 'decorateStatus'),
			'type' => 'options',
			'options' => array(
				Mage_Cron_Model_Schedule::STATUS_PENDING => Mage_Cron_Model_Schedule::STATUS_PENDING,
				Mage_Cron_Model_Schedule::STATUS_SUCCESS => Mage_Cron_Model_Schedule::STATUS_SUCCESS,
				Mage_Cron_Model_Schedule::STATUS_ERROR => Mage_Cron_Model_Schedule::STATUS_ERROR,
				Mage_Cron_Model_Schedule::STATUS_MISSED => Mage_Cron_Model_Schedule::STATUS_MISSED,
				Mage_Cron_Model_Schedule::STATUS_RUNNING => Mage_Cron_Model_Schedule::STATUS_RUNNING,
			)
		));

		return parent::_prepareColumns();
	}



	/**
	 * Decorate message
	 *
	 * @param string $value
	 * @param Inovarti_Scheduler_Model_Schedule $row
	 * @return string
	 */
	public function decorateMessages($value, Inovarti_Scheduler_Model_Schedule $row) {
		$return = '';
		if (!empty($value)) {
			$return .= '<a href="#" onclick="$(\'messages_'.$row->getScheduleId().'\').toggle(); return false;">'.Mage::helper('inovarti_scheduler')->__('Message').'</a>';
			$return .= '<div class="schedule-message" id="messages_'.$row->getScheduleId().'" style="display: none; width: 300px; overflow: auto; font-size: small;"><pre>'.$value.'</pre></div>';
		}
		return $return;
	}



	/**
	 * Helper function to do after load modifications
	 *
	 * @return void
	 */
	protected function _afterLoadCollection() {
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}



	/**
	 * Helper function to add store filter condition
	 *
	 * @param Mage_Core_Model_Mysql4_Collection_Abstract $collection Data collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column Column information to be filtered
	 * @return void
	 */
	protected function _filterStoreCondition($collection, $column) {
		if (!$value = $column->getFilter()->getValue()) {
			return;
		}
		$this->getCollection()->addStoreFilter($value);
	}



	/**
	 * Helper function to receive grid functionality urls for current grid
	 *
	 * @return string Requested URL
	 */
	public function getGridUrl() {
		return $this->getUrl('adminhtml/scheduler/index', array('_current' => true));
	}

}
