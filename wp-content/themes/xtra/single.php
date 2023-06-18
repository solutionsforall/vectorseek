<?php 
if ( get_post_type( get_the_ID() ) == 'vector_logo'|| 'templates') {
    
    get_header(); 
    gt_set_post_view(); ?>
    <div class="row clr">
        <div class="col s12">
            <?php while ( have_posts() ) : the_post(); ?>
			    <div class="vector-post-content">
                <div class="vector-img-info"> 
                    <div class="vector-post-title"><h1><?php the_title(); ?></h1></div>
			<?php if(get_field('select_type_of_post')=="Brand Logos"){  ?>
            Free Download JPG PNG PSD SVG EPS  Formats In Single Zip
<?php   }
	          else{  ?>
				  Free download <?php echo '<b>'.remove_last_word_from_title().'</b>'; ?> template in vector format
					<?php
			  }
					?>
					<br>
                    <div class="vector-img">
                        <?php 
                        $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'vector-logo-size'); 
                        echo '<a href="'.esc_url($featured_img_url).'" rel="lightbox">'; 
                        the_post_thumbnail('vector-logo-size');
                        echo '</a>';
                        ?>
                    </div>
					 <?php
                                if(get_field('image_download_link') != ''){
                                	$download_link_for_size = get_field('image_download_link');
									$download_link_for_size = $download_link_for_size["url"];
								   
                                }else{
                                    $download_link_for_size = get_field('external_download_link');
                                }
	                 	$path = str_replace( site_url('/'), ABSPATH, esc_url( $download_link_for_size) );
	                   if ( is_file( $path ) ){
                        $filesize = size_format( filesize( $path ) );
  } 
?>




                            <?php
                                if(get_field('image_download_link') != ''){
                                	$downloadLink = get_field('image_download_link');
									$downloadLink = $downloadLink["url"];
								   
                                }else{
                                    $downloadLink = get_field('external_download_link');
                                }
?>
<?php
	
	                            
                                $vectorPostID = get_the_ID();   
                                $checkFilePath = get_theme_file_path('counter/counter'.$vectorPostID.'.txt'); 
                                
                                $themeUrl = site_url('wp-content/themes/xtra/counter');
                                
                                if (!file_exists($checkFilePath)){
                                    
                                    $fileContent = "click-001||0 \nclick-002||0 \nclick-003||0 \nclick-004||0";
                                    $fileName = 'counter'.$vectorPostID.'.txt';
                                    $filePath = get_theme_file_path('counter/'.$fileName);
                                
                                    if (file_put_contents($filePath, $fileContent) !== false) {
                                      
                                    }
                                 
                                } 
	                            
                                
                                $clickcount = explode("\n", file_get_contents(get_stylesheet_directory().'/counter/counter'.$vectorPostID.'.txt'));
                                foreach($clickcount as $line){
                                	$tmp = explode('||', $line);
                                	$count[trim($tmp[0])] = trim($tmp[1]);
                                }
                                
                                $fi = new FilesystemIterator('wp-content/themes/xtra/counter', FilesystemIterator::SKIP_DOTS);
                               
                               
                               $total = iterator_count($fi);
                            
                                $str = $downloadLink;
                                
                                $jpg = trim($str,"https://vectorseek.com/wp-content/uploads/2021/04/.zip");
                                $jpg1 = $jpg. 'ector';
                                
function logo_name(){                              
$str = get_the_title();
$words = explode( " ", $str );
array_splice( $words, -1 );
echo implode( " ", $words );
}	
	
	 global $post;
    $post_slug = $post->post_name;
 $total_count = array_sum($count);
                                                               ?>
                                                               
                                                               
                    <div class="vector-info">
                        
                        <ul>
                            <li>
                                <span class="label"><i class="fa fa-eye" aria-hidden="true"></i></span> 
                                <span class="value"><?= gt_get_post_view(); ?></span>
                            </li>
                            <li>
                                <span class="label"><i class="fa fa-download" aria-hidden="true"></i></span> 
                                <span class="value" id="zip_size"><?php echo " $total_count Times<br> Download" ; ?></span>
                            </li>
                           
                            <li>
                                <span class="label"><i class="fa fa-file" aria-hidden="true"></i></span> 
                                <span class="value"><?php 
	                                 if(get_field('select_type_of_post')=="Brand Logos"){
	                                   echo ".JPG, .PNG, .PSD, .SVG, .EPS, .AI";
									 }
	                                  else{
									   echo ".PNG, .AI"; 
									  }
									?></span> 
                            </li>
                            <li>
                                <span class="label"><i class="fa fa-calendar" aria-hidden="true"></i></span> 
                                <span class="value"><?php echo get_the_date( 'M d, Y' ); ?></span>
                            </li>
                            <li>
                                <span class="label"><i class="fa fa-id-card" aria-hidden="true"></i></span> 
                                <span class="value"><?php
                                      if(get_field('select_type_of_post')=="Brand Logos"){	
	                                  echo "Not For Commercial Use";
	                                   }
	                                  else{
										   echo "For Commercial Use";
									  }
									?></span> 
                            </li>
					       <?php if(get_field('official_website')){  ?>
                            <li>
								
                                <span class="label"><i class="fa fa-globe" aria-hidden="true"></i></span> 
								
                                <span class="value"><a href="<?php the_field('official_website'); ?>" target="_blank">Official Website</a></span> 
								
                            </li>
							<?php }
						else{
							?>
							<li>
								
                                <span class="label"><i class="fa fa-user" aria-hidden="true"></i></span> 
								
                                <span class="value"><p><?php echo get_the_author(); ?></p></span> 
								
                            </li>
							<?php
						}		
							?>
 							<li>
             
							<a href="https://vectorseek.com/contact/" target="_blank" style="font-size: 13px;color: red;"><img src="https://vectorseek.com/wp-content/uploads/2022/05/warning.png" style="display: inline;vertical-align: middle;padding-right: 10px;height: 21px;">Report Abuse</a>
							</li> 
							
                        </ul>
                    </div>
                </div>      
                
                <div class="vector-content">
					<?php if(get_field('select_type_of_post')=="Brand Logos"){?>
                    <div class="vector-title"><h6>Downloading <?php the_title();?> files you agree to the following:</h6></div>
					
                    <div class="vector-desc"><p>The logo design and artwork you are downloading above is the intellectual property of <strong style="color:black;">
					<?php	if(get_field('official_website')) {      ?>
						<a href="<?php echo get_field('official_website');?>">
							<?php
                       echo remove_last_two_words_from_string();
						?></a>
						<?php 
						}  
						else{
						echo remove_last_two_words_from_string();
						}
						?>
						
</strong> as copyright and is provided as a convenience for legitimate use with the appropriate permission of the copyrights from <strong><?php
echo remove_last_two_words_from_string();
						?></strong>. You have to agree with the terms of use of <strong><?php
echo remove_last_two_words_from_string();
						?></strong> while you are using this artwork or logo.</p></div>
					<?php } 
					else{
						$copy_link = '<a href="'.get_permalink().'">'.get_the_title().' created by vectorseek - www.vectorseek.com</a>';
					?>
					
			<h3 class="attribute-heading">
				Creating graphics takes a lot of energy, we ask you to provide a link to credit the source.
					</h3>
			<p class="attribute-paragraph">
				Copy this link & paste in a place where you are using this vector graphic or you can place it at the footer of your website, blog or newsletter.
					</p>
					<div class="copied-successfully" style="position: absolute;z-index: 1;background-color: #00AF80;color: white;width: 681px;height: 46px;text-align: center;visibility:hidden;opacity:0;  transition: visibility 0s, opacity 0.5s linear;font-family: open sans,Tahoma,Arial,Helvetica;">
						<p style="padding-top: 5px;">
							Copied Successfully
						</p>
					</div>	
	             <div class="clearfix" style="margin-bottom: 40px;">
					<div class="copy-and-attribute"><span class="copy-and-attribute-text"><?php echo htmlspecialchars($copy_link); ?></span></div>
						<div class="copy-and-attribute-button" onclick="copied()">Copy & attribute</div>
					</div>
					
					
					<?php
					}
					
					?>

                    <div class="vector-action-area">
                        <div class="checkbox-download">
                            <input class="vector-download" id="vector-download" type="checkbox" name="coupon_question" checked/>
                            <label>I Agree</label>
							
                        </div>
<!--                         <ul> -->
<!--  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9173306225224862"
     crossorigin="anonymous"></script>
<!-- below buttons -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-9173306225224862"
     data-ad-slot="9624006288"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>-->

							<ul>
								

                            <li><a id="zip-download" href="<?php echo esc_url( add_query_arg(array("download_type"=>"zip","vector_logo"=>$post->post_name),"https://vectorseek.com/thank-you/") ); ?>" class="vector-download-btn click-trigger" data-click-id="click-001"><i class="fas fa-download"></i> Download All Files in zip <span id="click-001" class="click-count"><?php echo $count['click-001'];?></span></a></li>
							
  <?php if(get_field('select_type_of_post')=="Brand Logos"){?>	
								<li><a href="<?php echo esc_url( add_query_arg(array("download_type"=>"png","vector_logo"=>$post->post_name),"https://vectorseek.com/thank-you/") );?>"><button id="png-button" class="vector-download-btn click-trigger" data-click-id="click-002"><i class="fas fa-download"></i> Download <?php logo_name();?> PNG <span id="click-002" class="click-count">(<?php echo $count['click-002'];?>)</span></button></a></li> 
						
								<li><a href="<?php echo esc_url( add_query_arg(array("download_type"=>"ai","vector_logo"=>$post->post_name),"https://vectorseek.com/thank-you/") );?>"><button id="ai-button" class="vector-download-btn click-trigger" data-click-id="click-003"><i class="fas fa-download"></i> Download <?php logo_name();?> Ai <span id="click-003" class="click-count">(<?php echo $count['click-003'];?>)</span></button></a></li> 
							
								<li><a href="<?php echo esc_url( add_query_arg(array("download_type"=>"svg","vector_logo"=>$post->post_name),"https://vectorseek.com/thank-you/") );?>"><button id="svg-button" class="vector-download-btn click-trigger" data-click-id="click-004"><i class="fas fa-download"></i> Download <?php logo_name();?> SVG <span id="click-004" class="click-count">(<?php echo $count['click-004'];?>)</span></button></a></li> 
							<?php }
								?>				
                        </ul>                    
                        <?php
               
                        if(!empty($_GET['file']))
                        {
                        	$filename = basename($_GET['file']);
                        	$filepath = '../uploads/2021/04' . $filename;
                        	if(!empty($filename) && file_exists($filepath)){
                        
                        //Define Headers
                        		header("Cache-Control: public");
                        		header("Content-Description: FIle Transfer");
                        		header("Content-Disposition: attachment; filename=$filename");
                        		header("Content-Type: application/zip");
                        		header("Content-Transfer-Emcoding: binary");
                        
                        		readfile($filepath);
                        		exit;
                        
                        	}
                        	else{
                        		echo "This File Does not exist.";
                        	}
                        }
                        
                        
                        ?>
                        <script>
                        var clicks = document.querySelectorAll('.click-trigger'); // IE8
                        for(var i = 0; i < clicks.length; i++){
                        	clicks[i].onclick = function(){
                        		var id = this.getAttribute('data-click-id');
								console.log(id);
                        		var post = 'id='+id; // post string
								console.log(post)
                        		var req = new XMLHttpRequest();
                        		req.open('POST', '<?= $themeUrl.'/counter.php?postID='. $vectorPostID?>', true);
                        		req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        		req.onreadystatechange = function(){
                        			if (req.readyState != 4 || req.status != 200) return; 
									console.log("Hi",req.responseText)
                        			document.getElementById(id).innerHTML = req.responseText;
                        			};
                        		req.send(post);
                        		}
                        	}
						 
							
                        </script>
                    </div>
                </div>
		 
					
					
                <div class="vector-similar-post-area">
                    <div class="similar-title">Similar Logos</div>
				<?php 
    $terms = get_the_terms( $post->ID, 'vectors' ); 
    
    $a=array();
    foreach($terms as $term) {
	if($term->name == "Vectors of Brands"){
		continue;
	}
      $logo_category_name = $term->name;
	  array_push($a,$logo_category_name);
//  print_r($a);
// print_r($last_category);
    }
	$my_logo_title = get_the_title();
	$words = explode( " ", $my_logo_title );
    array_splice( $words, -2 );
    $txt1 = implode( " ", $words );
	$txt1 = explode(' ', $txt1);
// 	print_r($txt1);  
	foreach($a as $single_category){
//       echo $single_category;
// 	  echo $my_logo_title;
// 	print_r($txt1);
	foreach($txt1 as $txt){
if (strpos($single_category, $txt)!==false) { 
    $specific_category = $single_category;
// 	echo $specific_category;
}
		else{
			$remaining_category = $single_category;
			
		}
// 		
}
	
	}
// echo $remaining_category;
// 	echo $specific_category;
?> 

 			
                    <div class="similar-posts-grid">  
                 
                               <?php 
                     
        // similar logo start with same word code  
        
                    
  
$exclude_word = array('The', 'A', 'An', 'Black', 'Yellow', 'Orange', 'He', 'White', 'Me', 'Old', 'New', 'Blue', 'Orange');
                    
       
$post_title = get_the_title();       
$title_array = explode(' ', $post_title);
$post_two_words = array_slice($title_array, 0, 2);
$post_two_words = implode(' ', $post_two_words);
$post_two_words = ucwords($post_two_words);

$similar_post_found = 0;
$args = array(
    'post_type'      => 'vector_logo',
    'posts_per_page' => 14,
    'post__not_in'   => array($post->ID),
    's'              => $post_two_words, // Search for posts containing the first word
);

$similar = new WP_Query($args);
$number_of_post = count($args[s]);

if ($similar->have_posts()) {
    while ($similar->have_posts()) {
        $similar->the_post();
        $array_post_title = get_the_title();
        
        
        
        $exploding_array = explode(' ', $array_post_title);
       $post_two_wordss = array_slice($exploding_array, 0, 2);
$post_two_wordss = implode(' ', $post_two_wordss);
        $array_two_word = ucwords($array_two_word);
        
        // this code is to check post first two words are same or not 
        
        
                // this code is to get first word of post which is in loop and check the first word are not those words in $ exclude array
                
        if($post_two_words == $array_two_words){
            $similar_post_found = $similar_post_found + 1;
            ?>
            <div class="similar-post">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium'); ?>
                    <div class="home-post-grid-item-title">
                        <h3><?php the_title(); ?></h3>
                    </div>
                </a>
            </div>
            <?php
            $displayed_posts[] = get_the_ID(); // Add the post ID to the displayed posts array
        }
    }
    wp_reset_postdata();
}
$exclude_word = array("The", "There", "Is", "A", "An", "Black", "Yellow", "Orange", "He", "White", "Me", "Old", "New", "Blue", "Orange");

$post_title = get_the_title(); 
$title_array = explode(' ', $post_title);
$first_word = $title_array[0];
if($first_word == $first_word ){

}
if (in_array($first_word, $exclude_word, true)) {
    $first_word = $title_array[1];
}

$args = array(
    'post_type'      => 'vector_logo',
    'posts_per_page' => 14,
    'post__not_in'   => array($post->ID),
    's'              => $first_word, // Search for posts containing the first word
);

$similar = new WP_Query($args);
$number_of_post = count($args['s']);

if ($similar->have_posts()) {
    while ($similar->have_posts()) {
        $similar->the_post();
        $post_title1 = get_the_title();
        
        
        if (in_array(get_the_ID(), $displayed_posts)) {
            continue; // Skip        
        }
        
        $word1 = explode(" ", $post_title1);
        $word1 = $word1[0];
        if(substr($post_title1, -1) === 's'){


            $similar_post_found = $similar_post_found + 1;
            ?>

            <div class="similar-post">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium'); ?>
                    <div class="home-post-grid-item-title">
                        <h3><?php the_title(); ?></h3>
                    </div>
                </a>
            </div>
        
        <?php } else if (in_array($first_word, $exploding_array)) {
        
            // Code to check if the first word of the post (in the loop) is in the exclude array
        
            $similar_post_found = $similar_post_found + 1;
            ?>

            <div class="similar-post">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium'); ?>
                    <div class="home-post-grid-item-title">
                        <h3><?php the_title(); ?></h3>
                    </div>
                </a>
            </div>
        
        <?php
            $displayed_posts[] = get_the_ID(); // Add the post ID to the displayed posts array
        }
    }
    wp_reset_postdata();
}


   
     	  $last_category = reset($a);
          if(is_array($last_category)){
              $last_category = reset($last_category);
          }
      
	if($similar_post_found < 14){
	$remaining_post_count = 14-$similar_post_found;

		$args1 = array(
    'post_type' => 'vector_logo',
	'posts_per_page' => $remaining_post_count,
	'post__not_in'   => array( $post->ID ),
    'tax_query' => array(
	
        array(
            'taxonomy' => 'vectors',
            'field'    => 'slug',
            'terms'    => $last_category,
			
        ),
		
    ),
	 
);

$similar1 = new WP_Query($args1);

if ($similar1->have_posts()) {
    while ($similar1->have_posts()) {
        $similar1->the_post();

        // Check if the post has already been displayed
        if (in_array(get_the_ID(), $displayed_posts)) {
            continue; // Skip this iteration of the loop
        }
        ?>

        <div class="similar-post">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium'); ?>
                <div class="home-post-grid-item-title">
                    <h3><?php the_title(); ?></h3>
                </div>
            </a>
        </div>

        <?php
        $displayed_posts[] = get_the_ID(); 
    }
    wp_reset_postdata();
}
 }
 

 
 
//  code of vector templates similar posts 

if (has_category('logo-templates', $post->ID)) {
    
    
    
    
    $post_title = get_the_title();
$title_array = explode(' ', $post_title);
$first_word = $title_array[0];
$first_word = ucfirst($first_word);
$similar_post_found = 0;


$args = array(
    'post_type'      => 'logo-template',
    'posts_per_page' => 14,
    'post__not_in'   => array($post->ID),
    's'              => $first_word, // Search for posts containing the first word
        'tax_query' => array(
	
        array(
            'taxonomy' => 'vectors',
            'field'    => 'slug',
            'terms'    => array("logo-templates"),
			
        ),
		
    ),
);

$similar = new WP_Query($args);
$number_of_post = count($args[s]);

if ($similar->have_posts()) {
    while ($similar->have_posts()) {
        $similar->the_post();
        $array_post_title = get_the_title();
        $exploding_array = explode(' ',$array_post_title);
        $array_first_word = $exploding_array[0];
        $array_first_word = ucfirst($array_first_word);
        if($array_first_word == $first_word){
            $similar_post_found ++ ;
            ?>
            <div class="similar-post">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium'); ?>
                    <div class="home-post-grid-item-title">
                        <h3><?php the_title(); ?></h3>
                    </div>
                </a>
            </div>
            <?php
            $displayed_posts[] = get_the_ID(); // Add the post ID to the displayed posts array
        }
    }
    wp_reset_postdata();
}
     
	if($similar_post_found < 14){
	$remaining_post_count = 15-$similar_post_found;

		$args = array(
    'post_type' => 'logo-templates',
	'posts_per_page' => $remaining_post_count,
	'post__not_in'   => array( $post->ID ),
    'tax_query' => array(
	
        array(
            'taxonomy' => 'vectors',
            'field'    => 'slug',
            'terms'    => $last_category,
			
        ),
		
    ),
	 
);

$similar = new WP_Query($args);

if ($similar->have_posts()) {
    while ($similar->have_posts()) {
        $similar->the_post();

        // Check if the post has already been displayed
        if (in_array(get_the_ID(), $displayed_posts)) {
            continue; // Skip this iteration of the loop
        }
        ?>

        <div class="similar-post">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium'); ?>
                <div class="home-post-grid-item-title">
                    <h3><?php the_title(); ?></h3>
                </div>
            </a>
        </div>

        <?php
    }
    wp_reset_postdata();
}
 }
 
    
} 



                        ?>
                    </div>
                </div>
            </div>
			<?php endwhile; 

			
			$ee = 0;
           for($i=5500; $i<6000; $i++){
                $checkFilePath2 = get_theme_file_path('counter/counter'.$i.'.txt');
                if(file_exists($checkFilePath2)){
                   $clickcount2 = explode("\n", file_get_contents($themeUrl.'/counter'.$i.'.txt'));
                    $line2 =  $clickcount2[0];
                 	$tmp2 = explode('||', $line2);
                	$count2[trim($tmp2[0])] = trim($tmp2[1]);
                	$ee = $ee + $count2['click-001'];
                } 
            }
			
			?> 
		</div>
    </div>
<div class="logo-description-section">
	 <p class="logo-description-content"><?php the_content(); ?></p>
</div>

<?php
$faqs = get_field('faqs');
if( $faqs ): ?>
<?php foreach($faqs as $x => $val) {?>
<? if($val[question]){?>
    <div id="faqs">
	 <h3 class="faq-question">
		 <?php echo $val[question];"br/>"?>
	 </h3>
		 <p class="faq-answer">
		 <?php echo $val[answer];"br/>"?>
	     </p>	
     </div>
<?php } ?> 
 <?php } ?> 
  
<?php endif; ?>
    <?php get_footer();
 

}else{
 
 Codevz_Theme::generate_page( 'single' );   
    
} ?>