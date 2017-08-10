<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Backup_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    /*
     * Default CRUD
     */

    public function get($id = 0)
    {
        if ($id > 0) {
            return $this->db->get_where('db_backups', ['id' => $id])->row();
        } else {
            $this->db->select("b.*, CONCAT(u.first_name, ' ', u.last_name) as user_name");
            $this->db->join('user u', 'u.id = b.user_id', 'left');
            $this->db->order_by('b.date_created', 'desc');
            return $this->db->get('db_backups b')->result();
        }
    }

    public function get_last_backup_days_count() 
    {
        $this->db->order_by('id', 'DESC');
        $last_date = $this->db->get_where('db_backups')->row();
        if ($last_date) {
            $last_date = $last_date->date_created;
        } else {
            return 0;
        }
        $now = time(); // or your date as well
        $your_date = strtotime($last_date);
        $datediff = $now - $your_date;
        return floor($datediff / (60 * 60 * 24));
    }

    public function insert($backup)
    {
        return $this->db->insert('db_backups', $backup);
    }

    public function delete($id)
    {
        $result['success'] = false;
        $path = $this->get($id)->path;
        unlink($path);
        if ($this->db->delete('db_backups', ['id' => $id])) {
            $result['success'] = true;
        }
        return $result;
    }

    public function backup($user_id)
    {
        $result = ['success' => false];

        if (ENVIRONMENT === 'development') {
            $path = 'backups/directmail-backup-' .  time() . '.sql';
            $command = 'c:\wamp64\bin\mysql\mysql5.7.14\bin\mysqldump -u root -h localhost directmail property property_comment property_history property_mailing property_replacement download_history download_history_property list list_bullet_point list_category list_paragraph list_testimonial > ' . $path;
        } else {
            $command = 'mysqldump -u directmail -p pogiako123 -h localhost directmail property property_comment property_history property_mailing property_replacement download_history download_history_property list list_bullet_point list_category list_paragraph list_testimonial > ' . $path;
        }
        exec($command);

        if ($this->insert(['path' => $path, 'user_id' => $user_id])) {
            $result['success'] = true;
        }

       // log user action
        $this->dm_library->insert_user_log([
            'user_id' => $this->logged_user->id,
            'log' => "Backup the System."
        ]);

        return $result;
    }

    public function restore($id)
    {
        $result = ['success' => false];        

        $backup = $this->get($id);
        $path = $backup->path;
        if (ENVIRONMENT === 'development') {
            $command = 'c:\wamp64\bin\mysql\mysql5.7.14\bin\mysql -u root -h localhost directmail < ' . $path;
        } else {
            $command = 'mysql -u directmail -p pogiako123 -h localhost directmail < ' . $path;
        }
        exec($command, $output, $return);
        if (!$return) {
            $result['success'] = true;
        }

       // log user action
        $this->dm_library->insert_user_log([
            'user_id' => $this->logged_user->id,
            'log' => "Restored the system using backup with id of " . $id . " and date backup from " . $backup->date_created
        ]);

        return $result;
    }

} 