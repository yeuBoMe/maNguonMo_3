<?php
/*
Plugin Name: Quick Contact Button
Description: Hiển thị nút liên hệ nhanh qua Zalo và Messenger.
Version: 1.2
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Ngăn truy cập trực tiếp
}

// Đăng ký shortcode
add_shortcode('quick_contact', 'qcb_display_contact_buttons');

function qcb_display_contact_buttons($atts) {
    $atts = shortcode_atts([
        'zalo_phone' => '0962411916',
        'zalo_label' => 'Liên hệ Zalo',
        'messenger_link' => 'https://www.messenger.com/e2ee/t/7082885941731848',
        'messenger_label' => 'Liên hệ Messenger',
        'bg_color' => '#0088cc',
        'text_color' => '#ffffff'
    ], $atts);

    $zalo_phone = esc_attr($atts['zalo_phone']);
    $zalo_label = esc_html($atts['zalo_label']);
    $messenger_link = esc_url($atts['messenger_link']);
    $messenger_label = esc_html($atts['messenger_label']);
    $bg_color = esc_attr($atts['bg_color']);
    $text_color = esc_attr($atts['text_color']);

    return '<div class="quick-contact-buttons">
                <a href="https://zalo.me/' . $zalo_phone . '" target="_blank" class="quick-contact-link" style="background-color: ' . $bg_color . '; color: ' . $text_color . ';">
                    <i class="fas fa-comments"></i> ' . $zalo_label . '
                </a>
                <a href="' . $messenger_link . '" target="_blank" class="quick-contact-link" style="background-color: #0078FF; color: ' . $text_color . ';">
                    <i class="fab fa-facebook-messenger"></i> ' . $messenger_label . '
                </a>
            </div>';
}

// Đăng ký Font Awesome
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
});

// Thêm CSS trực tiếp vào trang
add_action('wp_head', function() {
    echo '<style>
        .quick-contact-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .quick-contact-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 15px 20px;
            text-decoration: none;
            border-radius: 50px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
        .quick-contact-link:hover {
            opacity: 0.8;
        }
        .quick-contact-link i {
            margin-right: 10px;
        }
    </style>';
});

// Thêm nút liên hệ vào footer
add_action('wp_footer', function() {
    $zalo_phone = get_option('qcb_zalo_phone', '0962411916');
    $zalo_label = get_option('qcb_zalo_label', 'Liên hệ Zalo');
    $messenger_link = get_option('qcb_messenger_link', 'https://www.messenger.com/e2ee/t/7082885941731848');
    $messenger_label = get_option('qcb_messenger_label', 'Liên hệ Messenger');
    $bg_color = get_option('qcb_bg_color', '#0088cc');
    $text_color = get_option('qcb_text_color', '#ffffff');

    echo '<div class="quick-contact-buttons">
            <a href="https://zalo.me/' . esc_attr($zalo_phone) . '" target="_blank" class="quick-contact-link" style="background-color: ' . esc_attr($bg_color) . '; color: ' . esc_attr($text_color) . ';">
                <i class="fas fa-comments"></i> ' . esc_html($zalo_label) . '
            </a>
            <a href="' . esc_url($messenger_link) . '" target="_blank" class="quick-contact-link" style="background-color: #0078FF; color: ' . esc_attr($text_color) . ';">
                <i class="fab fa-facebook-messenger"></i> ' . esc_html($messenger_label) . '
            </a>
          </div>';
});