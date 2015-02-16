<form role="search" method="get" class="form-inline clearfix" action="<?php echo home_url( '/' ); ?>">
        <div class="form-group">
                <label>
                        <span class="sr-only"><?php echo _x( 'Search for:', 'label' ) ?></span>
                </label>
                <input type="search" class="form-control" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search', 'label' ) ?>" />
        </div>
	<button type="submit" class="btn btn-primary" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>">Search</button>
</form>