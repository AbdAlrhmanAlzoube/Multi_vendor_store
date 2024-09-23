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
        'icon'=>'far fa-tags nav-icon',
        'route'=>'dashboard.categories.index',
        'title'=>'categories',
        'badge'=>'New',
        'active'=>'dashboard.categories.*',
        'ability'=>'categories.view'

    ],

    [
        'icon'=>'far fa-box nav-icon',
        'route'=>'dashboard.products.index',
        'title'=>'Product',
        'active'=>'dashboard.products.*',
        'ability'=>'producats.view'


    ],

// [
//     'icon'=>'far fa-receipt nav-icon',
//     'route'=>'dashboard.',
//     'title'=>'User',
//     'acti3ve'=>'dashboard.users.*',
//     'ability'=>'users.view'


// ],

[
    'icon'=>'far fa-shield nav-icon',
    'route'=>'dashboard.roles.index',
    'title'=>'Role',
    'active'=>'dashboard.roles.*',
    'ability'=>'roles.view'
],
[
    'icon'=>'far fa-users nav-icon',
    'route'=>'dashboard.users.index',
    'title'=>'User',
    'active'=>'dashboard.users.*',
    'ability'=>'users.view'
],
[
    'icon'=>'far fa-shield nav-icon',
    'route'=>'dashboard.admins.index',
    'title'=>'Admin',
    'active'=>'dashboard.admins.*',
    'ability'=>'admins.view'
],


];