<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Menu extends Model {
	protected $fillable = [];

	public static $rules_add = array(
		'name'=>'required|min:1',
		'kind'=>'required|min:1'
		);
	public static $rules_add_link = array(
		'name'=>'required|min:1',
		'kind'=>'required|min:1',
		'page_id'=>'required|min:1'
		);


	public static function prepare($data){
		if(isset($data)){
			foreach ($data as $key => $value) {
				if(isset($data[$key]['status'])) {
					switch ($data[$key]['status']) {
						case 1:// Created by user
						$data[$key]['status_html'] = '<span class="label label-primary">Created</span>';
						break;
						case 2:// Accepted by owner
						$data[$key]['status_html'] = '<span class="label label-info">Accepted</span>';
						break;
						default://errors
						$data[$key]['status_html'] = '<span class="label label-danger">Error</span>';
						break;
					}
				}
				if(isset($data[$key]['start'])) {
					$data[$key]['start'] = date ( 'n/d/Y g:ia',  strtotime($data[$key]['start']) );
				}
				if(isset($data[$key]['end'])) {
					$data[$key]['end'] = date ( 'n/d/Y g:ia',  strtotime($data[$key]['end']) );
				}
				$data[$key]['page_title'] = "-";
				if(isset($data[$key]['page_id'])&&$data[$key]['page_id']!=0) {
					$page = Page::find($data[$key]['page_id']);
					$data[$key]['page_title'] = isset($page->title)?$page->title:null;
				}
				$data[$key]['kind'] = '';
				if(isset($data[$key]['page_id'])&&$data[$key]['page_id']!=0) {
					$data[$key]['kind'] = '<span class="label label-primary">Link</span>';
				} else {
					$data[$key]['kind'] = '<span class="label label-info">Menu Group</span>';
				}

			}
		}


		return $data;
	}
	public static function prepareSelect()
	{
		return array(
			'' => 'Select Type',
			'1'	=> 'Connect to created page',
			'2' => 'Creates menu group section'
			);
	}

	public static function prepareForSelect($data) {
		$pages = array(''=>'Select Menu');
		if(isset($data)) {
			foreach ($data as $key => $value) {
				$page_id = $value['id'];
				$page_name = $value['name'];
				$pages[$page_id] = $page_name; 
			}
		}

		return $pages;
	}
	public static function prepareNestable($menus,$menu_items) {
		$html = '';
		if (isset($menus,$menu_items)) {
			$html .= '<div class="dd" id="nestable3">';
				$html .= '<ol class="dd-list">';
				foreach ($menus as $key => $value) {
					// Job::dump($value);
					if (isset($value->page_id)) { //MENU LINKS
						$html .= '<li class="dd-item dd3-item" data-id="'.$value->id.'">';
							$html .= '<input type="hidden" class="menu menu-link" name="menu['.$value->id.']" value="">';
							$html .= '<input type="hidden" class="menu-order" name="menu['.$value->id.'][order]" value="">';
							$html .= '<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">'.$value->name.'</div>';
						$html .= '</li>';
					} else { //MENU GROUPS
						$html .= '<li class="dd-item dd3-item" data-id="'.$value->id.'">';
							$html .= '<input type="hidden" class="menu menu-group" name="menu['.$value->id.']" value="">';
							$html .= '<input type="hidden" class="menu-order" name="menu['.$value->id.'][order]" value="">';
							$html .= '<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">'.$value->name.'</div>';
							$html .= '<ol class="dd-list">';
							foreach ($menu_items as $mikey => $mivalue) { //FOR EACH MENU ITEMS
								if ($mivalue->menu_id == $value->id) { //THIS MENU ITEM BELONGS TO THIS GROUP
									$html .= '<li class="dd-item dd3-item" data-id="'.$mivalue->id.'">';
									$html .= '<input type="hidden" class="menu-item" parent_id="'.$value->id.'" name="menu['.$value->id.'][item]['.$mivalue->id.']" value="'.$mivalue->id.'">';
									$html .= '<input type="hidden" class="menu-item-order" parent_id="'.$value->id.'" name="menu['.$value->id.'][item]['.$mivalue->id.'][order]" value="">';
									$html .= '<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">'.$mivalue->name.'</div>';
									$html .= '</li>';
								}
							}
							$html .= '</ol>';
						$html .= '</li>';
					}
				}//End of menus for loop
				$html .= '</ol>';
			$html .= '</div>';

		}

		return $html;
	}


	public static function prepareOptions($menus) {
		// Job::dump($content);
		$html = '';
		if (isset($menus)) {
				$count = 0;
			foreach ($menus as $key => $value) {
				if ($count == 0) {
					$html .= '<option value='.$key.' selected="selected">'.$value.'</option>';
				}else {
					$html .= '<option value='.$key.'>'.$value.'</option>';
				}
				$count++;
			}
		}
		return $html;
	}




}