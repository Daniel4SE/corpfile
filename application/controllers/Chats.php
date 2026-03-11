<?php
/**
 * Chats Controller
 *
 * Full-page AI chat interface.
 */
class Chats extends BaseController {

    public function index() {
        $this->requireAuth();

        $data = [
            'page_title' => 'Chats',
        ];

        $this->loadLayout('chats/index', $data);
    }
}
