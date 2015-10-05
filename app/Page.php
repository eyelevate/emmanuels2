<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


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
use JavaScript;
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
class Page extends Model {
	protected $fillable = [];


	public static $pages_add = array(
		'title'=>'required|min:1',
		'description'=>'required|min:1',
		'url'=>'required|min:1',
		'keywords'=>'required|min:1'
		);
	public static $pages_edit = array(
		'name'=>'required|min:1'
		);

	public static function preparePages($data) {
		if(isset($data)) {
			foreach ($data as $key => $value) {
				$data[$key]['company_name'] = Company::where('id',1)->pluck('name');

				$data[$key]['param_one_formated'] = '';
				if(isset($data[$key]['param_one'])) {
					$data[$key]['param_one_formated'] = '<td class="text-center">'.$data[$key]['param_one'].'</td>';
				} else {

					$data[$key]['param_one_formated'] = '<td class="text-center">-</td>';

				}
				$data[$key]['param_two_formated'] = '';
				if(isset($data[$key]['param_two'])) {
					$data[$key]['param_two_formated'] = '<td class="text-center">'.$data[$key]['param_two'].'</td>';
				} else {

					$data[$key]['param_two_formated'] = '<td class="text-center">-</td>';

				}

			}

		}

		return $data;
	}
	public static function prepareContentArea($count) {
		$html = '';
		$html .= '<div class="panel panel-success content-set" this_set="'.$count.'" style="margin-top:10px;">';

		$html .= '<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"';
		$html .= 'data-parent="#accordion" href="#accordion-'.$count.'" aria-expanded="true" aria-controls="collapseOne"';
		$html .= 'style="cursor: pointer;">';
		$html .= '<h4 class="panel-title">';
		$html .= '<a class="this-title">';
		$html .= 'Section '.($count+1);
		$html .= '</a>';
		$html .= '<a>';
		$html .= '<i class="glyphicon glyphicon-chevron-down pull-right"></i>';
		$html .= '</a>';
		$html .= '</h4>';
		$html .= '</div>';
				//here is the bug
		$html .= '<div id="accordion-'.$count.'" this_set="'.$count.'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">';
		$html .= '<div class="panel-body panel-input">';
		$html .= '<div class="form-group">';
		$html .= '<label class="control-label" for="title">Title</label>';
		$html .= '<input type="text" name="content['.$count.'][content_title]" class="form-control content-title" placeholder="Content Title">';
		$html .= '</div>';
		$html .= '<div class="form-group">';
		$html .= '<label class="control-label" for="content">Content</label>';
		$html .= '<textarea rows="13" name="content['.$count.'][content_body]" style="resize:none;" class="form-control content-body" id="content-body-'.$count.'" placeholder="Content Title"></textarea>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '';
		$html .= '<div class="panel-footer clearfix">';
		$html .= '<button type="button" class="remove-collapse btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
		$html .= '</div>';

		$html .= '</div>';
		return $html;
	}

	public static function prepareForPreview($content) {
		// Job::dump($content);
		$html = '';
		if (isset($content)) {
			foreach ($content as $ckey => $cvalue) {
				$html .= '<h3>'.$cvalue['content_title'].'</h3>';
				$html .= '<p>'.$cvalue['content_body'].'</p>';
			}
		}
		return $html;
	}

	public static function prepareAddFormSession($form) {
		// Job::dump($content);
		$data_array = [];
		if (isset($form)) {
			$data_array['title'] = $form['title'];
			$data_array['description'] = $form['description'];
			$data_array['url'] = $form['url'];
			$data_array['keywords'] = $form['keywords'];
			$data_array['html'] = '';
			$i = 0;
			if (isset($form['content'])) {
				foreach ($form['content'] as $ckey => $cvalue) {

					$data_array['html'][$i] = '';
					$data_array['html'][$i] .= '<div class="panel panel-default content-set" style="margin-top:10px;">';
					$data_array['html'][$i] .= '<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"';
					$data_array['html'][$i] .= 'data-parent="#accordion" href="#accordion-'.$i.'" aria-expanded="true" aria-controls="collapseOne"';
					$data_array['html'][$i] .= 'style="cursor: pointer;">';
					$data_array['html'][$i] .= '<h4 class="panel-title">';
					$data_array['html'][$i] .= '<a class="this-title">';
					$data_array['html'][$i] .= 'Section '.($i+1);
					$data_array['html'][$i] .= '</a>';
					$data_array['html'][$i] .= '<a>';
					$data_array['html'][$i] .= '<i class="glyphicon glyphicon-chevron-down pull-right">&nbsp;&nbsp;</i>';
					$data_array['html'][$i] .= '</a>';
					$data_array['html'][$i] .= '</h4>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '<div id="accordion-'.$i.'" this_set="'.$i.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">';
					$data_array['html'][$i] .= '<div class="panel-body">';
					$data_array['html'][$i] .= '<div class="form-group">';
					$data_array['html'][$i] .= '<label class="control-label" for="title">Title</label>';
					$data_array['html'][$i] .= '<input type="text" name="content['.$i.'][content_title]" value="'.$cvalue['content_title'].'" class="form-control content-title" placeholder="Content Title">';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '<div class="form-group">';
					$data_array['html'][$i] .= '<label class="control-label" for="content">Content</label>';
					$data_array['html'][$i] .= '<textarea name="content['.$i.'][content_body]" style="resize:none;" class="form-control content-body" placeholder="Content Title">'.$cvalue['content_body'].'</textarea>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '<div class="panel-footer clearfix">';
					$data_array['html'][$i] .= '<button type="button" class="remove-collapse btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '</div>';
					$i++;

				}
			}

			
		}
		// Job::dump($form['content']);
		return $data_array;
	}

	public static function prepareEditFormSession($form) {
		// Job::dump($content);
		$data_array = [];
		if (isset($form)) {
			$data_array['page_id'] = $form['page_id'];
			$data_array['title'] = $form['title'];
			$data_array['description'] = $form['description'];
			$data_array['url'] = $form['url'];
			$data_array['keywords'] = $form['keywords'];
			$data_array['status'] = ($form['page_id']!=1)?$form['status']:null;
			$data_array['html'] = '';
			$i = 0;
			if (isset($form['content'])) {
				foreach ($form['content'] as $ckey => $cvalue) {
					$data_array['html'][$i] = '';
					$data_array['html'][$i] .= '<div class="panel panel-default content-set" style="margin-top:10px;">';
					$data_array['html'][$i] .= '<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"';
					$data_array['html'][$i] .= 'data-parent="#accordion" href="#accordion-'.$i.'" aria-expanded="true" aria-controls="collapseOne"';
					$data_array['html'][$i] .= 'style="cursor: pointer;">';
					$data_array['html'][$i] .= '<h4 class="panel-title">';
					$data_array['html'][$i] .= '<a class="this-title">';
					$data_array['html'][$i] .= 'Section '.($i+1);
					$data_array['html'][$i] .= '</a>';
					$data_array['html'][$i] .= '<a>';
					$data_array['html'][$i] .= '<i class="glyphicon glyphicon-chevron-down pull-right">&nbsp;&nbsp;</i>';
					$data_array['html'][$i] .= '</a>';
					$data_array['html'][$i] .= '</h4>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '<div id="accordion-'.$i.'" this_set="'.$i.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">';
					$data_array['html'][$i] .= '<div class="panel-body">';
					$data_array['html'][$i] .= '<div class="form-group">';
					$data_array['html'][$i] .= '<label class="control-label" for="title">Title</label>';
					$data_array['html'][$i] .= '<input type="text" name="content['.$i.'][content_title]" value="'.$cvalue['content_title'].'" class="form-control content-title" placeholder="Content Title">';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '<div class="form-group">';
					$data_array['html'][$i] .= '<label class="control-label" for="content">Content</label>';
					$data_array['html'][$i] .= '<textarea name="content['.$i.'][content_body]" style="resize:none;" class="form-control content-body" placeholder="Content Title">'.$cvalue['content_body'].'</textarea>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '<div class="panel-footer clearfix">';
					$data_array['html'][$i] .= '<button type="button" class="remove-collapse btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '</div>';
					$i++;
				}
			}
		}
		// Job::dump($form['content']);
		return $data_array;
	}

	public static function prepareForEdit($page) {
		// Job::dump($content);
		$data_array = [];
		if (isset($page)) {
			$i = 0 ;
			foreach ($page as $ckey => $cvalue) {
				// for ($i=0; $i < count($form['content']); $i++) { 
				$data_array['html'][$i] = '';
				$data_array['html'][$i] .= '<div class="panel panel-default content-set" style="margin-top:10px;">';
				$data_array['html'][$i] .= '<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"';
				$data_array['html'][$i] .= 'data-parent="#accordion" href="#accordion-'.$i.'" aria-expanded="true" aria-controls="collapseOne"';
				$data_array['html'][$i] .= 'style="cursor: pointer;">';
				$data_array['html'][$i] .= '<h4 class="panel-title">';
				$data_array['html'][$i] .= '<a class="this-title">';
				$data_array['html'][$i] .= 'Section '.($i+1);
				$data_array['html'][$i] .= '</a>';
				$data_array['html'][$i] .= '<a>';
				$data_array['html'][$i] .= '<i class="glyphicon glyphicon-chevron-down pull-right">&nbsp;&nbsp;</i>';
				$data_array['html'][$i] .= '</a>';
				$data_array['html'][$i] .= '</h4>';
				$data_array['html'][$i] .= '</div>';
				$data_array['html'][$i] .= '<div id="accordion-'.$i.'" this_set="'.$i.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">';
				$data_array['html'][$i] .= '<div class="panel-body">';
				$data_array['html'][$i] .= '<div class="form-group">';
				$data_array['html'][$i] .= '<label class="control-label" for="title">Title</label>';
				$data_array['html'][$i] .= '<input type="text" name="content['.$i.'][content_title]" value="'.$cvalue->content_title.'" class="form-control content-title" placeholder="Content Title">';
				$data_array['html'][$i] .= '</div>';
				$data_array['html'][$i] .= '<div class="form-group">';
				$data_array['html'][$i] .= '<label class="control-label" for="content">Content</label>';
				$data_array['html'][$i] .= '<textarea name="content['.$i.'][content_body]" style="resize:none;" class="form-control content-body" placeholder="Content Title">'.$cvalue->content_body.'</textarea>';
				$data_array['html'][$i] .= '</div>';
				$data_array['html'][$i] .= '</div>';
				$data_array['html'][$i] .= '</div>';
				$data_array['html'][$i] .= '<div class="panel-footer clearfix">';
				$data_array['html'][$i] .= '<button type="button" class="remove-collapse btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
				$data_array['html'][$i] .= '</div>';
				$data_array['html'][$i] .= '</div>';
				$i++;
				// }	
			}	
		}
		// Job::dump($form['content']);
		return $data_array;
	}

	public static function prepareStatus()
	{
		return array(
			'1'	=> 'Draft',
			'2' => 'Public'
			);
	} 

	public static function prepareForSelect($data) {
		$pages = array(''=>'Select Page');
		if(isset($data)) {
			foreach ($data as $key => $value) {
				$page_id = $value['id'];
				$page_title = $value['title'];
				$pages[$page_id] = $page_title; 
			}
		}

		return $pages;
	}

	public static function prepareImage($order) {
		$slider = '';
		
		$slider .= '<li class="dd-item dd3-item clearfix" data-id="'.$order.'" from="tmp">';
		$slider .= '<div  order="'.$order.'" class="dd-handle dd3-handdle col-xs-10 col-sm-10 col-lg-10" style="
		"><i class="glyphicon glyphicon-move"></i>&nbsp;'.$order.' </div><div class="remove-img-div col-xs-10 col-sm-2 col-lg-2 pull-right "><a class="btn btn-danger btn-sm remove-img">Remove</a></div>';
		$slider .= '<div class="dd3-content" style="">';
		$slider .= '<div class="row-fluid" style="">';
		$slider .= '<div class="col-md-12" >';
		$slider .= '<input id="input-706-'.$order.'" name="kartik-input-706[]" type="file" class="file-loading">';
		$slider .= '</div>';
		$slider .= '</div>';
		$slider .= '</div>';
		$slider .= '</li>';


		return $slider;
	}

	public static function prepareSliderImagesForEditPage($slider_image) {
		$slider = '';
		if (isset($slider_image)) {
			$session_array = [];
			foreach ($slider_image as $key => $value) {
				$slider .= '<li class="dd-item dd3-item" data-id="'.$key.'" img-name="'.$value[0].'" from="slider">';
				$slider .= '<div image_path="'.$value[0].'"  order="'.$key.'" class="dd-handle dd3-handdle col-md-10" style=""><i class="glyphicon glyphicon-move"></i>&nbsp;'.$key.' </div><div class="remove-img-div col-md-2 pull-right "><a class="btn btn-danger btn-sm remove-img">Remove</a></div>';
				$slider .= '<div class="dd3-content" style="">';
				$slider .= '<div class="row-fluid" style="">';
				$slider .= '<div class="col-md-12" >';
				$slider .= '<input id="input-706-'.$key.'" name="kartik-input-706[]" type="file" class="file-loading">';
				$slider .= '</div>';
				$slider .= '</div>';
				$slider .= '</div>';
				$slider .= '</li>';
				$session_array[$key][0] = $value[0];
				$session_array[$key][1] = "slider";
			}
			Session::put('slidersession',$session_array);
		}
		return $slider;
	}

	public static function prepareSliderImagesForEditPageSession($slider_image) {
		$slider = '';
		if (isset($slider_image)) {
			if ($slider_image != "empty") {
				$session_array = [];
				foreach ($slider_image as $key => $value) {
					$slider .= '<li class="dd-item dd3-item" data-id="'.$key.'" img-name="'.$value[0].'" from="'.$value[1].'">';
					$slider .= '<div image_path="'.$value[0].'"  order="'.$key.'" class="dd-handle dd3-handdle col-md-10" style=""><i class="glyphicon glyphicon-move"></i>&nbsp;'.$key.' </div><div class="remove-img-div col-md-2 pull-right "><a class="btn btn-danger btn-sm remove-img">Remove</a></div>';
					$slider .= '<div class="dd3-content" style="">';
					$slider .= '<div class="row-fluid" style="">';
					$slider .= '<div class="col-md-12" >';
					$slider .= '<input id="input-706-'.$key.'" name="kartik-input-706[]" type="file" class="file-loading">';
					$slider .= '</div>';
					$slider .= '</div>';
					$slider .= '</div>';
					$slider .= '</li>';
					$session_array[$key][0] = $value[0];
					$session_array[$key][1] = $value[1];
				}
				Session::put('slidersession',$session_array);
			}
		}
		return $slider;
	}

	public static function prepareOptions($pages) {
		// Job::dump($content);
		$html = '';
		if (isset($pages)) {
			$count = 0;
			foreach ($pages as $key => $value) {
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

	public static function start_slider_session($images) {
		if (isset($images)) {
			Job::dump($images);
		}
		return null;
	}


	


}