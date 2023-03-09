<?php
/**
 * @since           	1.3.0
 * @package         	Tcard
 * @subpackage  		Tcard/inc
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardSocial 
{

	/**
	 * @since    1.3.0
	 */
	public $group_id;

	/**
	 * @since    1.3.0
	 */
	public $skin_settings;

	/**
	 * @since    1.3.0
	 */
	public function __construct($group_id){

		global $wpdb;

		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

		$this->group_id = $group_id;

		$this->skin_settings = $wpdb->get_results("SELECT settings FROM $tcard_skin_table WHERE group_id = $group_id");
	}

	public function twitter_profile($skin){

		$user = $this->get_twitter_profile($skin);

		$fields = array('screen_name','name','email','location','description','profile_image_url','website','followers_count','friends_count','listed_count','statuses_count');
		foreach ($fields as $key => $field) {
	    	if($field == "website"){
	    		if(!empty($user['entities']['url']['urls'][0]['expanded_url'])){
	    			$profile[$field] = $user['entities']['url']['urls'][0]['expanded_url'];
	    		}else{
	    			if(!empty($user['entities']['url']['urls'][0]['url'])){
	    				$profile[$field] = $user['entities']['url']['urls'][0]['url'];
	    			}else{
	    				$profile[$field] = "";
	    			}
	    			
	    		}	
	    	}
	    	elseif($field == 'profile_image_url'){
	    		if(!empty($user['profile_image_url_https'])){
					$profile[$field] = $user['profile_image_url_https'];
				}else{
					if(!empty($user['profile_image_url'])){
						$profile[$field] = $user['profile_image_url'];
					}else{
						$profile[$field] = "";
					}
				}
	    	}
	    	else{
	    		if(!empty($user[$field])){
	    			$profile[$field] = $user[$field];
	    		}else{
	    			$profile[$field] = "";
	    		}
	    	}
	    }

	    return $profile; 
	}

	/**
	 * @since    1.3.0
	 */
	public function get_twitter_profile($skin){

		$cache_file          = TCARD_CACHE_URL . "twitter_profile.txt";
	    $cachetime           = 60*3;

	    $cache_file_created  = ((file_exists($cache_file))) ? filemtime($cache_file) : 0;

	    if (time() - $cachetime < $cache_file_created) {
			$users = file_get_contents( $cache_file );
			$user = json_decode($users,TRUE);

		} else {

		   $users = $this->twitter($skin,$url = esc_url('//api.twitter.com/1.1/account/verify_credentials.json'));
         $user = json_decode($users, TRUE);	

			$tp_file = fopen($cache_file, "w");
			fwrite($tp_file, $users );
			fclose($tp_file); 
		
		}
	    return $user;
	}


	public function twitter_timeline($skin){

		$timeline = $this->get_twitter_timeline($skin);

		if(!empty($timeline)){
	    	foreach ($timeline as $key => $tweets) {

	    		 if(empty($tweets['in_reply_to_status_id'])){

	    		 	if(!empty($tweets['created_at'])){
	    		 		$time = strtotime($tweets['created_at']);
	    		 	}else{
	    		 		$time = 0;
	    		 	}
	
					$current_time = time();

					$time_diff = abs($current_time - $time);
					switch ($time_diff) 
					{
						case ($time_diff < 60):
							$tweet['created_at'][] = $time_diff.' seconds ago';                  
							break;      
						case ($time_diff >= 60 && $time_diff < 3600):
							$min = floor($time_diff/60);
							$tweet['created_at'][] = $min.' minutes ago';                  
							break;             
						default:
							$tweet['created_at'][] = date("j F. Y", $time);
							break;
					}

					if(!empty($tweets['id_str'])){
						$tweet['id_str'][] 	= $tweets['id_str'];
					}else{
						$tweet['id_str'][] = "";
					}
			    	
					if(!empty($tweets['text'])){
			    		$tweet_links = $tweets['text'];
						$tweet_links = preg_replace("/((http)+(s)?:\/\/[^<>\s]+)/i", "<a href=\"\\0\" target=\"_blank\">\\0</a>", $tweet_links );
						$tweet_links = preg_replace("/[@]+([A-Za-z0-9-_]+)/", "<a href=\"http://twitter.com/\\1\" target=\"_blank\">\\0</a>", $tweet_links );
						$tweet_links = preg_replace("/[#]+([A-Za-z0-9-_]+)/", "<a href=\"http://twitter.com/search?q=\\1\" target=\"_blank\">\\0</a>", $tweet_links );
						$tweet['text'][] = $tweet_links;
					}else{
						$tweet['text'][] = "";
					}

					if(!empty($tweets['entities']['media'][0]['media_url_https'])){
	    				$tweet['url'][] = $tweets['entities']['media'][0]['media_url_https'];
	    			}else{
	    				if(!empty($tweets['entities']['media'][0]['media_url'])){
		    				$tweet['url'][] = $tweets['entities']['media'][0]['media_url'];
			    		}else{
			    			$tweet['url'][] = "";
			    		}	
	    			}

					if(!empty($tweets['user']['screen_name'])){
						$tweet['screen_name'][] = $tweets['user']['screen_name'];
					}else{
						$tweet['screen_name'][] = "";
					}
					if(!empty($tweets['user']['name'])){
						$tweet['name'][] = $tweets['user']['name'];
					}else{
						$tweet['name'][] = "";
					}
					if(!empty($tweets['user']['profile_image_url_https'])){
						$tweet['profile_image_url'][] = $tweets['user']['profile_image_url_https'];
					}else{
						if(!empty($tweets['user']['profile_image_url'])){
							$tweet['profile_image_url'][] = $tweets['user']['profile_image_url'];
						}else{
							$tweet['profile_image_url'][] = "";
						}
					}
					if(!empty($tweets['retweet_count'])){
						$tweet['retweet_count'][] = $tweets['retweet_count'];
					}else{
						$tweet['retweet_count'][] = "";
					}
					if(!empty($tweets['favorite_count'])){
						$tweet['favorite_count'][] = $tweets['favorite_count'];	
					}else{
						$tweet['favorite_count'][] = "";
					}
				}

	    	}
	    }

	    return $tweet;
	}

	/**
	 * @since    1.3.0
	 */
	public function get_twitter_timeline($skin){

		$cache_file          = TCARD_CACHE_URL . "twitter_timeline.txt";
	    $cachetime           = 60*3;

	    $cache_file_created  = ((file_exists($cache_file))) ? filemtime($cache_file) : 0;

	    if (time() - $cachetime < $cache_file_created) {
			$timelines = file_get_contents( $cache_file );
			$timeline = json_decode($timelines,TRUE);
		} else {

		    $timelines = $this->twitter($skin,$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json');
            $timeline = json_decode($timelines, TRUE);
			$tf_file = fopen($cache_file, "w");
			fwrite($tf_file, $timelines );
			fclose($tf_file); 
		
		}
		return $timeline;
	}

	/**
	 * @since    1.3.0
	 */
	public function twitter($skin,$url){

		$skin_settings = unserialize($this->skin_settings[$skin]->settings);

        $fields = array(
            'screen_name'       => $skin_settings['social_twitter_username'],
            'include_email'     => 'true'
        );

	    $oauth = array(
	        'oauth_consumer_key'        => $skin_settings['social_twitter_key'],
	        'oauth_nonce'               => time(),
	        'oauth_signature_method'    => 'HMAC-SHA1',
	        'oauth_token'               => $skin_settings['social_twitter_token'],
	        'oauth_timestamp'           => time(),
	        'oauth_version'             => '1.0'
	    );

        $oauth = array_merge($oauth, $fields);
        $base_info              	= $this->buildBaseString($url, $oauth);
        $composite_key          	= rawurlencode($skin_settings['social_twitter_csecret']) . '&' . rawurlencode($skin_settings['social_twitter_stoken']);
        $oauth_signature            = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature']   = $oauth_signature;


        $header = array($this->buildAuthorizationHeader($oauth), 'Expect:');
        $options = array( CURLOPT_HTTPHEADER => $header,
                          CURLOPT_HEADER => false,
                          CURLOPT_URL => $url . "?". http_build_query($fields),
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_SSL_VERIFYPEER => false);

        $twitter = curl_init();
        curl_setopt_array($twitter, $options);
        $json = curl_exec($twitter);
        curl_close($twitter);

	    return $json;
	}

	/**
	 * @since    1.3.0
	 */
	public function buildBaseString($url, $params) {
	    $param = array();
	    ksort($params);
	    foreach($params as $key=>$value){
	        $param[] = "$key=" . rawurlencode($value);
	    }
	    return "GET&" . rawurlencode($url) . '&' . rawurlencode(implode('&', $param));
	}

	/**
	 * @since    1.3.0
	 */
	public function buildAuthorizationHeader($oauth) {
	    $param = 'Authorization: OAuth ';
	    $values = array();
	    foreach($oauth as $key=>$value)
	        $values[] = "$key=\"" . rawurlencode($value) . "\"";
	    $param .= implode(', ', $values);
	    return $param;
	}	

	/**
	 * @since    1.3.0
	 */
	public function get_social_settings($parent,$skin,$side,$element,$elemNumber){
		global $wpdb;
		
		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

		$socials = $wpdb->get_results("SELECT $parent FROM $tcard_skin_table WHERE group_id = $this->group_id");
		$socials = unserialize($socials[$skin]->$parent);

		$fields = array('name','email','description','location','image','website','tweets','followers','friends','lists');
		if(!empty($socials)){
			foreach ($socials as $key => $value) {
				if($element == "twitter_profile"){
					foreach ($fields as $key => $field) {
						if(!empty($value[$side]["tp_$field"][$elemNumber])){
							$output_twitter["tp_$field"] = $value[$side]["tp_$field"][$elemNumber];
						}else{
							$output_twitter["tp_$field"] = '';
						}
						if(!empty($value[$side][$element. "_" .$field][$elemNumber])){
							$output_twitter[$element. "_" .$field] = $value[$side][$element. "_" .$field][$elemNumber];
						}else{
							$output_twitter[$element. "_" .$field] = '';
						}
						
					}
				}elseif($element == "twitter_feed"){
					$output_twitter['twitter_feed_type'] = $value[$side]['twitter_feed_type'][$elemNumber];
					if(!empty($value[$side]['twitter_feed_count'][$elemNumber])){
						$output_twitter['twitter_feed_count']		= $value[$side]['twitter_feed_count'][$elemNumber];
					}
					if(empty($output_twitter['twitter_feed_count'])){
						$output_twitter['twitter_feed_count'] = 20;
					}
				}
			}

			if($element == "twitter_profile"){
				$counts = array('twitter_profile_location','twitter_profile_followers', 'twitter_profile_tweets', 'twitter_profile_friends', 'twitter_profile_lists');

				foreach ($counts as $key => $count) {
					if(empty($output_twitter[$count])){
						$output_twitter[$count] = str_replace('twitter_profile_', '', $count) ;
					}
				}
			}
		}
		if(!empty($output_twitter))
		return $output_twitter;
	}
}