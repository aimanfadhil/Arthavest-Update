<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //Memanggil fungsi session Codeigniter
class admin extends CI_Controller {

		function __construct()
  		{
    		parent::__construct();
			//$this->output->enable_profiler(TRUE);
		
  		}

		function index()
  		{
			if($this->session->userdata('arthasession'))
   	 		{
    			$session_data = $this->session->userdata('arthasession');
				$this->load->model('m_admin');
				$table='';
				$table.='
				<script type="text/javascript">
					function set_edit_home(type,id_parent){
						var dt_string = $(\'#f_edit_home\').serialize();
							$.post("'.base_url().'index.php/c_admin/set_edit_home", dt_string, 
							function(respon) 
							{
								if(respon.status=="Fail"){
									alert(respon.msg)
								}
								else{
									alert(respon.msg)
								}
							},
						\'json\');	
					}
				</script>
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">
							Home
						</h1>
	
					</div>
				</div>
				<!-- /.row -->
				'.form_open_multipart('c_admin/set_edit_home').'
				  <div class="form-group">
					  <label for="exampleInputFile">Header Image</label>
					  <input type="file" multiple name="userfile1" size="20" />
					  <input type="file" multiple name="userfile2" size="20" />
					  <input type="file" multiple name="userfile3" size="20" />
					</div>
	
					<div class="save-button">
					  <button type="button"  class="btn btn-default">Cancel</button>
					  <button type="submit"  class="btn btn-primary">Save</button>
					</div>
				</form>	
				';
				$query=$this->m_admin->select_image_home();
				$row1 = $query->row(0);
				$row2 = $query->row(1);
				$row3 = $query->row(2);
				$table.=$row1->id_img.' '.$row2->id_img.' '.$row3->id_img;
				$data['content']=$table;	
				
				$this->load->view('header_admin');
				$this->load->view('body_admin',$data);
				$this->load->view('footer_admin');
			}
			
			
			else
			{
				//Jika tidak ada session di kembalikan ke halaman login
				redirect('login', 'refresh');
			}
		}
		function logout(){
			$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
			$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
			$this->output->set_header('Pragma: no-cache');
			$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			$this->session->unset_userdata('arthasession');
   			session_destroy();
			redirect('login', 'refresh');
		}
		function cek(){
			$this->load->view('adm_menu');
		}
		function home(){
			$this->load->model('m_admin');
			$table='';
			$table.='
			<script type="text/javascript">
				function set_edit_home(type,id_parent){
					var dt_string = $(\'#f_edit_home\').serialize();
						$.post("'.base_url().'index.php/c_admin/set_edit_home", dt_string, 
						function(respon) 
						{
							if(respon.status=="Fail"){
								alert(respon.msg)
							}
							else{
								alert(respon.msg)
							}
						},
					\'json\');	
				}
			</script>
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Home
					</h1>

				</div>
			</div>
			<!-- /.row -->
			'.form_open_multipart('c_admin/set_edit_home').'
			  <div class="form-group">
				  <label for="exampleInputFile">Header Image</label>
				  <input type="file" multiple name="userfile1" size="20" />
				  <input type="file" multiple name="userfile2" size="20" />
				  <input type="file" multiple name="userfile3" size="20" />
				</div>

				<div class="save-button">
				  <button type="button"  class="btn btn-default">Cancel</button>
				  <button type="submit"  class="btn btn-primary">Save</button>
				</div>
			</form>	
			';
			$query=$this->m_admin->select_image_home();
			$row1 = $query->row(0);
			$row2 = $query->row(1);
			$row3 = $query->row(2);
			$table.=$row1->id_img.' '.$row2->id_img.' '.$row3->id_img;
			$data['content']=$table;	
			
			$this->load->view('header_admin');
			$this->load->view('body_admin',$data);
			$this->load->view('footer_admin');
		}
		
		
		function edit_menu($parent='',$lvl_menu='',$id_menu=''){
			$this->load->model('m_admin');
			$cekmenu=$this->m_admin->cek_exist(@$parent,@$lvl_menu,@$id_menu);
			if($cekmenu==0){
				$table= '<h3>Tidak Ada Data</h3>';	
			}
			else{
				$menuname=$this->m_admin->get_menu_name(@$id_menu);
				if(@$lvl_menu==1){
					$head='<h2>Edit Menu '.$menuname.'</h2>';	
				}
				else{
					$head='<h2>Edit Submenu '.$menuname.'</h2>';	
				}
				$table='';
				$table.='
				<script type="text/javascript">
					function delete_menu(id_menu){
						var ask = confirm("Are you sure to delete this ?");
						if(ask){
							$.post("'.base_url().'index.php/c_admin/delete_menu/"+id_menu, \'\', 
								function(respon) 
								{
									if(respon.status=="Fail"){
										alert(respon.msg)
									}
									else{
										alert(respon.msg)
										window.location.href = "'.base_url().'index.php/admin/home";
									}
								},
							\'json\');	
						}
					}
					function set_edit_menu(){
						var dt_string = $(\'#f_edit_menu\').serialize();
							$.post("'.base_url().'index.php/c_admin/set_edit_menu", dt_string, 
							function(respon) 
							{
								if(respon.status=="Fail"){
									alert(respon.msg)
								}
								else{
									alert(respon.msg)
								}
							},
						\'json\');	
					}
				</script>
					<br/>
					  <div class="save-button">
						<button type="button" onclick="delete_menu(\''.@$id_menu.'\')"  class="btn btn-danger">Delete</button>
					  </div>
					  <br><br>
						'.$head.'
						<br/>
						<div class="row">
						'.form_open_multipart('c_admin/set_edit_menu').'	
							<div class="col-lg-12">
							  <select class="form-control" id="lang" name="lang">
								';
								$get_language=$this->m_admin->get_lang();
								foreach($get_language as $gl):
									$table.='
										<option value="'.$gl->id_language.'">'.$gl->language_name.'</option>
									';
								endforeach;
					$table.='			
							  </select>
							  <div class="form-group">
								  <label for="title">Title</label>
								  <input type="text" class="form-control" id="menu_name" name="menu_name" value="'.$this->m_admin->get_menu_name($id_menu).'" >
								  <input type="text" class="form-control" id="id_menu" name="id_menu" value="'.$id_menu.'" >
							  </div>
							  <div class="form-group">
								<label for="h_image">Header Image</label>
								<input type="file" id="userfile" name="userfile" value=""> >< '.$this->m_admin->get_img_name($id_menu).'
							  </div>
							  <textarea class="ckeditor" cols="10" rows="40" id="isi" name="isi">'.$this->m_admin->get_isi($id_menu).'</textarea>
							  <br/>
								  <div id="exc_but">
									  <button type="button"  class="btn btn-default">Cancel</button>
									  <button type="submit"  class="btn btn-default">Save</button>   
								  </div>
							  </form>
							</div>
						</div>
						<!-- /.row -->
				';
			}
			$data['content']=$table;	
			
			$this->load->view('header_admin');
			$this->load->view('body_admin',$data);
			$this->load->view('footer_admin');
		}
		
		function send(){
			if($this->session->userdata('level')=='Admin'){
				$this->load->view('header_admin');
				$this->load->view('v_send');
				$this->load->view('footer');	
			}
			else{
				redirect('home', 'refresh');		
			}
		}
		function export(){
			if($this->session->userdata('level')=='Admin'){
				$this->load->view('header_admin');
				$this->load->view('v_export');
				$this->load->view('footer');	
			}
			else{
				redirect('home', 'refresh');		
			}	
		}
		
		function rules(){
			$this->load->view('header_admin');
			$this->load->view('v_rules');
			$this->load->view('footer');		
		}
		function about(){
			$this->load->view('header_super');
			$this->load->view('about');
			$this->load->view('footer');
		}
		
		
 }
	
	
?>