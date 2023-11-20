<?php class siswaModel extends CI_Model
{
    function fetch_all()
    {
        $this->db->order_by('id','DESC');
        $query = $this->db->get('siswa');
        return $query->result_array();
    }
    function fetch_single_data($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get('siswa');
        return $query-> row();
    }
    function check_data($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get('siswa');

        if($query->row())
        {
            return true;
        }else{
            return false;
        }
    }
    function insert_api($data)
    {
        $this->db->insert('siswa', $data);
        if($this->db->affected_rows() > 0)
        {
            return true;
        }else {
            return false;
        }
    }
    function update_data($id,$data)
        {
            $this->db->where('id',$id);
            $this->db->update('siswa',$data);
        }
    function delete_data($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('siswa');
        if ($this->db->affected_rows()>0){
            return true;
        }
        else
        {
            return false;
        }
    }
}
