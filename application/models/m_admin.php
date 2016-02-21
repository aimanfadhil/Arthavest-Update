<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class m_admin extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
	
   	
	function get_lang(){
		$sql="select * from t_language
			 ";	
		$query= $this->db->query($sql);
		return $query->result();	 
	}
	
	function set_isi($id_menu,$text){
		if($id_menu==1){
			
		}
		else{
			$sql="select count(id_menu) as total from t_body 
						where 
						id_menu='".$id_menu."' 
						";
			$query = $this->db->query($sql);	
			$row = $query->row();
			$cek = $row->total;
			if($cek==0){
					
			}
		}
	}
	
	
	function cek_exist($parent,$lvl_menu,$id_menu){
		$sql="select count(id_menu) as total from t_menu 
					where 
					id_menu='".$id_menu."' and id_parent='".$parent."' and lvl_menu='".$lvl_menu."'
					";
		$query = $this->db->query($sql);	
		$row = $query->row();
		return $row->total;		
	}
	
	function get_menu_detail($id_menu){
		$sql="select * from t_menu a left outer join t_body b on a.id_menu = b.id_menu 
				left outer join t_head_img c on a.id_menu = c.id_menu
					where a.id_menu = '".$id_menu."'
					LIMIT 1";
		$query = $this->db->query($sql);	
		return $query->result();			
	}
	function get_max_parent(){
		$sql="select max(id_parent) as maxi from t_menu
			 ";	
		$query= $this->db->query($sql);	
		$row= $query->row();
		return $row->maxi;
	}
	function get_parent_name($parent){
		$sql="select menu_name from t_menu where id_parent=".$parent." and lvl_menu=1
			 ";	
		$query= $this->db->query($sql);	
		$row= $query->row();
		return $row->menu_name;
	}
	function get_menu_name($id_menu){
		$sql="select menu_name from t_menu where id_menu=".$id_menu." 
			 ";	
		$query= $this->db->query($sql);	
		$row= $query->row();
		return $row->menu_name;
	}
	function get_img_name($id_menu){
		$sql="select image_name from t_head_img where id_menu=".$id_menu." 
			 ";	
		$query= $this->db->query($sql);	
		@$row= $query->row();
		return @$row->image_name;
	}
	function get_child($id_menu){
		$sqlcek = "select lvl_menu from t_menu where id_menu = '".$id_menu."'";
		$querycek= $this->db->query($sqlcek);
		$rowcek = $querycek->row();
		if($rowcek->lvl_menu > 1){
			$sql="select * from t_menu where id_parent in (select id_parent from t_menu where id_menu = '".$id_menu."')";
		}
		else{
			$sql="select * from t_menu where id_menu = '".$id_menu."'";	
		}
		
		$query = $this->db->query($sql);
		return $query->result();
	}
	function get_isi($id_menu){
		$sql="select isi_menu from t_body where id_menu=".$id_menu." 
			 ";	
		$query= $this->db->query($sql);	
		@$row= $query->row();
		return @$row->isi_menu;
	}
	function del_menu($id_parent,$lvl_menu){
		$sql="delete from t_menu where id_parent = ".$id_parent." and lvl_menu >= ".$lvl_menu."
			 ";	
		$query= $this->db->query($sql);	
		if($query){
			return TRUE;	
		}
		else{
			return FALSE;	
		}	
	}
	function update_menu($id_menu,$menu_name){
		$sql="
			update t_menu set menu_name = '".$menu_name."' where id_menu=".$id_menu."
		";	
		$query= $this->db->query($sql);	
		if($query){
			return TRUE;	
		}
		else{
			return FALSE;	
		}
	}
	function update_body($id_menu,$text){
		$cek="select * from t_body where id_menu = ".$id_menu."";
		$query_cek=$this->db->query($cek);
		$res_cek=$query_cek->num_rows();
		if($res_cek>0){
			$sql="
				update t_body set isi_menu = '".$text."' where id_menu=".$id_menu."
			";	
			$query= $this->db->query($sql);	
			if($query){
				return TRUE;	
			}
			else{
				return FALSE;	
			}	
		}
		else{
			$sql="
				INSERT INTO `db_arthavest`.`t_body` (
				`id_menu` ,
				`isi_menu`
				)
				VALUES (
				 ".$id_menu.", '".$text."'
				);
			";	
			$query= $this->db->query($sql);	
			if($query){
				return TRUE;	
			}
			else{
				return FALSE;	
			}
		}
	}
	function update_img($id_menu,$img){
		$cek="select * from t_head_img where id_menu = ".$id_menu."";
		$query_cek=$this->db->query($cek);
		$res_cek=$query_cek->num_rows();
		if($res_cek>0){
			$sql="
				update t_head_img set image_name = '".$img."' where id_menu=".$id_menu."
			";	
			$query= $this->db->query($sql);	
			if($query){
				return TRUE;	
			}
			else{
				return FALSE;	
			}	
		}
		else{
			$sql="
				INSERT INTO `db_arthavest`.`t_head_img` (
				`id_menu` ,
				`image_name`
				)
				VALUES (
				 ".$id_menu.", '".$img."'
				);
			";	
			$query= $this->db->query($sql);	
			if($query){
				return TRUE;	
			}
			else{
				return FALSE;	
			}
		}
	}
	function del_image($id_menu){
		$sql="delete from t_head_img where id_menu = ".$id_menu." 
			 ";	
		$query= $this->db->query($sql);	
		if($query){
			return TRUE;	
		}
		else{
			return FALSE;	
		}	
	}
	function insert_image($i,$id_menu,$name){
		$cek = "select count(id_img) as cek from t_head_img where id_menu='".$id_menu."'";
		$querycek = $this->db->query($cek);
		$row = $querycek->row();
		if($row->cek >= 3){
			$sql="
					update t_head_img set image_name = '".$name."' where id_img = '".$i."'
				 ";	
			$query= $this->db->query($sql);	
			if($query){
				return TRUE;	
			}
			else{
				return FALSE;	
			}	
		}
		else{
			$sql="
					INSERT INTO `db_arthavest`.`t_head_img` (
					`id_menu` ,
					`image_name`
					)
					VALUES (
					 ".$id_menu.", '".$name."'
					);
				 ";	
			$query= $this->db->query($sql);	
			if($query){
				return TRUE;	
			}
			else{
				return FALSE;	
			}	
		}
	}
	function select_image_home(){
		$sql = "select * from t_head_img where id_menu=1 order by id_img asc";
		$query = $this->db->query($sql);
		return $query;
	}
	function set_add_menu($id_parent,$title,$lang){
		$sql="INSERT INTO `db_arthavest`.`t_menu` (
			`id_parent` ,
			`menu_name` ,
			`lvl_menu` ,
			`id_language`
			)
			VALUES (
			".$id_parent.", '".$title."', 1, ".$lang."
			);
			 ";	
		$query= $this->db->query($sql);	
		if($query){
			return TRUE;	
		}
		else{
			return FALSE;	
		}
	}
	function set_add_menu_sub($id_parent,$title,$lvl_menu,$lang){
		$sql="INSERT INTO `db_arthavest`.`t_menu` (
			`id_parent` ,
			`menu_name` ,
			`lvl_menu` ,
			`id_language`
			)
			VALUES (
			".$id_parent.", '".$title."', ".$lvl_menu.", ".$lang."
			);
			 ";	
		$query= $this->db->query($sql);	
		if($query){
			return TRUE;	
		}
		else{
			return FALSE;	
		}
	}
	function get_detail($id_menu){
		$sql="select * from t_menu where id_menu=".$id_menu."";
		$query=$this->db->query($sql);
		return $query->row();
	}
}
