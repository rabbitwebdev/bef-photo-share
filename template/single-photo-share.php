<?php
/**
 * Template Name: Single Photo Share
 * Description: Displays photo gallery
 */

get_header(); ?>


<div class="container-lg">
    <div class="row">
        <div class="col-md-12">
            <h1 class="title"><?php the_title(); ?></h1>
            <?php
            // Get the post ID
            $post_id = get_the_ID();
            // Get the post thumbnail URL
            $featured_photo_img = get_the_post_thumbnail_url($post_id);
            $ps_event_date = get_field('ps_event_date', $post_id);
            $ps_event_location = get_field('ps_event_location', $post_id);
            
            if ($ps_event_date) {
                echo '<p class="ps-card__date">Date: <span>' . esc_html($ps_event_date) . '</span></p>';
            }
            if ($ps_event_location) {
                echo '<p class="ps-card__date">Location: <span>' . esc_html($ps_event_location) . '</span></p>';
            }
            ?>
            <div class="photo-share-content">
                <?php
                // Start the loop.
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        // Display the content of the post.
                        the_content();
                    endwhile;
                else :
                    echo '<p>No content found.</p>';
                endif;
                ?>
</div>
</div>
</div>
                  <?php 
$photo_gallerys = get_field('single_bef_the_gallery');
if( $photo_gallerys ): ?>
  
        <div class="the_gallery row row-cols-lg-3 row-cols-md-2 row-cols-1 gap-3">
             <?php  $i = 1; ?>
            <?php foreach( $photo_gallerys as $photo_gallery ): ?>
                <?php   $image_caption = $photo_gallery['caption']; ?>
                 <?php   $image_title = $photo_gallery['title']; ?>
                <div class="gallery-item col post-card m-bottom--3">
                <a class="gallery-item-link " href="<?php echo esc_url($photo_gallery['url']); ?>"  onclick="openGalleryPopup(this)" data-fancybox="gallery">
                    <img class="fluid-img ps-img" src="<?php echo esc_url($photo_gallery['url']); ?>" alt="<?php echo esc_attr($photo_gallery['alt']); ?>" />
                </a>
             <h3 class="title m-top--1 m-bottom--1"><?php echo esc_html( $image_title ); ?></h3>
           <a class="btn btn--underline btn--secondary download-gi" href="<?php echo esc_url($photo_gallery['url']); ?>" download>
 
        <span class="download-icon"></span>
        Download
   
</a>
                </div>
            <?php endforeach; ?>
        </div>
 
   
<?php endif; ?>
            <!-- </div>
        </div>
    </div> -->
</div>
    <?php get_footer(); 