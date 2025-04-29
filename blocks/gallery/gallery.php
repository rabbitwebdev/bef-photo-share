<?php
/**
 * Gallery Block template.
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.

$image             = get_field( 'image' );
$background_color  = get_field( 'background_color' ); // ACF's color picker.
$text_color        = get_field( 'text_color' ); // ACF's color picker.


// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'gallery-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}
if ( $background_color || $text_color ) {
    $class_name .= ' has-custom-acf-color';
}

// Build a valid style attribute for background and text colors.
$styles = array( 'background-color: ' . $background_color, 'color: ' . $text_color );
$style  = implode( '; ', $styles );
?>

<div <?php echo esc_attr( $anchor ); ?>class="<?php echo esc_attr( $class_name ); ?>" >
   <div class="container">
<?php
$photo_share_block_style = get_field('photo_share_block_style');
if( $photo_share_block_style == 'grid' ) {
  

$photo_shares = get_field('the_photo_share_bef');
if( $photo_shares ): ?>
    <div class="cards gallery-ps-grid justify-content-center  row row-cols-lg-3 row-cols-md-2 row-cols-1 gap-2">
        <?php foreach( $photo_shares as $photo_share ): 
            $permalink = get_permalink( $photo_share->ID );
            $title = get_the_title( $photo_share->ID );
            $featured_photo_img = get_the_post_thumbnail_url($photo_share->ID);
            $ps_event_date = get_field( 'ps_event_date', $photo_share->ID );
            $ps_event_location = get_field( 'ps_event_location', $photo_share->ID );
            $custom_field = get_field( 'field_name', $photo_share->ID );
            ?>
                <div class="card col m-bottom--3">
                    <a class="post-card post-card--small p-bottom--3" href="<?php echo esc_url( $permalink ); ?>">
                        <?php if ( has_post_thumbnail($photo_share->ID) ) { ?>
                            <img src="<?php echo esc_url($featured_photo_img); ?>" class="card-img m-bottom--1" alt="..bjb.">
                        <?php } ?>
                        <div class="post-card__content-container">
                            <h3 class="post-card__title m-bottom--1"><?php echo esc_html( $title ); ?></h3>
                            <div class="post-card__content-row p-top--2 post-card__content-meta-row">
                                <div class="post-card__tags">
                                    <?php if ( $ps_event_date ) : ?>
                                        <p class="post-card__date post-card__tag"><?php echo esc_html( $ps_event_date ); ?></p>
                                    <?php endif; ?>
                                    <?php if ( $ps_event_location ) : ?>
                                        <p class="post-card__date post-card__tag"><?php echo esc_html( $ps_event_location ); ?></p>
                                    <?php endif; ?>

                                    <p class="view post-card__location post-card__category">View Gallery</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php } else {
  $photo_shares = get_field('the_photo_share_bef');
if( $photo_shares ): ?>
<div class="swiper photo-share-swiper">
    <div class="swiper-wrapper">
        <?php foreach( $photo_shares as $photo_share ): 
            $permalink = get_permalink( $photo_share->ID );
            $title = get_the_title( $photo_share->ID );
            $featured_photo_img = get_the_post_thumbnail_url($photo_share->ID);
            $ps_event_date = get_field( 'ps_event_date', $photo_share->ID );
            $ps_event_location = get_field( 'ps_event_location', $photo_share->ID );
            $custom_field = get_field( 'field_name', $photo_share->ID );
            ?>
                <div class="swiper-slide">
                    <a class="post-card  p-bottom--3" href="<?php echo esc_url( $permalink ); ?>">
                        <?php if ( has_post_thumbnail($photo_share->ID) ) { ?>
                            <img src="<?php echo esc_url($featured_photo_img); ?>" class="card-img slider-photo-img m-bottom--1" alt="..bjb.">
                        <?php } ?>
                        <div class="post-card__content-container">
                            <h3 class="post-card__title m-bottom--1"><?php echo esc_html( $title ); ?></h3>
                            <div class="post-card__content-row p-top--2 post-card__content-meta-row">
                                <div class="post-card__tags">
                                    <?php if ( $ps_event_date ) : ?>
                                        <p class="post-card__date post-card__tag"><?php echo esc_html( $ps_event_date ); ?></p>
                                    <?php endif; ?>
                                    <?php if ( $ps_event_location ) : ?>
                                        <p class="post-card__date post-card__tag"><?php echo esc_html( $ps_event_location ); ?></p>
                                    <?php endif; ?>

                                    <p class="view post-card__location post-card__category">View Gallery</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>



<?php endforeach; ?>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Navigation -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
<?php endif; ?>
   <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swiperPS = new Swiper('.photo-share-swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
    slidesPerView: 2.2,
    spaceBetween: 50,
    // If we need pagination
   
  on: {
    init: function () {
      console.log('photo-share-swiper initialized');
    },
  },
});
</script>
<?php } ?>
</div>
</div>