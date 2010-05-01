<?php

class ZendServer_JobQueue_Model_Mock extends ZendServer_JobQueue_Job_Abstract
{
	protected function _execute()
	{
		error_log('Mock Model run');
	}	
}