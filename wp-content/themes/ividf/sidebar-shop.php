<?php

	if(is_shop() || is_product_category() || is_product_tag()) {
		$post=get_page(get_option('woocommerce_shop_page_id'));
	}

	get_sidebar();