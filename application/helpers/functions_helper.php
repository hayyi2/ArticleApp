<?php 

function get_option($key = 'app_name')
{
    $CI =& get_instance();
    $CI->load->model('setting/Option_Model');
    return $CI->Option_Model->get_value($key);
}

function get_message_notif()
{
    $CI =& get_instance();
    $CI->load->model('message/Message_Model');
    return count($CI->Message_Model->gets_view_unread_inbox());
}

function get_order_notif()
{
    $CI =& get_instance();
    $CI->load->model('order/Order_Model');
    return count($CI->Order_Model->gets_view_unread_order());
}

function get_comment_notif()
{
    $CI =& get_instance();
    $CI->load->model('comment/Comment_Model');
    return count($CI->Comment_Model->gets_view_unread_comment());
}

function array_input_filter( $data, $allowed )
{
    foreach ($data as $key => $value) 
        if( !in_array($key, $allowed) ) 
            unset($data[$key]);

    return $data;
}
function filter_no_empty( $data )
{
    foreach ($data as $key => $value) 
        if( $value == "" ) unset($data[$key]);

    return $data;
}

function isAssoc($array)
{
    return array_keys($array) !== range(0, count($array) - 1);
}

function array_set_key($args, $key){
    $data = array();
    foreach ($args as $value) {
        $data[$value->$key] = $value;
    }
    return $data;
}

function set_message_flash($content, $type = "danger"){
    $CI =& get_instance();
    $data = array('type' => $type,'content' => $content, );
    $CI->session->set_flashdata('message', $data);
}

function get_message_flash(){
    $CI =& get_instance();
    $session_flash = $CI->session->flashdata('message');
    if (isset($session_flash)){
        $CI->session->unset_userdata('message');
        $message = $session_flash;
        ?>
            <div class="alert alert-<?php echo $message['type']; ?>">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <?php echo $message['content']; ?>
            </div>
        <?php
    }
}


function slug($text)
{
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    $text = trim($text, '-');
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = strtolower($text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    if (empty($text)){
        return 'n-a';
    }
    return $text;
}

function get_lost($data, $cut_data){
    $id_lost = array();

    if (is_null($cut_data)) return $data;

    foreach ($data as $key => $value) {
        $not_find = true;
        foreach ($cut_data as $key2 => $value2) {
            if ($key == $key2) {
                $not_find = false;
                break;
            }
        }
        if ($not_find) {
            $id_lost[] = $key;
        }
    }

    return $id_lost;
}