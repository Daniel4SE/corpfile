<?php
/**
 * Notifications Controller - Notifications Page
 * Handles: /notifications, /notifications/mark_all_read
 */
class Notifications extends BaseController {
    
    public function index() {
        $this->requireAuth();
        
        $data = [
            'page_title' => 'Notifications',
            'notifications' => [],
        ];
        
        if ($this->db) {
            $userId = $_SESSION['user_id'] ?? 0;
            $data['notifications'] = $this->db->fetchAll(
                "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 50",
                [$userId]
            );
        }
        
        $this->loadLayout('notifications/index', $data);
    }
    
    /**
     * Mark all notifications as read
     * POST /notifications/mark_all_read
     */
    public function mark_all_read() {
        $this->requireAuth();
        
        if ($this->db) {
            $userId = $_SESSION['user_id'] ?? 0;
            $this->db->update('notifications', ['is_read' => 1], 'user_id = ?', [$userId]);
        }
        
        $this->json(['success' => true, 'message' => 'All notifications marked as read']);
    }
}
