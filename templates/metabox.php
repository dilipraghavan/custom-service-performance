<div class='service-meta-box-container'>
    <input id='service_icon' type='hidden' name='service_icon' />

    <div class='sub-fields'>
        <button id='service_icon_btn'>Select Icon</button>
        <img id='service_icon_preview' src="<?php echo esc_url($service_icon_url); ?>" alt='No Service Icon' />
    </div>

    <div class='sub-fields'>
        <label for='service_name'>Service Name</label>
        <input id='service_name' type='text' name='service_name' value="<?php echo esc_attr($service_name); ?>">
    </div>
    
    <div class='sub-fields'>
        <label for='service_description'>Service Description</label>
        <textarea id='service_description' name='service_description' ><?php echo esc_textarea($service_description); ?></textarea>
    </div>

    <?php wp_nonce_field('service_meta_box_nonce', 'service_meta_box'); ?>
</div>