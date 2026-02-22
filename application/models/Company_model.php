<?php
/**
 * Company Model
 * Handles all company-related database queries
 */
class Company_model extends BaseModel {
    protected $table = 'companies';

    /**
     * Get all companies for a client
     */
    public function getByClientId($clientId) {
        $sql = "SELECT c.*, ct.type_name as company_type_name 
                FROM {$this->table} c 
                LEFT JOIN company_types ct ON ct.id = c.company_type_id
                WHERE c.client_id = ? 
                ORDER BY c.company_name ASC";
        return $this->db->fetchAll($sql, [$clientId]);
    }

    /**
     * Get company with its type information
     */
    public function getWithType($id) {
        $sql = "SELECT c.*, ct.type_name as company_type_name 
                FROM {$this->table} c 
                LEFT JOIN company_types ct ON ct.id = c.company_type_id 
                WHERE c.id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    /**
     * Get all directors for a company
     */
    public function getDirectors($companyId) {
        $sql = "SELECT * FROM directors 
                WHERE company_id = ? 
                ORDER BY status DESC, date_of_appointment DESC";
        return $this->db->fetchAll($sql, [$companyId]);
    }

    /**
     * Get all shareholders for a company
     */
    public function getShareholders($companyId) {
        $sql = "SELECT * FROM shareholders 
                WHERE company_id = ? 
                ORDER BY status DESC";
        return $this->db->fetchAll($sql, [$companyId]);
    }

    /**
     * Get all secretaries for a company
     */
    public function getSecretaries($companyId) {
        $sql = "SELECT * FROM secretaries 
                WHERE company_id = ? 
                ORDER BY status DESC";
        return $this->db->fetchAll($sql, [$companyId]);
    }

    /**
     * Get all auditors for a company
     */
    public function getAuditors($companyId) {
        $sql = "SELECT * FROM auditors 
                WHERE company_id = ? 
                ORDER BY status DESC";
        return $this->db->fetchAll($sql, [$companyId]);
    }

    /**
     * Get all addresses for a company
     */
    public function getAddresses($companyId) {
        $sql = "SELECT * FROM addresses 
                WHERE entity_type = 'company' AND entity_id = ?";
        return $this->db->fetchAll($sql, [$companyId]);
    }

    /**
     * Get all events for a company
     */
    public function getEvents($companyId) {
        $sql = "SELECT * FROM company_events 
                WHERE company_id = ? 
                ORDER BY fye_date DESC";
        return $this->db->fetchAll($sql, [$companyId]);
    }

    /**
     * Get company statistics for a client
     * Returns counts by status: total, pre-incorp, active, non-client
     */
    public function getStats($clientId) {
        $stats = [
            'total' => 0,
            'pre_incorp' => 0,
            'active' => 0,
            'non_client' => 0,
        ];

        $stats['total'] = $this->count('client_id = ?', [$clientId]);
        $stats['pre_incorp'] = $this->count(
            "client_id = ? AND internal_css_status = 'Pre-Incorporation'",
            [$clientId]
        );
        $stats['active'] = $this->count(
            "client_id = ? AND internal_css_status = 'Active'",
            [$clientId]
        );
        $stats['non_client'] = $this->count(
            "client_id = ? AND is_non_client = 1",
            [$clientId]
        );

        return $stats;
    }
}
