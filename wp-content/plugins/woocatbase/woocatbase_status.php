<?php 
/*
*
* generate woo categories structure
*
*/
function woocatbase_make_structure($out) {
	$allcat = array();
	$print_out = "";
	$set = get_option('woocatbase_options');
					  $taxonomy     = 'product_cat';
					  $orderby      = 'name';  
					  $show_count   = 0;      // 1 for yes, 0 for no
					  $pad_counts   = 0;      // 1 for yes, 0 for no
					  $hierarchical = 1;      // 1 for yes, 0 for no  
					  $title        = '';  
					  $empty        = 0;

					  $args = array(
					         'taxonomy'     => $taxonomy,
					         'orderby'      => $orderby,
					         'show_count'   => $show_count,
					         'pad_counts'   => $pad_counts,
					         'hierarchical' => $hierarchical,
					         'title_li'     => $title,
					         'hide_empty'   => $empty
					  );
					$all_categories = get_categories( $args );

					$permalinks = get_option( 'woocommerce_permalinks' );
					$cat_base = $permalinks['category_base'];
					$cat_base = rtrim($cat_base, " \t/");
					$cat_base = ltrim($cat_base, " \t/");
					$site = get_site_url();
					$cat_base_f = $site.'/'.$cat_base	;
					$shop_id = get_option( 'woocommerce_shop_page_id' );
					$shop = get_post($shop_id);
					$shop_base = $shop->post_name;

				if($out){	
					echo '<p class="intro"><em>Shop Base Permalink Slug: </em>'.$shop_base.'<br/><em>Product Category Base Slug: </em>'.$cat_base.'<br/><br/>';

					if($shop_base == $cat_base)	{
						echo '<span class="note green">Your "Shop Base" and "Product Category Base" slug <b>are equal</b> causing 404 errors on category pages! <em>This plugin will fix this issue.</em></span>';
					} else {
						echo '<span class="note">Your "Shop Base" and "Product Category Base" slug <b>are not equal</b>. Some other issue causing 404 errors on category pages! <em>This plugin maybe will not be able to fix this problem.</em></span>';
					}	
					echo '</p>'	;
					if($set['rules_numb'] != ""){ 
						echo '<div class="rest"><h3>Fixed all these permalinks</h3>';	
		    		} else {
		    			echo '<div class="rest"><h3>We will fix all these permalinks</h3>';
		    		}

				}	
						
		            
		            $t = 0 ;
					 foreach ($all_categories as $cat) { 
					    if($cat->category_parent == 0) {

					        $category_id = $cat->term_id; 
					        $cat_struct  =  $cat_base. '/'. $cat->slug.'/';  
					        $print_out .= '<div class="main-cat"><b><span><em>'. $cat_base_f. '</em>/'. $cat->slug. '/</span></b>' ;
					        $t++; 
					       
					        $args2 = array(
					                'taxonomy'     => $taxonomy,
					                'child_of'     => 0,
					                'parent'       => $category_id,
					                'orderby'      => $orderby,
					                'show_count'   => $show_count,
					                'pad_counts'   => $pad_counts,
					                'hierarchical' => $hierarchical,
					                'title_li'     => $title,
					                'hide_empty'   => $empty
					        );
					        $sub_cats = get_categories( $args2 );
					        $smallcat = array();
					        $xsmallcat = array();
					        if($sub_cats) {			        	  
						        	$print_out .= '<ul style="padding:0 0 0 25px;margin:0;">' ;
						            foreach($sub_cats as $sub_category) {
						            	$sub_category_id = $sub_category->term_id;
						            	$sub_cat_struct = $cat_struct.''. $sub_category->slug.'/';  
						                $print_out .=  '<li style="margin:0;"><span><em>'. $cat_base_f. '</em>/'. $cat->slug. '/<b>'.$sub_category->slug . '/</b></span></li>' ;
						                $t++; 
						               
						                 $args3 = array(
								                'taxonomy'     => $taxonomy,
								                'child_of'     => 0,
								                'parent'       => $sub_category_id,
								                'orderby'      => $orderby,
								                'show_count'   => $show_count,
								                'pad_counts'   => $pad_counts,
								                'hierarchical' => $hierarchical,
								                'title_li'     => $title,
								                'hide_empty'   => $empty
								        );
						                 $xsub_cats = get_categories( $args3 );
						                 if($xsub_cats) {			        	  
								        	$print_out .= '<ul style="padding:0 0 0 25px;">' ;
								            foreach($xsub_cats as $xsub_category) {
								            	$xsub_cat_struct = $sub_cat_struct.''. $xsub_category->slug.'/';  
								            	$print_out .=  '<li style="margin:0;"><span><em>'. $cat_base_f. '</em>/'. $cat->slug. '/'.$sub_category->slug. '<b>/' .$xsub_category->slug . '/</b></span></li>' ;
								            	$t++; 
								                $xsmallcat[] = array("xsub-cat" => $xsub_category->slug );								               				                
								            } 
								            $print_out .= '</ul>' ;  
								        }
								        $smallcat[] = array("sub-cat" => $sub_category->slug, "xsub-cats" => $xsmallcat );
						            } 
						            $print_out .= '</ul>' ;  
						             $allcat[] = array("main-cat" => $cat->slug , "sub-cats" => $smallcat);
						        } else {
							        $allcat[] = array("main-cat" => $cat->slug );
							    }
					        $print_out .= '</div>' ;  
					    }       
					}

		    if($allcat != '') {	
		    	$main_cats_list = array(); 
		    	foreach($allcat as $mainrole) {
		    		$main_cats_list[] = $mainrole['main-cat'];
		    	}
		    }


			$my_options = get_option('woocatbase_options');
			$my_options['cat_structure'] = $allcat;
			$my_options['rules_numb'] = strval($t);
			update_option('woocatbase_options', $my_options);
			flush_rewrite_rules();

		
		if($out){
			echo $print_out ;
		}

}

/*
*
* settings page form
*
*/
function woocatbase_status() { ?>
	<div class='wrap' id='woocatbase_status'>
		<h2>Woo Category Base Permalink Fixer - Status</h2>
		<br/>
			<form method="post" action="options.php">
			<?php settings_fields('woocatbase_options'); 			
			$set = get_option('woocatbase_options'); 
            
            if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			    $enwoo = 1;
			} else {
				$enwoo = 0;
			}
		if($enwoo == 1){ 
			 woocatbase_make_structure(true); ?>
			<?php if($set['rules_numb'] != ""){ ?>
			</div><p>Added <b><?php echo $set['rules_numb']; ?></b> URL rewrite rules in order to prevent 404 errors! <span class="button-primary" id="allperm">Show all</span></p>
			<?php }
			
		} else {
					echo '<p class="intro"><span class="note">We did not found <b>Woocommerce plugin</b> active on your site. <em>This plugin will not be able to fix your 404 error related problem.</em></span></p>';
		}  ?>



			
			 </form>
	</div>
	
<style>
#woocatbase_status p {text-align: left;padding:20px;background:#f8f8f8;margin:0 0 20px;}	
#woocatbase_status em {opacity:0.4;}
#woocatbase_status .main-cat {margin-top:10px;}
#woocatbase_status p.intro {padding:20px 40px;text-align: left;}
#woocatbase_status p.intro em {width:180px;display: inline-block;}
#woocatbase_status p.intro span.note em {width: auto;display: inline-block;opacity:1;color:#cc0000;font-weight: bold;}
#woocatbase_status p.intro span.note.green em {color:#009900;}
#woocatbase_status .rest {padding:20px 40px;background: #fff;display:none;}
#allperm {margin-left:25px;}
</style>
<?php


define('YOUR_SPECIAL_SECRET_KEY', '59f472e73148e0.35830007'); 
define('YOUR_LICENSE_SERVER_URL', 'https://masterns-studio.com');

$wp_option  = 'product_2357';
$product_id = 'Woo_Category_Base_Permalink_Fixer';
$operate_key  =   get_option('woocatbase_licence');



    echo '<div class="wrap">';
    echo '<h2>Plugin License</h2>';

    /*** License activate button was clicked ***/
    if (isset($_REQUEST['activate_license'])) {
        $license_key = $_REQUEST['wcbp_license_key'];
        
          $url = YOUR_LICENSE_SERVER_URL . '/?secret_key=' . YOUR_SPECIAL_SECRET_KEY . '&slm_action=slm_activate&license_key=' . $license_key . '&registered_domain=' . get_bloginfo('siteurl').'&item_reference='.$product_id;
        $response = wp_remote_get($url, array('timeout' => 20, 'sslverify' => false));

        if(is_array($response)){
            $json = $response['body']; // use the content
            $json = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', utf8_encode($json));
            $license_data = json_decode($json);
        }
        if($license_data->result == 'success'){
        	echo 'You license Activated successfuly<br/>';
        	update_option( 'woocatbase_licence',$license_key );
            update_option( 'woocatbase_licence_active', 'true' );
            echo $license_data->message;
        }elseif ($license_data->message == 'License key already in use on '. get_bloginfo('siteurl')){
        	echo 'You license is already activated for this domain<br/>';
        	update_option( 'woocatbase_licence',$license_key );
            update_option( 'woocatbase_licence_active', 'true' );
        }else{
            echo $license_data->message;
        }

    
    }

     if (isset($_REQUEST['deactivate_license'])) {
        $license_key = $_REQUEST['wcbp_license_key'];
        

        // Send query to the license manager server
         $url = YOUR_LICENSE_SERVER_URL . '/?secret_key=' . YOUR_SPECIAL_SECRET_KEY . '&slm_action=slm_deactivate&license_key=' . $license_key . '&registered_domain=' . get_bloginfo('siteurl').'&item_reference='.$product_id;
    	$response = wp_remote_get($url, array('timeout' => 20, 'sslverify' => false));

        if(is_array($response)){
            $json = $response['body']; // use the content
            $json = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', utf8_encode($json));
            $license_data = json_decode($json);
        }
        if($license_data->result == 'success'){
        	echo 'You license Deactivated successfuly<br/>';
            update_option( 'woocatbase_licence', '' ); 
            update_option( 'woocatbase_licence_active', 'false' );
            update_option( 'woocatbase_allowed','' );
            update_option( 'woocatbase_ord_ref','' );
            update_option( 'woocatbase_cust_ref','' );
           // return true;

            
            echo  $license_data->message;
        }else{
            echo  $license_data->message;
            if($license_data->message == 'The license key on this domain is already inactive'){
            	update_option( 'woocatbase_licence', '' ); 
            	update_option( 'woocatbase_allowed','' );
            	update_option( 'woocatbase_ord_ref','' );
            	update_option( 'woocatbase_cust_ref','' );
           }
        }

    }

    if(get_option('woocatbase_licence') != ''){ ?>
        <form action="" method="post">
            <table class="form-table">
                <tr>
                    <th style="width:100px;"><label for="wcbp_license_key">License Key</label></th>
                    <td ><input class="regular-text" type="password" id="wcbp_license_key" name="wcbp_license_key"  value="<?php echo get_option('woocatbase_licence'); ?>" ></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="deactivate_license" value="Dectivate" class="button-primary" />
            </p>
        </form>
        
    <?php  }else{ ?>

        <form action="" method="post">
            <table class="form-table">
                <tr>
                    <th style="width:100px;"><label for="wcbp_license_key">License Key</label></th>
                    <td ><input class="regular-text" type="text" id="wcbp_license_key" name="wcbp_license_key"  value="<?php echo get_option('woocatbase_licence'); ?>" ></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="activate_license" value="Activate" class="button-primary" />
            </p>
        </form>
        <?php
    }

    woocatbase_upd();

    echo '</div>';
}


function woocatbase_upd() {
$operate_key  =   get_option('woocatbase_licence');
	if($operate_key != ''){
		$serv = YOUR_LICENSE_SERVER_URL;
		$api_params = array(
		'slm_action' => 'slm_check',
		'secret_key' => YOUR_SPECIAL_SECRET_KEY,
		'license_key' => $operate_key,	
		);
		// Send query to the license manager server
		$response = wp_remote_get(add_query_arg($api_params, $serv), array('timeout' => 20, 'sslverify' => false));
		if(is_array($response)){
		            $json = $response['body']; // use the content
		            $json = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', utf8_encode($json));
		            $license_data = json_decode($json);	           
		        }
		$status = $license_data->status;
		
	        
		if($status == 'active'){
			$domains = $license_data->registered_domains;
			$allowed = array();
			foreach ($domains as $domain) {
				$allowed[] = $domain->registered_domain;
			}
			$home = get_bloginfo('siteurl');
			if(in_array($home, $allowed)){
				update_option( 'woocatbase_allowed','allowed' );
				$ord_id = $license_data->order_ref;
				$cust_id = $license_data->cust_ref;
				update_option( 'woocatbase_ord_ref',$ord_id );
				update_option( 'woocatbase_cust_ref',$cust_id );
				
			} else {
				update_option( 'woocatbase_allowed','not-allowed' );
				update_option( 'woocatbase_ord_ref','' );
				update_option( 'woocatbase_cust_ref','' );
			}
		}
	}
	
	
}



