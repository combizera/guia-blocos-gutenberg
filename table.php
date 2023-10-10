<?php

/**
 * Plugin Name: Tabela de Pontuação
 * Text Domain: Tabela de Pontuação
 */
defined('ABSPATH') || exit;
require_once('vendor/autoload.php');

use Carbon_Fields\Block;
use Carbon_Fields\Field;

function advbox_table_task()
{
  Block::make('Tabela de Pontuação')
    ->add_fields(array(
      Field::make('text', 'heading', 'Bloco de Título'),
      Field::make('image', 'image', 'Bloco de Imagem'),
      Field::make('complex', 'content', 'Bloco de Conteúdo'),
    ))
    ->set_render_callback(function ($fields) {
?>

    <div class="block">
      <div class="block__heading">
        <h1><?php echo esc_html($fields['heading']); ?></h1>
      </div><!-- /.block__heading -->

      <div class="block__image">
        <?php echo wp_get_attachment_image($fields['image'], 'full'); ?>
      </div><!-- /.block__image -->

      <div class="block__content">
        <?php echo apply_filters('the_content', $fields['content']); ?>
      </div><!-- /.block__content -->
    </div><!-- /.block -->
<?php
    });
}


function crb_load()
{
  require_once('vendor/autoload.php');
  \Carbon_Fields\Carbon_Fields::boot();
}
add_action('after_setup_theme', 'crb_load');
add_action('carbon_fields_register_fields', 'advbox_table_task');
