<?php

return [

    'fields' => [

        'search_query' => [
            'label' => 'جستجو',
            'placeholder' => 'جستجو',
        ],

    ],

    'pagination' => [

        'label' => 'صفحه بندی',

        'overview' => 'در حال نمایش :first به :last از :total نتایج',

        'fields' => [

            'records_per_page' => [
                'label' => 'در هر صفحه',
            ],

        ],

        'buttons' => [

            'go_to_page' => [
                'label' => 'برو به صفحه :page',
            ],

            'next' => [
                'label' => 'بعدی',
            ],

            'previous' => [
                'label' => 'قبلی',
            ],

        ],

    ],

    'buttons' => [

        'filter' => [
            'label' => 'فیلتر',
        ],

        'open_actions' => [
            'label' => 'بازکردن عملیات',
        ],

        'toggle_columns' => [
            'label' => 'باز/بستن ستون ها',
        ],

    ],

    'actions' => [

        'replicate' => [

            'label' => 'تکثیر',

            'messages' => [
                'replicated' => 'رکورد تکثیر شد',
            ],

        ],

    ],

    'empty' => [
        'heading' => 'هیچ رکوردی یافت نشد',
    ],

    'filters' => [

        'buttons' => [

            'reset' => [
                'label' => 'پاک کردن فیلترها',
            ],

            'close' => [
                'label' => 'بستن',
            ],

        ],

        'multi_select' => [
            'placeholder' => 'همه',
        ],

        'select' => [
            'placeholder' => 'همه',
        ],

    ],

    'selection_indicator' => [

        'selected_count' => '1 آیتم انتخاب شده.|:count آیتم انتخاب شده.',

        'buttons' => [

            'select_all' => [
                'label' => 'انتخاب همه‌ی :count آیتم',
            ],

            'deselect_all' => [
                'label' => 'عدم انتخاب',
            ],

        ],

    ],

];
