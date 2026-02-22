<?php
/**
 * Support Controller - Support Tickets
 * Handles: /support
 */
class Support extends BaseController {
    
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Support Tickets',
            'tickets' => [],
        ];
        $this->loadLayout('support/index', $data);
    }
}
