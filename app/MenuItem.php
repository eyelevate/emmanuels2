<?php
namespace App;
use Input;
use Validator;
use Redirect;
use Hash;
use Request;
use Route;
use Response;
use Auth;
use URL;
use Session;
use Laracasts\Flash\Flash;
use View;
use App\Http\Requests;
use App\Job;
use App\User;
use App\Admin;
use App\Role;
use App\Permission;
use App\PermissionRole;
use App\Website;
use App\Company;
use App\Menu;
use App\Page;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model {
	protected $fillable = [];

	public static $rules_add = array(
		'name'=>'required|min:1',
		'menus'=>'required|min:1',
		'page_id'=>'required|min:1'
		);

		public static $rules_edit = array(
		'name'=>'required|min:1',
		'menus'=>'required|min:1',
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
					if(isset($data[$key]['menu_id'])&&$data[$key]['menu_id']!=0) {
						$menu = Menu::find($data[$key]['menu_id']);
						$data[$key]['menu_name'] = $menu->name;
					}
					if(isset($data[$key]['page_id'])&&$data[$key]['page_id']!=0) {
						$page = Page::find($data[$key]['page_id']);
						$data[$key]['page_id'] = isset($page->title)?$page->title:null;
					}
				}
			}
		}

		return $data;
	}
}