<?php

function om_get_icons_list() {
	
	$arr = array(
	
		'fontawesome' => array(
			'name' => 'FontAwesome',
			'prefix' => 'fa-',
			'icons' => array(
				'adjust',
				'adn',
				'align-center',
				'align-justify',
				'align-left',
				'align-right',
				'ambulance',
				'anchor',
				'android',
				'angellist',
				'angle-double-down',
				'angle-double-left',
				'angle-double-right',
				'angle-double-up',
				'angle-down',
				'angle-left',
				'angle-right',
				'angle-up',
				'apple',
				'archive',
				'area-chart',
				'arrow-circle-down',
				'arrow-circle-left',
				'arrow-circle-o-down',
				'arrow-circle-o-left',
				'arrow-circle-o-right',
				'arrow-circle-o-up',
				'arrow-circle-right',
				'arrow-circle-up',
				'arrow-down',
				'arrow-left',
				'arrow-right',
				'arrows',
				'arrows-alt',
				'arrows-h',
				'arrows-v',
				'arrow-up',
				'asterisk',
				'at',
				'automobile',
				'backward',
				'ban',
				'bank',
				'bar-chart',
				'bar-chart-o',
				'barcode',
				'bars',
				'bed',
				'beer',
				'behance',
				'behance-square',
				'bell',
				'bell-o',
				'bell-slash',
				'bell-slash-o',
				'bicycle',
				'binoculars',
				'birthday-cake',
				'bitbucket',
				'bitbucket-square',
				'bitcoin',
				'bold',
				'bolt',
				'bomb',
				'book',
				'bookmark',
				'bookmark-o',
				'briefcase',
				'btc',
				'bug',
				'building',
				'building-o',
				'bullhorn',
				'bullseye',
				'bus',
				'buysellads',
				'cab',
				'calculator',
				'calendar',
				'calendar-o',
				'camera',
				'camera-retro',
				'car',
				'caret-down',
				'caret-left',
				'caret-right',
				'caret-square-o-down',
				'caret-square-o-left',
				'caret-square-o-right',
				'caret-square-o-up',
				'caret-up',
				'cart-arrow-down',
				'cart-plus',
				'cc',
				'cc-amex',
				'cc-discover',
				'cc-mastercard',
				'cc-paypal',
				'cc-stripe',
				'cc-visa',
				'certificate',
				'chain',
				'chain-broken',
				'check',
				'check-circle',
				'check-circle-o',
				'check-square',
				'check-square-o',
				'chevron-circle-down',
				'chevron-circle-left',
				'chevron-circle-right',
				'chevron-circle-up',
				'chevron-down',
				'chevron-left',
				'chevron-right',
				'chevron-up',
				'child',
				'circle',
				'circle-o',
				'circle-o-notch',
				'circle-thin',
				'clipboard',
				'clock-o',
				'close',
				'cloud',
				'cloud-download',
				'cloud-upload',
				'cny',
				'code',
				'code-fork',
				'codepen',
				'coffee',
				'cog',
				'cogs',
				'columns',
				'comment',
				'comment-o',
				'comments',
				'comments-o',
				'compass',
				'compress',
				'connectdevelop',
				'copy',
				'copyright',
				'credit-card',
				'crop',
				'crosshairs',
				'css3',
				'cube',
				'cubes',
				'cut',
				'cutlery',
				'dashboard',
				'dashcube',
				'database',
				'dedent',
				'delicious',
				'desktop',
				'deviantart',
				'diamond',
				'digg',
				'dollar',
				'dot-circle-o',
				'download',
				'dribbble',
				'dropbox',
				'drupal',
				'edit',
				'eject',
				'ellipsis-h',
				'ellipsis-v',
				'empire',
				'envelope',
				'envelope-o',
				'envelope-square',
				'eraser',
				'eur',
				'euro',
				'exchange',
				'exclamation',
				'exclamation-circle',
				'exclamation-triangle',
				'expand',
				'external-link',
				'external-link-square',
				'eye',
				'eyedropper',
				'eye-slash',
				'facebook',
				'facebook-f',
				'facebook-official',
				'facebook-square',
				'fast-backward',
				'fast-forward',
				'fax',
				'female',
				'fighter-jet',
				'file',
				'file-archive-o',
				'file-audio-o',
				'file-code-o',
				'file-excel-o',
				'file-image-o',
				'file-movie-o',
				'file-o',
				'file-pdf-o',
				'file-photo-o',
				'file-picture-o',
				'file-powerpoint-o',
				'files-o',
				'file-sound-o',
				'file-text',
				'file-text-o',
				'file-video-o',
				'file-word-o',
				'file-zip-o',
				'film',
				'filter',
				'fire',
				'fire-extinguisher',
				'flag',
				'flag-checkered',
				'flag-o',
				'flash',
				'flask',
				'flickr',
				'floppy-o',
				'folder',
				'folder-o',
				'folder-open',
				'folder-open-o',
				'font',
				'forumbee',
				'forward',
				'foursquare',
				'frown-o',
				'futbol-o',
				'gamepad',
				'gavel',
				'gbp',
				'ge',
				'gear',
				'gears',
				'genderless',
				'gift',
				'git',
				'github',
				'github-alt',
				'github-square',
				'git-square',
				'gittip',
				'glass',
				'globe',
				'google',
				'google-plus',
				'google-plus-square',
				'google-wallet',
				'graduation-cap',
				'gratipay',
				'group',
				'hacker-news',
				'hand-o-down',
				'hand-o-left',
				'hand-o-right',
				'hand-o-up',
				'hdd-o',
				'header',
				'headphones',
				'heart',
				'heartbeat',
				'heart-o',
				'history',
				'home',
				'hospital-o',
				'hotel',
				'h-square',
				'html5',
				'ils',
				'image',
				'inbox',
				'indent',
				'info',
				'info-circle',
				'inr',
				'instagram',
				'institution',
				'ioxhost',
				'italic',
				'joomla',
				'jpy',
				'jsfiddle',
				'key',
				'keyboard-o',
				'krw',
				'language',
				'laptop',
				'lastfm',
				'lastfm-square',
				'leaf',
				'leanpub',
				'legal',
				'lemon-o',
				'level-down',
				'level-up',
				'life-bouy',
				'life-buoy',
				'life-ring',
				'life-saver',
				'lightbulb-o',
				'line-chart',
				'link',
				'linkedin',
				'linkedin-square',
				'linux',
				'list',
				'list-alt',
				'list-ol',
				'list-ul',
				'location-arrow',
				'lock',
				'long-arrow-down',
				'long-arrow-left',
				'long-arrow-right',
				'long-arrow-up',
				'magic',
				'magnet',
				'mail-forward',
				'mail-reply',
				'mail-reply-all',
				'male',
				'map-marker',
				'mars',
				'mars-double',
				'mars-stroke',
				'mars-stroke-h',
				'mars-stroke-v',
				'maxcdn',
				'meanpath',
				'medium',
				'medkit',
				'meh-o',
				'mercury',
				'microphone',
				'microphone-slash',
				'minus',
				'minus-circle',
				'minus-square',
				'minus-square-o',
				'mobile',
				'mobile-phone',
				'money',
				'moon-o',
				'mortar-board',
				'motorcycle',
				'music',
				'navicon',
				'neuter',
				'newspaper-o',
				'openid',
				'outdent',
				'pagelines',
				'paint-brush',
				'paperclip',
				'paper-plane',
				'paper-plane-o',
				'paragraph',
				'paste',
				'pause',
				'paw',
				'paypal',
				'pencil',
				'pencil-square',
				'pencil-square-o',
				'phone',
				'phone-square',
				'photo',
				'picture-o',
				'pie-chart',
				'pied-piper',
				'pied-piper-alt',
				'pinterest',
				'pinterest-p',
				'pinterest-square',
				'plane',
				'play',
				'play-circle',
				'play-circle-o',
				'plug',
				'plus',
				'plus-circle',
				'plus-square',
				'plus-square-o',
				'power-off',
				'print',
				'puzzle-piece',
				'qq',
				'qrcode',
				'question',
				'question-circle',
				'quote-left',
				'quote-right',
				'ra',
				'random',
				'rebel',
				'recycle',
				'reddit',
				'reddit-square',
				'refresh',
				'remove',
				'renren',
				'reorder',
				'repeat',
				'reply',
				'reply-all',
				'retweet',
				'rmb',
				'road',
				'rocket',
				'rotate-left',
				'rotate-right',
				'rouble',
				'rss',
				'rss-square',
				'rub',
				'ruble',
				'rupee',
				'save',
				'scissors',
				'search',
				'search-minus',
				'search-plus',
				'sellsy',
				'send',
				'send-o',
				'server',
				'share',
				'share-alt',
				'share-alt-square',
				'share-square',
				'share-square-o',
				'shekel',
				'sheqel',
				'shield',
				'ship',
				'shirtsinbulk',
				'shopping-cart',
				'signal',
				'sign-in',
				'sign-out',
				'simplybuilt',
				'sitemap',
				'skyatlas',
				'skype',
				'slack',
				'sliders',
				'slideshare',
				'smile-o',
				'soccer-ball-o',
				'sort',
				'sort-alpha-asc',
				'sort-alpha-desc',
				'sort-amount-asc',
				'sort-amount-desc',
				'sort-asc',
				'sort-desc',
				'sort-down',
				'sort-numeric-asc',
				'sort-numeric-desc',
				'sort-up',
				'soundcloud',
				'space-shuttle',
				'spinner',
				'spoon',
				'spotify',
				'square',
				'square-o',
				'stack-exchange',
				'stack-overflow',
				'star',
				'star-half',
				'star-half-empty',
				'star-half-full',
				'star-half-o',
				'star-o',
				'steam',
				'steam-square',
				'step-backward',
				'step-forward',
				'stethoscope',
				'stop',
				'street-view',
				'strikethrough',
				'stumbleupon',
				'stumbleupon-circle',
				'subscript',
				'subway',
				'suitcase',
				'sun-o',
				'superscript',
				'support',
				'table',
				'tablet',
				'tachometer',
				'tag',
				'tags',
				'tasks',
				'taxi',
				'tencent-weibo',
				'terminal',
				'text-height',
				'text-width',
				'th',
				'th-large',
				'th-list',
				'thumbs-down',
				'thumbs-o-down',
				'thumbs-o-up',
				'thumbs-up',
				'thumb-tack',
				'ticket',
				'times',
				'times-circle',
				'times-circle-o',
				'tint',
				'toggle-down',
				'toggle-left',
				'toggle-off',
				'toggle-on',
				'toggle-right',
				'toggle-up',
				'train',
				'transgender',
				'transgender-alt',
				'trash',
				'trash-o',
				'tree',
				'trello',
				'trophy',
				'truck',
				'try',
				'tty',
				'tumblr',
				'tumblr-square',
				'turkish-lira',
				'twitch',
				'twitter',
				'twitter-square',
				'umbrella',
				'underline',
				'undo',
				'university',
				'unlink',
				'unlock',
				'unlock-alt',
				'unsorted',
				'upload',
				'usd',
				'user',
				'user-md',
				'user-plus',
				'users',
				'user-secret',
				'user-times',
				'venus',
				'venus-double',
				'venus-mars',
				'viacoin',
				'video-camera',
				'vimeo-square',
				'vine',
				'vk',
				'volume-down',
				'volume-off',
				'volume-up',
				'warning',
				'wechat',
				'weibo',
				'weixin',
				'whatsapp',
				'wheelchair',
				'wifi',
				'windows',
				'won',
				'wordpress',
				'wrench',
				'xing',
				'xing-square',
				'yahoo',
				'yelp',
				'yen',
				'youtube',
				'youtube-play',
				'youtube-square',
			),
		),
		
		
		'linecons' => array(
			'name' => 'Linecons',
			'prefix' => 'lic-',
			'icons' => array(
				'banknote',
				'bubble',
				'bulb',
				'calendar',
				'camera',
				'clip',
				'clock',
				'cloud',
				'cup',
				'data',
				'diamond',
				'display',
				'eye',
				'fire',
				'food',
				'key',
				'lab',
				'heart',
				'like',
				'location',
				'lock',
				'mail',
				'megaphone',
				'music',
				'news',
				'note',
				'paperplane',
				'params',
				'pen',
				'phone',
				'photo',
				'search',
				'settings',
				'shop',
				'sound',
				'stack',
				'star',
				'study',
				'tag',
				'trash',
				'truck',
				't-shirt',
				'tv',
				'user',
				'vallet',
				'video',
				'vynil',
				'world',
			),
		),
		
		'typicons' => array(
			'name' => 'Typicons',
			'prefix' => 'typcn-',
			'icons' => array(
				'adjust-brightness',
				'adjust-contrast',
				'anchor-outline',
				'anchor',
				'archive',
				'arrow-back-outline',
				'arrow-back',
				'arrow-down-outline',
				'arrow-down-thick',
				'arrow-down',
				'arrow-forward-outline',
				'arrow-forward',
				'arrow-left-outline',
				'arrow-left-thick',
				'arrow-left',
				'arrow-loop-outline',
				'arrow-loop',
				'arrow-maximise-outline',
				'arrow-maximise',
				'arrow-minimise-outline',
				'arrow-minimise',
				'arrow-move-outline',
				'arrow-move',
				'arrow-repeat-outline',
				'arrow-repeat',
				'arrow-right-outline',
				'arrow-right-thick',
				'arrow-right',
				'arrow-shuffle',
				'arrow-sorted-down',
				'arrow-sorted-up',
				'arrow-sync-outline',
				'arrow-sync',
				'arrow-unsorted',
				'arrow-up-outline',
				'arrow-up-thick',
				'arrow-up',
				'at',
				'attachment-outline',
				'attachment',
				'backspace-outline',
				'backspace',
				'battery-charge',
				'battery-full',
				'battery-high',
				'battery-low',
				'battery-mid',
				'beaker',
				'beer',
				'bell',
				'book',
				'bookmark',
				'briefcase',
				'brush',
				'business-card',
				'calculator',
				'calendar-outline',
				'calendar',
				'camera-outline',
				'camera',
				'cancel-outline',
				'cancel',
				'chart-area-outline',
				'chart-area',
				'chart-bar-outline',
				'chart-bar',
				'chart-line-outline',
				'chart-line',
				'chart-pie-outline',
				'chart-pie',
				'chevron-left-outline',
				'chevron-left',
				'chevron-right-outline',
				'chevron-right',
				'clipboard',
				'cloud-storage',
				'cloud-storage-outline',
				'code-outline',
				'code',
				'coffee',
				'cog-outline',
				'cog',
				'compass',
				'contacts',
				'credit-card',
				'css3',
				'database',
				'delete-outline',
				'delete',
				'device-desktop',
				'device-laptop',
				'device-phone',
				'device-tablet',
				'directions',
				'divide-outline',
				'divide',
				'document-add',
				'document-delete',
				'document-text',
				'document',
				'download-outline',
				'download',
				'dropbox',
				'edit',
				'eject-outline',
				'eject',
				'equals-outline',
				'equals',
				'export-outline',
				'export',
				'eye-outline',
				'eye',
				'feather',
				'film',
				'filter',
				'flag-outline',
				'flag',
				'flash-outline',
				'flash',
				'flow-children',
				'flow-merge',
				'flow-parallel',
				'flow-switch',
				'folder-add',
				'folder-delete',
				'folder-open',
				'folder',
				'gift',
				'globe-outline',
				'globe',
				'group-outline',
				'group',
				'headphones',
				'heart-full-outline',
				'heart-half-outline',
				'heart-outline',
				'heart',
				'home-outline',
				'home',
				'html5',
				'image-outline',
				'image',
				'infinity-outline',
				'infinity',
				'info-large-outline',
				'info-large',
				'info-outline',
				'info',
				'input-checked-outline',
				'input-checked',
				'key-outline',
				'key',
				'keyboard',
				'leaf',
				'lightbulb',
				'link-outline',
				'link',
				'location-arrow-outline',
				'location-arrow',
				'location-outline',
				'location',
				'lock-closed-outline',
				'lock-closed',
				'lock-open-outline',
				'lock-open',
				'mail',
				'map',
				'media-eject-outline',
				'media-eject',
				'media-fast-forward-outline',
				'media-fast-forward',
				'media-pause-outline',
				'media-pause',
				'media-play-outline',
				'media-play-reverse-outline',
				'media-play-reverse',
				'media-play',
				'media-record-outline',
				'media-record',
				'media-rewind-outline',
				'media-rewind',
				'media-stop-outline',
				'media-stop',
				'message-typing',
				'message',
				'messages',
				'microphone-outline',
				'microphone',
				'minus-outline',
				'minus',
				'mortar-board',
				'news',
				'notes-outline',
				'notes',
				'pen',
				'pencil',
				'phone-outline',
				'phone',
				'pi-outline',
				'pi',
				'pin-outline',
				'pin',
				'pipette',
				'plane-outline',
				'plane',
				'plug',
				'plus-outline',
				'plus',
				'point-of-interest-outline',
				'point-of-interest',
				'power-outline',
				'power',
				'printer',
				'puzzle-outline',
				'puzzle',
				'radar-outline',
				'radar',
				'refresh-outline',
				'refresh',
				'rss-outline',
				'rss',
				'scissors-outline',
				'scissors',
				'shopping-bag',
				'shopping-cart',
				'social-at-circular',
				'social-dribbble-circular',
				'social-dribbble',
				'social-facebook-circular',
				'social-facebook',
				'social-flickr-circular',
				'social-flickr',
				'social-github-circular',
				'social-github',
				'social-google-plus-circular',
				'social-google-plus',
				'social-instagram-circular',
				'social-instagram',
				'social-last-fm-circular',
				'social-last-fm',
				'social-linkedin-circular',
				'social-linkedin',
				'social-pinterest-circular',
				'social-pinterest',
				'social-skype-outline',
				'social-skype',
				'social-tumbler-circular',
				'social-tumbler',
				'social-twitter-circular',
				'social-twitter',
				'social-vimeo-circular',
				'social-vimeo',
				'social-youtube-circular',
				'social-youtube',
				'sort-alphabetically-outline',
				'sort-alphabetically',
				'sort-numerically-outline',
				'sort-numerically',
				'spanner-outline',
				'spanner',
				'spiral',
				'star-full-outline',
				'star-half-outline',
				'star-half',
				'star-outline',
				'star',
				'starburst-outline',
				'starburst',
				'stopwatch',
				'support',
				'tabs-outline',
				'tag',
				'tags',
				'th-large-outline',
				'th-large',
				'th-list-outline',
				'th-list',
				'th-menu-outline',
				'th-menu',
				'th-small-outline',
				'th-small',
				'thermometer',
				'thumbs-down',
				'thumbs-ok',
				'thumbs-up',
				'tick-outline',
				'tick',
				'ticket',
				'time',
				'times-outline',
				'times',
				'trash',
				'tree',
				'upload-outline',
				'upload',
				'user-add-outline',
				'user-add',
				'user-delete-outline',
				'user-delete',
				'user-outline',
				'user',
				'vendor-android',
				'vendor-apple',
				'vendor-microsoft',
				'video-outline',
				'video',
				'volume-down',
				'volume-mute',
				'volume-up',
				'volume',
				'warning-outline',
				'warning',
				'watch',
				'waves-outline',
				'waves',
				'weather-cloudy',
				'weather-downpour',
				'weather-night',
				'weather-partly-sunny',
				'weather-shower',
				'weather-snow',
				'weather-stormy',
				'weather-sunny',
				'weather-windy-cloudy',
				'weather-windy',
				'wi-fi-outline',
				'wi-fi',
				'wine',
				'world-outline',
				'world',
				'zoom-in-outline',
				'zoom-in',
				'zoom-out-outline',
				'zoom-out',
				'zoom-outline',
				'zoom',
			),
		),
		
	);
	
	return $arr;
	
}

function om_get_icons_options_list($selected='') {
	
	$arr=om_get_icons_list();
	$out='<option value="">'.__('No icon','om_theme').'</option>';
	foreach($arr as $id=>$v) {
		$out.='<optgroup label="'.$v['name'].'">';
		foreach($v['icons'] as $icon) {
			$value=$v['prefix'].$icon;
			$out.='<option value="'.$value.'" '.selected($value, $selected, false).'>'.$icon.'</option>';
		}
		$out.='</optgroup>';
	}
	
	return $out;
}

function om_get_icons_preview_list() {
	
	$arr=om_get_icons_list();
	$out='';
	foreach($arr as $id=>$v) {
		$out.='<div class="om-items-group-label">'.$v['name'].'</div>';
		foreach($v['icons'] as $icon) {
			$value=$v['prefix'].$icon;
			$out.='<div class="om-item" title="'.esc_attr($icon).'" data-icon="'.$value.'"><i class="'.om_icon_classes($value).'"></i></div>';
		}
	}
	
	return $out;
}

function om_icon_classes($icon) {
	
	$classes='';
	
	if($icon) {
		if( substr($icon,0,3) == 'fa-' ) {
			wp_enqueue_style('font-awesome');
			//wp_enqueue_script('font-awesome-loader');
			$classes.='omfi font-fa '.$icon;
		} elseif(substr($icon,0,4) == 'lic-') {
			wp_enqueue_style('linecons-omfi-ext');
			//wp_enqueue_script('linecons-omfi-ext-loader');
			$classes.='omfi font-lic '.$icon;
		} elseif(substr($icon,0,6) == 'typcn-') {
			wp_enqueue_style('typicons');
			//wp_enqueue_script('typicons-loader');
			$classes.='omfi font-typcn '.$icon;
		}
	}
	
	return $classes;
		
}

function om_icon_classes_before($icon) {
	
	$classes='';
	
	if($icon) {
		if( substr($icon,0,3) == 'fa-' ) {
			wp_enqueue_style('font-awesome');
			//wp_enqueue_script('font-awesome-loader');
			$classes.='omfi-before font-fa '.$icon;
		} elseif(substr($icon,0,4) == 'lic-') {
			wp_enqueue_style('linecons-omfi-ext');
			//wp_enqueue_script('linecons-omfi-ext-loader');
			$classes.='omfi-before font-lic '.$icon;
		} elseif(substr($icon,0,6) == 'typcn-') {
			wp_enqueue_style('typicons');
			//wp_enqueue_script('typicons-loader');
			$classes.='omfi-before font-typcn '.$icon;
		}
	}
	
	return $classes;
		
}