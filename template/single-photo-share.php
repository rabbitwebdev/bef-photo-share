<?php
/**
 * Template Name: Single Photo Share
 * Description: Displays photo gallery
 */

get_header(); ?>

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
              
</div>
</div>
</div>
                  <?php 
$photo_gallerys = get_field('single_bef_the_gallery');
if( $photo_gallerys ): ?>
  
        <div class="the_gallery row row-cols-lg-3 row-cols-md-2 row-cols-1 gap-2">
            <style>
   

    .popup-overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 999;
      justify-content: center;
      align-items: center;
    }

    .popup {
      background: white;
      padding: 20px;
      border-radius: 8px;
      text-align: left;
      width:100%;
      max-width: 900px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .popup button {
      margin-top: 10px;
      padding: 8px 16px;
    }
    .gallery-image:hover {
      cursor: pointer;
    }
  </style>
             <?php  $i = 1; ?>
            <?php foreach( $photo_gallerys as $photo_gallery ): ?>
                
                <?php   $image_caption = $photo_gallery['caption']; ?>
                 <?php   $image_title = $photo_gallery['title']; ?>
            <div class="gallery-item col post-card m-bottom--3">
                <a class="gallery-item-link " href="<?php echo esc_url($photo_gallery['url']); ?>"  onclick="openGalleryPopup(this)" data-fancybox="gallery">
                    <img class="fluid-img ps-img" src="<?php echo esc_url($photo_gallery['url']); ?>" alt="<?php echo esc_attr($photo_gallery['alt']); ?>" />
                </a>
                <h3 class="title m-top--1 m-bottom--1"><?php echo esc_html( $image_title ); ?></h3>
               
                <a class="btn btn--underline btn--secondary download-gi" onclick="showPopup()"  download>
                        <span class="download-icon"></span>Download
                </a>
            </div>
            <div class="popup-overlay" id="popupOverlay">
    <div class="popup">
      <p>Sign up to get photo</p>
       <?php echo do_shortcode( ' [gravityform id="16"] ' ); ?>
      <button onclick="hidePopup()">Close</button>
    </div>
  </div>
             <script>
    function showPopup() {
      document.getElementById('popupOverlay').style.display = 'flex';
    }

    function hidePopup() {
      document.getElementById('popupOverlay').style.display = 'none';
    }
  </script>
            <?php endforeach; ?>
  </div>
            <form id="bulk-download-form">
    <div id="gallery" class="the_gallery row row-cols-lg-3 row-cols-md-2 row-cols-1 gap-2">
    <?php  $i = 1; ?>
        <?php foreach ($photo_gallerys as $i => $photo_gallery) : ?>
          <?php   $image_caption = $photo_gallery['caption']; ?>
          <?php   $image_title = $photo_gallery['title']; ?>
            <div class="gallery-item col post-card m-bottom--3">
               
                <label class="gallery-item-link" for="select-<?php echo esc_attr($i); ?>">
                    <img 
                        src="<?php echo esc_url($photo_gallery['url']); ?>" 
                        alt="<?php echo esc_attr($photo_gallery['alt']); ?>" 
                        class="gallery-image fluid-img ps-img"
                        data-fancybox="gallery"
                    />
                </label>
                <input 
                    type="checkbox" 
                    name="selected_images[]" 
                    value="<?php echo esc_url($photo_gallery['url']); ?>" 
                    id="select-<?php echo esc_attr($i); ?>"
                    class="gallery-checkbox"
                />
                <h3 class="title m-top--1 m-bottom--1"><?php echo esc_html( $image_title ); ?></h3>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="bulk-controls m-bottom--3">
        <p><strong>Selected: <span id="selected-count">0</span></strong></p>
        <input type="text" id="zip-filename" placeholder="Optional zip filename (e.g. my-photos)" />
        <button type="submit" id="bulk-download-button">Download Selected</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('bulk-download-form');
    const checkboxes = document.querySelectorAll('.gallery-checkbox');
    const countDisplay = document.getElementById('selected-count');
    const zipInput = document.getElementById('zip-filename');

    function updateCount() {
        const selected = document.querySelectorAll('.gallery-checkbox:checked');
        countDisplay.textContent = selected.length;
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateCount));
    updateCount();

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const selected = Array.from(document.querySelectorAll('.gallery-checkbox:checked'))
            .map(cb => cb.value);
        const zipName = zipInput.value.trim() || 'gallery-download';

        if (selected.length === 0) {
            alert('Please select at least one image.');
            return;
        }

        const formData = new FormData();
        formData.append('action', 'bulk_download_images');
        formData.append('zip_name', zipName);
        selected.forEach((url, i) => {
            formData.append(`selected_images[${i}]`, url);
        });

        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
            method: 'POST',
            body: formData,
        })
        .then(res => res.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = zipName + '.zip';
            a.click();
            window.URL.revokeObjectURL(url);
        })
        .catch(err => alert('Failed to download: ' + err));
    });
});
</script>



        </div>
<?php endif; ?>
            <!-- </div>
        </div>
    </div> -->
</div>
    <?php get_footer(); 