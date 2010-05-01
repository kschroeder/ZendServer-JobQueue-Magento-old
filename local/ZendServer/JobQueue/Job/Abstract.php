<?php

abstract class ZendServer_JobQueue_Job_Abstract
{
    const OPT_NAME = 'name';
    const OPT_SCHEDULE = 'schedule';
    const OPT_SCHEDULE_TIME = 'schedule_time';
    	
	protected abstract function _execute();
	
	public final function execute($qOptions = array())
	{
		// Tests should be run via run() not execute()
		$config = Mage::getConfig();		
	    $q = new ZendJobQueue();
	    
	    $jqOpts = $config->getModuleConfig('ZendServer_JobQueue');
	    if (!isset($jqOpts->jobqueue) && !isset($jqOpts->jobqueue->url)) {
	    	throw new ZendServer_JobQueue_Job_Exception('Missing the jobqueue configuration directive');
	    }
	    $qOptions = array_merge(
	        array('name' => get_class($this)),
	        $qOptions
	    );

        $ret = $q->createHttpJob(
        	$jqOpts->jobqueue->url,
            array(
            	'obj' => base64_encode(serialize($this))
            ),
            $qOptions
        );
        return $ret;
	} 
	
	public final function run()
	{
	    $this->_execute();
	}
	
	public function __toString()
	{
		return 'N/A';
	}
}