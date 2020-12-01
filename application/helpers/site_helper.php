<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Este helper gera os elementos do bootstrap 3 usando PHP
| ao invés de HTML puro.
|
| Foi desenvolvido para ser usado no FrameWork CodeIgniter em conjunto
| com o helper HTML e URL.
| 
| @author Eliel de Paula <elieldepaula@gmail.com>
| @since 20/10/2014
|--------------------------------------------------------------------------
*/




if ( ! function_exists( 'newid' ) ) {
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function newid( $string = null )
	{
		return CNF_PREFIX. $string;
	}

}


if ( ! function_exists( 'member_url' ) ) {
	

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function member_url( $string = null )
	{
		return site_url('clientzone/'.$string.'');
	}

}



if ( ! function_exists( 'user_image' ) ) {
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function user_image( $url_image = null, $attribut = null )
	{

		$img_data 		= array(
			'src'		=> 'assets/uploads/user/' .$url_image
		);

		foreach ($attribut as $key => $value) {
			$img_data[ $key ] 	= $value;
		}

		return img( $img_data );
	}

}


if ( ! function_exists( 'howdy' ) ) {
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function howdy( $string = 'Guest' )
	{
		$get_hour 		= date('H');
		if ( ($get_hour >= 0) && ($get_hour < 10) ) {
			
			$output_string 		= 'Morning';

		} elseif ( ($get_hour >= 10) && ($get_hour < 21) ) {

			$output_string 		= 'Afternoon';

		} elseif ( $get_hour >= 21 ) {

			$output_string 		= 'Evening';

		}

		return ucwords('Good ' .$output_string. ', ' .$string );

	}

}


if ( ! function_exists( 'user_picture' ) ) {
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function user_picture( $userid 	= 1 )
	{
		
		$user_picture 	= userdata( array( 'id' => $userid ) )->um_picture;

		$image_path = base_url('assets/uploads/user/'.$user_picture );

		return $image_path;
	}

}



if ( ! function_exists('uang'))
{

	function uang( $string, $curency = 'Rp.', $count = 0 )
	{
		return $curency. number_format($string, $count, ',', '.') . ',-';
	}

}



if ( ! function_exists('option'))
{

	function option($option_name ='null')
	{
		$CI 	=& get_instance();
		$get 	= $CI->db->get_where('tb_option', array('option_name' => $option_name) );
		if ( $get->num_rows() == 1 ) {
			return $get->row()->option_value;
		}
	}

}




if ( ! function_exists( 'userid' ) ) {
	
	/**
	 * GET user ID compatible with ion auth session
	 *
	 * @return void
	 * @author 
	 **/
	function userid()
	{
		$CI =& get_instance();
		return $CI->session->userdata('user_id');
	}

}


if ( ! function_exists( 'sekarang' ) ) {

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function sekarang()
	{
		return date('Y-m-d H:i:s');
	}

}


if ( ! function_exists( 'userdata' ) ) {
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function userdata( $where_data = null )
	{
		$CI =& get_instance();

		if ( $where_data != null ):
			foreach ($where_data as $key => $value) :

				$CI->db->where( $key , $value);

			endforeach;
		else:

			$CI->db->where('id', userid() );

		endif;

		// $CI->db->join('tb_users_meta', 'tb_users_meta.um_user_id = tb_users.id', 'left');
		$get 	= $CI->db->get('tb_pelanggan');
		if ( $get->num_rows() == 1 ) {
			
			return $get->row();
			
		} else if ( $get->num_rows() > 1 ) {

			return $get->result();

		}
	}

}



if ( ! function_exists('user_by_username') ) {
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function user_by_username( $username = null )
	{
		$CI =& get_instance();
		$CI->db->where('username', $username);
		$get 	= $CI->db->get('tb_users');
		if ( $get->num_rows() == 1 ) {
			
			return $get->row();

		}
	}

}


if ( ! function_exists('user_by_token') ) {
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function user_by_token( $token = null )
	{
		$CI =& get_instance();
		$CI->db->where('token', $token);
		$get 	= $CI->db->get('tb_users');
		if ( $get->num_rows() == 1 ) {
			
			return $get->row();

		} 
	}

}



if ( ! function_exists( 'user_package' ) ) {
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function user_package( $userid = null )
	{
		
		$CI =& get_instance();

		$user_id 			= ( $userid == null )? $CI->session->userdata('user_id') : $userid;

		$CI->db->select('tb_users.id, tb_users.paket, tb_packages.*');
		$CI->db->join('tb_packages', 'tb_packages.paket_id = tb_users.paket', 'left');
		$CI->db->where('tb_users.id', $user_id);
		$get_data 			= $CI->db->get('tb_users');
		if ( $get_data->num_rows() == 1 ) {
			return $get_data->row();
		}
	}

}


if ( ! function_exists('percentage') ) {
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function percentage( $min = 0, $max = 0 )
	{
		$hitung 		= ( $min / $max ) * 100;
		if ( $hitung <= 100 ) {
			$result 	= $hitung;
		} else {
			$result 	= 100;
		}

		return $result;
	}

}


if ( ! function_exists( 'time_span' ) ) {
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function time_span( $post_date = null, $date_now = null )
	{

		$date1 = new DateTime( $post_date );
		$date2 = new DateTime( date('Y-m-d') );
		$interval = $date1->diff($date2);
		

		if( $interval->days >= 5 ){
			$show_date 	= date('d F Y H:i', strtotime( $post_date ));
		} else {
			$show_date 	= timespan( strtotime( $post_date ), time(), 2 ). ' yang lalu';
		}

		return $show_date;

	}

}


if ( ! function_exists( 'blog_thumbnail' ) ) {
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function blog_thumbnail( $image_name = 'null' )
	{

		$exp 		= explode('.', $image_name);
		$filename 	= $exp[0];
		$file_ext 	= $exp[1];

		//adding thumbnail string 
		return $filename . '_thumb.' . $file_ext;

	}

}


if ( ! function_exists('script_tag'))
{

	function script_tag($src = '', $type = 'text/javascript', $index_page = FALSE)
	{
		$CI =& get_instance();

		$link = '';
		if (is_array($src))
		{
			foreach ($src as $v)
			{
				$link .= script_tag($v,$type,$index_page);
			}

		} else {
			$link = '<script ';
			if ( strpos($src, '://') !== FALSE)
			{
				$link .= 'src="'.$src.'" ';
			}
			elseif ($index_page === TRUE)
			{
				$link .= 'src="'.$CI->config->site_url($src).'" ';
			}
			else
			{
				$link .= 'src="'.$CI->config->slash_item('base_url').$src.'" ';
			}

			$link .= " type='{$type}'></script>";
		}

		return $link;

	}
}


if ( ! function_exists( 'post' ) ) {

	function post( $key = null )
	{
		$return     = null;
		if( $key != null ){

			$CI =& get_instance();
			$return     = $CI->input->post( $key );

		}

		return $return;

	}
}
