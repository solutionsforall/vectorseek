<?php  
 /* 
 Template Name: Thank you 
 */  

 get_header(); 


function get_post_id_by_slug($post_slug, $slug_post_type = 'vector_logo') {

	$post = get_page_by_path($post_slug, OBJECT, $slug_post_type);
	
        if ($post) {
		return $post->ID;
	} else {
		return null;
	}
}

function get_image_download_link($id){
    if(get_field('image_download_link') != ''){
        $download = get_field('image_download_link', $id);	
		$download = $download["url"];
                            }
    else{
         $download = get_field('external_download_link', $id);
                            }
    return $download;
}

function get_modified_string($vector_logo){
    $vector_logo = str_replace('-', ' ', $vector_logo); 
	   $words = explode( " ", $vector_logo );
       array_splice( $words, -1 );
       $words= implode( " ", $words );
       return $words;
}

function get_logos(){
 ?>
 <div class="home-logos-grid">  
                 
 <?php 

$args = array(
    'post_type' => 'vector_logo',
	'posts_per_page' => 14,
// 	'post__not_in'   => array( $post->ID ),
//     'tax_query' => array(
//         array(
//             'taxonomy' => 'vectors',
//             'field'    => 'slug',
//             'terms'    => $a,
			
//         ),
//     ),
	 
);
$similar = new WP_Query( $args );
                            
                            if( $similar->have_posts() ) { 
                                while( $similar->have_posts() ) { 
                                    $similar->the_post(); ?>
                                    <div class="home-post-grid-item">
    <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail('medium'); ?>
        <div class="home-post-grid-item-title">
        <h3><?php the_title(); ?></h3>
        </div>
    </a>
</div>
                                <?php 
                                } wp_reset_postdata();
                            }  ?>
                     </div>  
                    

<?php
}
 function show_thanku_content($words,$format){
    echo '<div class="not-logo-found">';
    // 				echo '<img src="https://vectorseek.com/wp-content/uploads/2021/12/vectorseek.png" class="not-found-image">';
  ?>



<?php 

if($format==" ZIP"){ ?>
	<h3 class="sorry-not-logo">Thank You For Downloading <a href="<?php echo get_permalink(); ?>"><span><?php echo ucwords($words) ?></span></a><span class="vector-format"> <?php echo $format ?></span></h3>
<?php
}
	 else{
		 ?>
  <h3 class="sorry-not-logo">Thank You For Downloading <a href="<?php echo get_permalink(); ?>"><span><?php echo ucwords($words) ?></span><span class="vector-format"> <?php echo $format ?></span></a></h3>
<?php
	 }
?>	 
<!-- 
 <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9173306225224862"
     crossorigin="anonymous">
<!-- thankyou page -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9173306225224862"
     data-ad-slot="8053039785"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>-->
     (adsbygoogle = window.adsbygoogle || []).push({});
</script></center>
<?php 

                    echo "<h3 class=\"sorry-not-logo\">If Downloading does not work, please download .zip file"."."."</h3>";
                    
/*	echo '<a href="https://www.binance.me/en/activity/referral/offers/claim?ref=CPA_00K2LCGTWX" target="_blank">';
	echo '<img src="https://vectorseek.com/wp-content/uploads/2022/05/banner2-01.jpg" class="thanku-banner-image">';
	echo '</a>';*/
?>

<?php
// 	 echo $vector_logo_link;
	
 }


 ?>
<script>
async function postData(url = '', data = {}) {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            return response.json();
		    
        }

</script>

<?php


 	if ($_GET['download_type']=='png' && isset($_GET['vector_logo'])) {
	  $vector_logo = $_GET['vector_logo'];
	  $vector_logo_id = get_post_id_by_slug($vector_logo);  
	  $vector_logo_link = wp_get_canonical_url($vector_logo_id);
	  $downloadLink = get_image_download_link($vector_logo_id);
      $words = get_modified_string($vector_logo);
	  show_thanku_content($words," PNG");
	
?>


	<?php	
		get_logos();
				
?>	
<script>
var url= "<?php echo"$downloadLink"?>";
       
        postData('https://vectorseek1.herokuapp.com/download_png/', {
                url: url
            })
            .then(data => {	  
                const url = data.png_name.path;
			    console.log(url)
			    const filename=data.png_name.filename
                fetch(url)
                    .then(res => res.blob())
                    .then(blob => {
					    console.log(blob)
                        download(blob,filename);
                    });

            })
            
	
</script>		
	
<?php
}
 if ($_GET['download_type']=='ai' && isset($_GET['vector_logo'])) {
	 $vector_logo= $_GET['vector_logo'];
	  $vector_logo_id= get_post_id_by_slug($vector_logo);
      $downloadLink= get_image_download_link($vector_logo_id);
	  $words= get_modified_string($vector_logo);
      show_thanku_content($words," AI");	
	  get_logos();
				
?>	
<script>
var url= "<?php echo"$downloadLink"?>";
       
         postData('https://vectorseek1.herokuapp.com/download_ai/', {
                url: url
            })
            .then(data => {
                const url23 = data.ai_name.path;
			    const aifilename=data.ai_name.filename 
                fetch(url23)
                    .then(res => res.blob())
                    .then(blob => {
                        download(blob,aifilename,".ai");
                    });

            })
            
	
</script>
					
<?php	
}
if ($_GET['download_type']=='svg' && isset($_GET['vector_logo'])) {
	  $vector_logo= $_GET['vector_logo'];
	  $vector_logo_id= get_post_id_by_slug($vector_logo);
      $downloadLink= get_image_download_link($vector_logo_id);
	  $words= get_modified_string($vector_logo);
	  show_thanku_content($words," SVG");
	  get_logos();
				
?>	
<script>
var url= "<?php echo"$downloadLink"?>";
       
        postData('https://vectorseek1.herokuapp.com/download_svg/', {
                url: url
            })
            .then(data => {
                const url = data.svg_name.path;
			    const filename=data.svg_name.filename
                fetch(url)
                    .then(res => res.blob())
                    .then(blob => {
                        download(blob,filename);
                    });

            })
            
	
</script>
<?php
}

if ($_GET['download_type']=='zip' && isset($_GET['vector_logo'])) {
	  $vector_logo= $_GET['vector_logo'];
	  $vector_logo_id= get_post_id_by_slug($vector_logo);
      $downloadLink= get_image_download_link($vector_logo_id);
	  $words= get_modified_string($vector_logo);
	  show_thanku_content($words," ZIP");
	  get_logos();
?>
<script>
var url= "<?php echo"$downloadLink"?>";
window.open(url,"_self");
</script>
<?php
}
echo '</div>';
 get_footer();  
?>