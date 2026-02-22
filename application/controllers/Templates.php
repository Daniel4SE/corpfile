<?php
/**
 * Templates Controller - Template Management & eSign
 * Handles: /templates, /esign
 */
class Templates extends BaseController {
    
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Template Management',
            'templates' => [],
        ];
        $this->loadLayout('templates/index', $data);
    }
}

// eSign Documents (maps to /esign)
class Esign extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'eSign Documents',
            'documents' => [],
        ];
        $this->loadLayout('templates/esign', $data);
    }
}
