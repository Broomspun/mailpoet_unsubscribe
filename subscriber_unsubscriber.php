    
$account_first_name = !empty($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
$account_last_name = !empty($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
$account_email = !empty($_POST['user_email']) ? sanitize_text_field($_POST['user_email']) : '';        

if (isset($_POST['subscriber'])) { //checkbox 
            update_user_meta($user->ID, 'mailpoet_subscriber', intval($_POST['subscriber']));
            $user_data = array(
                'email' => $account_email,
                'firstname' => $account_first_name,
                'lastname' => $account_last_name);

            $model_list = WYSIJA::get('list','model');
            $mailpoet_lists = $model_list->get(array('name','list_id'),array('is_enabled'=>1));

//this loop will just echo the information selected for each list

            $list_ids = array();

            foreach($mailpoet_lists as $list){
                $list_ids[] = $list['list_id'];
            }

            $data_subscriber = array(
                'user' => $user_data,
                'user_list' => array('list_ids'=>$list_ids),
            );

            $helper_user = WYSIJA::get('user','helper');
            $sub_user_id = $helper_user->addSubscriber($data_subscriber);
           
            wp_update_user($user);
        }else {
           
            $helper_user = WYSIJA::get('user','helper');

           $model_user = WYSIJA::get('user', 'model');
           $sub_user_id =  $model_user->user_id($current_user->user_email);

            if(!empty($sub_user_id)) {
                $retuen_user = $helper_user->unsubscribe($sub_user_id, false);
                $helper_user->delete($sub_user_id);
                  
                
            }
        }
