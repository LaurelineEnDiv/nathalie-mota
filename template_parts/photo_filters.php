<form id="photo-filters">
        <div class="filter-group">
            <select name="categorie" id="categorie">
                <option value="">Catégories</option>
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'categorie',
                    'hide_empty' => true,
                ));
                foreach ($categories as $category) {
                    $selected = (isset($_GET['categorie']) && $_GET['categorie'] === $category->slug) ? 'selected' : '';
                    echo "<option value='{$category->slug}' $selected>{$category->name}</option>";
                }
                ?>
            </select>
        </div>

        <div class="filter-group">
            <select name="format" id="format">
                <option value="">Formats</option>
                <?php
                $formats = get_terms(array(
                    'taxonomy' => 'format',
                    'hide_empty' => true,
                ));
                foreach ($formats as $format) {
                    $selected = (isset($_GET['format']) && $_GET['format'] === $format->slug) ? 'selected' : '';
                    echo "<option value='{$format->slug}' $selected>{$format->name}</option>";
                }
                ?>
            </select>
        </div>
    </form>