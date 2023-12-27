<?php
require "../auth.php";

// truncate existing tables
db_query('TRUNCATE TABLE `dbp_training_pages`');

$leftNav = [
    [
        'section' => 'welcome',
        'section_name' => 'Welcome Agreement',
        'pages' => [
            [
                'page' => 'how_it_works',
                'title' => 'What to Expect'
            ]
        ]
    ],
    [
        'section'      => 'user',
        'section_name' => 'User Management',
        'pages' => [
            [
                'page'  => 'welcome',
                'title' => 'Welcome',
                
            ],
            [
                'page'  => 'customer_dashboard',
                'title' => 'Customer Dashboard',
                
            ],
            [
                'page'  => 'create_test_customer',
                'title' => 'Create Test Customer',
                
            ],
            [
                'page'  => 'view_as_customer',
                'title' => 'View as Customer',
                
            ],
            [
                'page'  => 'assign_membership',
                'title' => 'Assign Membership',
                
            ],
            [
                'page'  => 'assign_permissions',
                'title' => 'Assign Permissions',
                
            ],
            [
                'page'  => 'create_drivers',
                'title' => 'Create Drivers',
                
            ],
            [
                'page'  => 'create_suppliers',
                'title' => 'Create Suppliers',
                
            ],
            [
                'page'  => 'fill_company_settings',
                'title' => 'Fill Company Settings',
                
            ],
            [
                'page'  => 'q_a',
                'title' => 'Q&A',
                
            ],
        ]
    ],
    [
        'section'      => 'product',
        'section_name' => 'Product Management',
        'pages' => [
            [
                'page'  => 'welcome',
                'title' => 'Welcome',
                
            ],
            [
                'page'  => 'import',
                'title' => 'Import Products',
    
            ],
            [
                'page'  => 'product_management',
                'title' => 'Product Management',
                
            ],
            [
                'page'  => 'produce_category',
                'title' => 'Producer Category',
                
            ],
            [
                'page'  => 'category_options',
                'title' => 'Category Options',
                
            ],
            [
                'page'  => 'add_to_featured_products',
                'title' => 'Add to Featured Products',
                
            ],
            [
                'page'  => 'create_products',
                'title' => 'Create Products',
                
            ],
            [
                'page'  => 'add_advance_options',
                'title' => 'Add Advance Options',
                
            ],
            [
                'page'  => 'set_up_delivery_fees',
                'title' => 'Set up Delivery Fees',
                
            ],
            [
                'page'  => 'set_up_taxes',
                'title' => 'Set up Taxes',
                
            ],
            [
                'page'  => 'set_up_deposits',
                'title' => 'Set up Deposits',
                
            ],
            [
                'page'  => 'q_a',
                'title' => 'Q&A',
                
            ],
        ]
    ],
    [
        'section'      => 'box',
        'section_name' => 'Box Building',
        'pages' => [
            [
                'page'  => 'welcome',
                'title' => 'Welcome',
                
            ],
            [
                'page'  => 'box_building_training',
                'title' => 'Box Building Training',
                
            ],
            [
                'page'  => 'add_update_subproducts',
                'title' => 'Add/Update Subproducts',
                
            ],
            [
                'page'  => 'create_your_boxes',
                'title' => 'Create your Boxes',
                
            ],
            [
                'page'  => 'q_a',
                'title' => 'Q&A',
                
            ],
        ]
    ],
    [
        'section'      => 'route',
        'section_name' => 'Routes Management',
        'pages' => [
            [
                'page'  => 'welcome',
                'title' => 'Welcome',
                
            ],
            [
                'page'  => 'kml_vs_zip',
                'title' => 'KML vs Zip/Postal Code',
                
            ],
            [
                'page'  => 'upload_test_to_dbp',
                'title' => 'Upload Test to DBP',
                
            ],
            [
                'page'  => 'assign_area_names',
                'title' => 'Assign Area Names',
                
            ],
            [
                'page'  => 'routes_management',
                'title' => 'Routes Management',
                'url'   => ''
            ],
            [
                'page'  => 'create_routes',
                'title' => 'Create Routes',
                
            ],
            [
                'page'  => 'assign_drivers_to_routes',
                'title' => 'Assign Drivers to Routes ',
                
            ],
            [
                'page'  => 'organize_load_sheet',
                'title' => 'Organize Load Sheet',
                
            ],
            [
                'page'  => 'organize_route_stops',
                'title' => 'Organize Route Stops',
                
            ],
            [
                'page'  => 'manage_pickup_locations',
                'title' => 'Manage Pickup Locations',
                
            ],
            [
                'page'  => 'test_printing_routes',
                'title' => 'Test Printing Routes',
                
            ],
            [
                'page'  => 'choose_bag_labels',
                'title' => 'Choose Bag Labels',
                
            ],
            [
                'page'  => 'use_driver_app',
                'title' => 'Use Driver App?',
                
            ],
            [
                'page'  => 'enable_driver_app',
                'title' => 'Enable Driver App',
                
            ],
            [
                'page'  => 'how_to_use_driver_app',
                'title' => 'How to Use Driver App',
                
            ],
            [
                'page'  => 'driver_app_sms',
                'title' => 'Driver App (SMS)',
                
            ],
            [
                'page'  => 'q_a',
                'title' => 'Q&A',
                
            ],
            [
                'page'  => 'demo_on_getswift',
                'title' => 'Demo on GetSwift',
                
            ],
        ]
    ],
    [
        'section'      => 'marketing',
        'section_name' => 'Marketing',
        'pages' => [
            [
                'page'  => 'welcome',
                'title' => 'Welcome',
                
            ],
            [
                'page'  => 'smtp_and_domain',
                'title' => 'SMTP Protocol & Domain',
    
            ],
            [
                'page'  => 'marketing_customer',
                'title' => 'Marketing & Communication',
                
            ],
            [
                'page'  => 'membership_levels',
                'title' => 'Membership Levels',
                
            ],
            [
                'page'  => 'autoresponders',
                'title' => 'Autoresponders',
                
            ],
            [
                'page'  => 'newsletters_lists',
                'title' => 'Newsletters/Lists',
                
            ],
            [
                'page'  => 'gift_option',
                'title' => 'Gift Certificates',
                
            ],
            [
                'page'  => 'coupons',
                'title' => 'Coupons',
                
            ],
            [
                'page'  => 'global_discounts',
                'title' => 'Global Discounts',
                
            ],
            [
                'page'  => 'password_go_live',
                'title' => 'Password & Go-Live',
                
            ],
            [
                'page'  => 'friend_referral_report',
                'title' => 'Friend Referral Report',
                
            ],
            [
                'page'  => 'q_a',
                'title' => 'Q&A',
                
            ],
        ]
    ],
    [
        'section'      => 'inventory',
        'section_name' => 'Inventory, Billing',
        'pages' => [
            [
                'page'  => 'welcome',
                'title' => 'Welcome',
                
            ],
            [
                'page'  => 'inventory',
                'title' => 'Inventory',
                
            ],
            [
                'page'  => 'billing',
                'title' => 'Billing',
                
            ],
            [
                'page'  => 'refund_within_dbp',
                'title' => 'Refund within DBP',
                
            ],
            [
                'page'  => 'customer_invoices',
                'title' => 'Printing Customer Invoices',
                
            ],
            [
                'page'  => 'purchase_orders',
                'title' => 'Purchase Orders',
                
            ],
            [
                'page'  => 'creating_orders',
                'title' => 'Creating Orders',
                
            ],
            [
                'page'  => 'customer_base_email',
                'title' => 'Preparing Customers for Go-Live',
                
            ],
            [
                'page'  => 'reports',
                'title' => 'Reports',
                
            ],
            [
                'page'  => 'q_a',
                'title' => 'Q&A',
                
            ],
            [
                'page'  => 'domain_authentication',
                'title' => 'Domain Authentication',
            ],
            [
                'page'  => 'payment_gateway',
                'title' => 'Payment Gateway',
            ],
        ]
    ],
    [
        'section'      => 'q_a',
        'section_name' => 'Quality Assurance',
        'pages' => [
            [
                'page'  => 'welcome',
                'title' => 'Welcome',
            
            ],
            [
                'page'  => 'testing_scenarios',
                'title' => 'Testing Scenarios',
            
            ],
            [
                'page'  => 'enable_autoresponders',
                'title' => 'Enable Autoresponders',
            
            ],
            [
                'page'  => 'verify_text',
                'title' => 'Verify Text',
            
            ],
            [
                'page'  => 'full_size_preparation',
                'title' => 'Full Site Preparation',
            
            ],
            [
                'page'  => 'shop_only_preparation',
                'title' => 'Shop Only Preparation',
            
            ],
            [
                'page'  => 'import_sheet_for_customers',
                'title' => 'Import Sheet for Customers',
            
            ],
            [
                'page'  => 'import_sheet_for_recurring_orders',
                'title' => 'Import Sheet for Recurring Orders',
            
            ],
            [
                'page'  => 'schedule_for_go_live',
                'title' => 'Schedule for Go-Live',
            
            ],
        ]
    ],
];

foreach ($leftNav as $section) {
    foreach ($section['pages'] as $page) {
        $insertData = [
            'section' => $section['section'],
            'section_name' => $section['section_name'],
            'page' => $page['page'],
            'page_title' => $page['title'],
            'checked' => ''
        ];
        db_query_builder()->array2insert('training_pages', $insertData);
    }
}

$leftNavMasterOnly = [
    [
        'section'      => 'go_live',
        'section_name' => 'Go-Live',
        'pages' => [
            [
                'page'  => 'welcome',
                'title' => 'Welcome',
        
            ],
            [
                'page'  => 'shop_only',
                'title' => 'Shop Only',
        
            ],
            [
                'page'  => 'domain_ip_address',
                'title' => 'Full Site',
        
            ],
            [
                'page'  => 'test_billing_mechanism',
                'title' => 'Test Billing Mechanism',
        
            ],
            [
                'page'  => 'test_autoresponders',
                'title' => 'Test Autoresponders',
        
            ],
            [
                'page'  => 'add_admins_to_zendesk',
                'title' => 'Add Admins to Zendesk',
        
            ],
            [
                'page'  => 'vefiry_your_zendesk',
                'title' => 'Verify your Zendesk',
        
            ],
            [
                'page'  => 'access_to_zendesk',
                'title' => 'Access to Zendesk',
        
            ],
            [
                'page'  => 'transition_call_message',
                'title' => 'Transition Call Message',
        
            ],
        ]
    ],
    [
        'section'      => 'admin',
        'section_name' => 'Admin',
        'pages' => [
            [
                'page'  => 'pm_responsibilities',
                'title' => 'PM Responsibilities',
                
            ],
            [
                'page'  => 'dev_responsibilities',
                'title' => 'DEV Responsibilities',
                
            ],
        ]
    ],
];


foreach ($leftNavMasterOnly as $section) {
    foreach ($section['pages'] as $page) {
        $insertData = [
            'section' => $section['section'],
            'section_name' => $section['section_name'],
            'page' => $page['page'],
            'page_title' => $page['title'],
            'checked' => '',
            'master_only' => 'Y'
        ];
        db_query_builder()->array2insert('training_pages', $insertData);
    }
}
