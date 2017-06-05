        if (isset($_POST['subscriber'])) {
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
            update_user_meta($user->ID,'user_subcriber_id',$sub_user_id);

            wp_update_user($user);
        }else {
            delete_user_meta($user->ID, 'mailpoet_subscriber');

            $helper_user = WYSIJA::get('user','helper');

            $sub_user_id = get_user_meta($user->ID, 'user_subcriber_id', true);

            if(!empty($sub_user_id)) {
                $retuen_user = $helper_user->unsubscribe($sub_user_id, false);
                if ($helper_user->delete($sub_user_id)) {
                    delete_user_meta($user->ID, 'user_subcriber_id');
                };
            }
        }
