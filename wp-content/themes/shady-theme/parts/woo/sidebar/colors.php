<?php
// colors
$all_colors = get_terms([
    'taxonomy'      => 'pa_color',
    'hide_empty'    => true
]);

if ($all_colors) : ?>

<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelColors" aria-expanded="true" aria-controls="panelColors">
            Color
        </button>
    </h2>
    <div id="panelColors" class="accordion-collapse collapse show">
        <div class="accordion-body">
            <ul class="filter filter-colors">
            <?php
            foreach ($all_colors as $term) :
                $color  = get_term_meta($term->term_id, 'cfvsw_color', true);
                $color  = $color ? $color : '#fff';
                echo "
                <li>
                    <div class='form-check'>
                        <input class='form-check-input' type='checkbox' name='color[]' value='{$term->slug}' data-value='{$term->slug}' id='color{$term->term_id}'>
                        <label class='form-check-label' for='color{$term->term_id}'>
                            <span class='color-box' style='background:{$color};'></span>
                            {$term->name}
                        </label>
                    </div>
                </li>";
            endforeach;
            ?>
            </ul>
        </div>
    </div>
</div>

<?php
endif;