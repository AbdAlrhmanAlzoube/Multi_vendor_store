<?php

return
[
    [
        'icon'=>'nav-icon fas fa-tachometer-alt',
        'route'=>'dashboard.',
        'title'=>'Dashboard',
        'active'=>'dashboard.'
    ],

    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'dashboard.categories.index',
        'title'=>'categories',
        'badge'=>'New',
        'active'=>'dashboard.categories.*'
    ],

    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'dashboard.',
        'title'=>'Product',
        'active'=>'dashboard.products.*'

    ],
    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'dashboard.',
        'title'=>'Order',
        'active'=>'dashboard.ordeers.*'

    ],
];