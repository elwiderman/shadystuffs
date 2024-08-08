<?php
// stock
$all_stock = [
    'instock'       => __('In Stock', 'shady'), 
    // 'outofstock'    => __('Out of Stock', 'shady')
];

if ($all_stock) : ?>

<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelStock" aria-expanded="true" aria-controls="panelStock">
            Stock Status
        </button>
    </h2>
    <div id="panelStock" class="accordion-collapse collapse show">
        <div class="accordion-body">
            <ul class="filter filter-stock">
            <?php
            foreach ($all_stock as $key => $term) :
                // mark as checked by default if it is the current tax term
                $checked    = $key == 'instock' ? 'checked="checked"' : '';
                echo "
                <li>
                    <div class='form-check'>
                        <input class='form-check-input' type='checkbox' name='stock[]' value='{$key}' id='stock-{$key}' data-value='{$key}' {$checked}>
                        <label class='form-check-label' for='stock-{$key}'>
                            {$term}
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