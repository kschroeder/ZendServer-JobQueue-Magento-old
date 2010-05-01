<?php
class ZendServer_JobQueue_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	$params = ZendJobQueue::getCurrentJobParams();
        if (isset($params['obj'])) {
            $obj = unserialize(base64_decode($params['obj']));
            if ($obj instanceof ZendServer_JobQueue_Job_Abstract) {
                try {
                    $obj->run();
                    ZendJobQueue::setCurrentJobStatus(ZendJobQueue::OK);
                    exit;
                } catch (Exception $e) {
                	zend_monitor_set_aggregation_hint(get_class($obj) . ': ' . $e->getMessage());
                	zend_monitor_custom_event('Failed Job', $e->getMessage());
                }
            }
        }
        ZendJobQueue::setCurrentJobStatus(ZendJobQueue::FAILED);
        exit;
    }
}