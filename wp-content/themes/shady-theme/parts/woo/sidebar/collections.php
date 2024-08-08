<?php
// collections
$all_collections = get_terms([
    'taxonomy'      => 'collection',
    'hide_empty'    => false
]);

if ($all_collections) : ?>

<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelCollections" aria-expanded="true" aria-controls="panelCollections">
            Collections
        </button>
    </h2>
    <div id="panelCollections" class="accordion-collapse collapse show">
        <div class="accordion-body">
            <ul class="filter filter-collections">
            <?php
            foreach ($all_collections as $term) :
                // mark as checked by default if it is the current tax term
                $checked        = '';
                if (is_tax('collection')) :
                    // $q_obj  = get_queried_object();
                    $checked    = (get_queried_object()->term_id == $term->term_id) ? 'checked="checked"' : '';
                endif;
                echo "
                <li>
                    <div class='form-check'>
                        <input class='form-check-input' type='checkbox' name='collection[]' value='{$term->slug}' id='collection{$term->term_id}' data-value='{$term->slug}' {$checked}>
                        <label class='form-check-label' for='collection{$term->term_id}'>
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