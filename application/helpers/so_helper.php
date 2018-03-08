<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*	type untuk success||danger||warning||
*	title untuk penamaan alert
*	bold untuk bold
*	message untuk pesannya
*/
function alert($title, $type, $bold, $message,$php = true)
{
	$CI =& get_instance();

	if ($php) {
		$CI->session->set_flashdata($title,"
											<div class='alert alert-".$type."' alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong>".$bold." </strong>".$message."</div>
		");
	}
	else{
		echo "<div class='alert alert-".$type." alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>".$bold."</strong> ".$message."</div>";
	}
}