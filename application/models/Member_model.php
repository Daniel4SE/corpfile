<?php
/**
 * Member Model
 * Handles all member-related database queries
 */
class Member_model extends BaseModel {
    protected $table = 'members';

    /**
     * Get all members for a client
     */
    public function getByClientId($clientId) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE client_id = ? 
                ORDER BY name ASC";
        return $this->db->fetchAll($sql, [$clientId]);
    }

    /**
     * Get member with joined identification records
     */
    public function getWithIdentifications($id) {
        $member = $this->getById($id);
        if ($member) {
            $member->identifications = $this->getIdentifications($id);
        }
        return $member;
    }

    /**
     * Get identification records for a member
     */
    public function getIdentifications($memberId) {
        $sql = "SELECT * FROM member_identifications 
                WHERE member_id = ? 
                ORDER BY id ASC";
        return $this->db->fetchAll($sql, [$memberId]);
    }

    /**
     * Get all addresses for a member
     */
    public function getAddresses($memberId) {
        $sql = "SELECT * FROM addresses 
                WHERE entity_type = 'member' AND entity_id = ?";
        return $this->db->fetchAll($sql, [$memberId]);
    }

    /**
     * Get all company officer roles linked to this member
     * Searches directors, shareholders, and secretaries tables
     */
    public function getCompanyRoles($memberId) {
        $roles = [];

        // Director roles
        $directors = $this->db->fetchAll(
            "SELECT d.*, c.company_name, 'Director' as role_type 
             FROM directors d 
             JOIN companies c ON c.id = d.company_id 
             WHERE d.member_id = ? 
             ORDER BY d.date_of_appointment DESC",
            [$memberId]
        );
        $roles = array_merge($roles, $directors ?: []);

        // Shareholder roles
        $shareholders = $this->db->fetchAll(
            "SELECT s.*, c.company_name, 'Shareholder' as role_type 
             FROM shareholders s 
             JOIN companies c ON c.id = s.company_id 
             WHERE s.member_id = ? 
             ORDER BY s.date_of_appointment DESC",
            [$memberId]
        );
        $roles = array_merge($roles, $shareholders ?: []);

        // Secretary roles
        $secretaries = $this->db->fetchAll(
            "SELECT s.*, c.company_name, 'Secretary' as role_type 
             FROM secretaries s 
             JOIN companies c ON c.id = s.company_id 
             WHERE s.member_id = ? 
             ORDER BY s.date_of_appointment DESC",
            [$memberId]
        );
        $roles = array_merge($roles, $secretaries ?: []);

        return $roles;
    }

    /**
     * Search members by name, ID number, or email
     */
    public function searchMembers($keyword, $clientId = null) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE (name LIKE ? OR id_number LIKE ? OR email LIKE ?)";
        $params = ["%{$keyword}%", "%{$keyword}%", "%{$keyword}%"];

        if ($clientId !== null) {
            $sql .= " AND client_id = ?";
            $params[] = $clientId;
        }

        $sql .= " ORDER BY name ASC";
        return $this->db->fetchAll($sql, $params);
    }
}
