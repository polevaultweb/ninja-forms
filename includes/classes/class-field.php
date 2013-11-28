<?php

class Ninja_Forms_Field
{
	public $field_type = 'base';
	public $el_class = '';
	public $conditional = '';
	public $default_label = '';
	public $default_label_pos = 'left';
	public $default_value = '';
	public $display_label = true;
	public $display_wrap = true;
	public $edit_conditional = true;
	public $edit_custom_class = true;
	public $edit_help = true;
	public $edit_label = true;
	public $edit_label_pos = true;
	public $edit_options = array();
	public $edit_req = true;
	public $esc_html = true;
	public $group = '';
	public $interact = true;
	public $label_pos_options = array();
	public $limit = '';
	public $process_field = true;
	public $req = false;
	public $save_sub = true;
	public $sub_edit = 'text';
	public $use_li = true;
	public $visible = true;

	function __construct() {
		global $test;
		if ( !is_array ( $test ) ) {
			$test = array();
		}
		$test[$this->field_type] = $this;
	}

	public function display() {
		
	}

	public function edit() {

	}

	public function edit_sub_post_process() {

	}

	public function edit_sub_pre_process() {

	}

	public function edit_sub_process() {

	}

	public function post_process() {

	}

	public function pre_process() {

	}

	public function process() {

	}

	public function req_validation() {

	}

	public function save() {

	}

	public function sub_edit() {
		$this->edit();
	}
}

class Ninja_Forms_Field_Text extends Ninja_Forms_Field
{
	public $field_type = '_text';
	public $label = 'Text';
	public function test() {
		echo "I'M A TEXT";
	}
}

function register_ninja_forms_field_text() {
	$text_field = new Ninja_Forms_Field_Text();
}

add_action( 'init', 'register_ninja_forms_field_text' );

class Ninja_Forms_Field_List extends Ninja_Forms_Field
{
	public $field_type = 'list';
	public $label = 'List2';

	public function test() {
		echo "I'M A LIST!";
	}
}