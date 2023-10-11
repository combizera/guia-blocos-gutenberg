<?php

/**
 * Plugin Name: Blocos Biblioteca - ADVBOX
 * Text Domain: Blocos Biblioteca - ADVBOX
 * * Version: 1.0
 * Author: Ygor Combi
 * License: GPL
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.0
 * Contributors: Equipe ADVBOX 🫰
 * Requires PHP: 7.0
 */

defined('ABSPATH') || exit;
require_once('vendor/autoload.php');

use Carbon_Fields\Block;
use Carbon_Fields\Field;

// TABELA DE PONTUAÇÃO
function advbox_table_task()
{
  Block::make('Tabela de Pontuação')
    ->add_fields(array(
      Field::make('complex', 'tarefas', __('Tarefas'))
        ->add_fields(array(
          Field::make('text', 'tarefa', __('Tarefa')),
          Field::make('text', 'pontuacao', __('Pontuação')),
          Field::make('text', 'explicacao', __('Explicação')),
        ))
    ))
    ->set_icon('awards')
    ->set_render_callback(function ($fields) {
      // Recupera o valor do campo 'tarefas'
      $tarefas = $fields['tarefas'];

      if (!empty($tarefas)) {
        echo '<table class="table">';
        echo '<thead><tr><th>Tarefa</th><th>Pontuação</th></tr></thead>';
        echo '<tbody>';

        foreach ($tarefas as $tarefa) {
          $tarefa_nome = $tarefa['tarefa'];
          $tarefa_pontuacao = $tarefa['pontuacao'];
          $tarefa_explicacao = $tarefa['explicacao'];

          echo '<tr>';
          echo '<td class="tarefa">' . esc_html($tarefa_nome);

          // Verifica se há uma explicação para a tarefa
          if (!empty($tarefa_explicacao)) {
            echo '<div class="tooltip">?<span class="tooltiptext">' . esc_html($tarefa_explicacao) . '</span></div>';
          }

          echo '</td>';

          echo '<td class="pontuacao">' . esc_html($tarefa_pontuacao) . '</td>';
          echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
      }
    });
}

function crb_load()
{
  require_once('vendor/autoload.php');
  \Carbon_Fields\Carbon_Fields::boot();
}
add_action('after_setup_theme', 'crb_load');
add_action('carbon_fields_register_fields', 'advbox_table_task');

// CHAMANDO OS ESTILOS
function enqueue_custom_styles()
{
  wp_enqueue_style('custom-table-styles', plugins_url('assets/css/style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
