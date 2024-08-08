<?php
// sizes
$all_sizes = get_terms([
    'taxonomy'      => 'pa_size',
    'hide_empty'    => true
]);

if ($all_sizes) : ?>

<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelSizes" aria-expanded="true" aria-controls="panelSizes">
            Size
        </button>
    </h2>
    <div id="panelSizes" class="accordion-collapse collapse show">
        <div class="accordion-body">
            <ul class="filter filter-sizes">
            <?php
            foreach ($all_sizes as $term) :
                echo "
                <li>
                    <div class='form-check'>
                        <input class='form-check-input' type='checkbox' name='size[]' value='{$term->slug}' data-value='{$term->slug}' id='size{$term->term_id}'>
                        <label class='form-check-label' for='size{$term->term_id}'>
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