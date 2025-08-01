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
            

  
            <form id="bulk-download-form">
    <div id="gallery" class="the_gallery row row-cols-lg-3 row-cols-md-2 row-cols-1 gap-2">
    <?php  $i = 1; ?>
        <?php foreach ($photo_gallerys as $i => $photo_gallery) : ?>
          <?php   $image_caption = $photo_gallery['caption']; ?>
          <?php   $image_title = $photo_gallery['title']; ?>
            <div class="gallery-item col post-card m-bottom--3">
            <input 
                    type="checkbox" 
                    name="selected_images[]" 
                    value="<?php echo esc_url($photo_gallery['url']); ?>" 
                    id="select-<?php echo esc_attr($i); ?>"
                    class="gallery-checkbox"
                />
                <label for="select-<?php echo esc_attr($i); ?>">
                <a class="gallery-item-link " href="<?php echo esc_url($photo_gallery['url']); ?>"  data-fancybox="gallery">
                    <img 
                        src="<?php echo esc_url($photo_gallery['url']); ?>" 
                        alt="<?php echo esc_attr($photo_gallery['alt']); ?>" 
                        class="gallery-image fluid-img ps-img"
                    />
        </a>
                    <span class="gallery-number"><?php echo esc_html($i); ?></span>
                </label>
              
                <h3 class="title m-top--1 m-bottom--1"><?php echo esc_html( $image_title ); ?></h3>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- <div class="bulk-controls m-bottom--3">
        <p><strong>Selected: <span id="selected-count">0</span></strong></p>
        <input type="text" id="zip-filename" placeholder="Optional zip filename (e.g. my-photos)" />
        <button type="submit" id="bulk-download-button">Download Selected</button>
    </div> -->
      <div class="bulk-controls">
        <p><strong>Selected: <span id="selected-count">0</span></strong></p>
        <input type="email" id="newsletter-email" placeholder="Enter your email" required />
        <button type="submit" id="bulk-download-button">Subscribe & Get Link</button>
    </div>
</form>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('bulk-download-form');
    const checkboxes = document.querySelectorAll('.gallery-checkbox');
    const countDisplay = document.getElementById('selected-count');
    const emailInput = document.getElementById('newsletter-email');
    const messageBox = document.getElementById('form-message');

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
        const email = emailInput.value.trim();

        if (!email || !email.includes('@')) {
            alert('Please enter a valid email.');
            return;
        }
        if (selected.length === 0) {
            alert('Please select at least one image.');
            return;
        }

        const formData = new FormData();
        formData.append('action', 'send_newsletter_download');
        formData.append('email', email);
        selected.forEach((url, i) => {
            formData.append(`selected_images[${i}]`, url);
        });

        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
            method: 'POST',
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            messageBox.textContent = data.message;
            if (data.success) {
                form.reset();
                countDisplay.textContent = "0";
            }
        })
        .catch(err => alert('Something went wrong: ' + err));
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