<?php
 


// submit post from prontend to custom post
if (isset($_POST['title']) ) {

  $title = $_POST['title'];
  $desc = $_POST['desc'];
  $thumb = $_POST['test'];

  $my_post =array(
    'post_type' =>'testimonials',
    'post_title' => $title,
    'post_content' => $desc,
    'post_status' => 'publish',
     
);
  
  wp_insert_post($my_post);

}

// submit post from prontend



// enqueue jquery-form cdn from website
add_action('wp_enqueue_scripts', 'wp_jquery_form');
function wp_jquery_form(){
  wp_enqueue_script('jquery-form'); 
}
// enqueue jquery-form cdn from website


// submit form through ajax
add_action('wp_ajax_contact_us', 'contact_us');
function contact_us(){
  $arr=[];
  wp_parse_str($_POST['contact_us'], $arr);

  global $wpdb;
  global $table_prefix;

  $table = $table_prefix.'contact_us';
  $result = $wpdb->insert($table, [
    "title" =>$arr['title'],
    "description" =>$arr['desc']

    ]); 
 
    if ($result >0) {
      wp_send_json_success("Data Inserted");
    }else{
      wp_send_json_success("Please Try Again");
    }
}
// submit form through ajax
