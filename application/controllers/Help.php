<?php
/**
 * Help Controller - Documentation / Knowledge Base
 * Handles: /help, /help/article/{id}, /help/category/{id}
 */
class Help extends BaseController {

    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Help Center',
            'categories' => [],
            'articles' => [],
        ];
        $this->loadLayout('help/index', $data);
    }

    public function article($id = null) {
        $this->requireAuth();
        $data = [
            'page_title' => 'Help Article',
            'article' => null,
        ];
        $this->loadLayout('help/article', $data);
    }

    public function article_redirect($id = null) {
        $this->requireAuth();
        // Redirect article_redirect URLs to the article page
        if ($id) {
            $cleanId = preg_replace('/[^0-9]/', '', $id);
            if ($cleanId) {
                $this->redirect("help/article/{$cleanId}");
                return;
            }
        }
        $this->redirect('help');
    }

    public function category($id = null) {
        $this->requireAuth();
        $data = [
            'page_title' => 'Help Category',
            'category' => null,
            'articles' => [],
        ];
        $this->loadLayout('help/category', $data);
    }

    public function staff_login() {
        $this->requireAuth();
        $this->redirect('help');
    }
}
