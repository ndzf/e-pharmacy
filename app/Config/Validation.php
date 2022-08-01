<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation extends BaseConfig
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    public $attemptLogin = [
        "username"          => [
            "label"         => "User.username",
            "rules"         => "required|min_length[4]",
        ],
        "password"          => [
            "label"         => "User.password",
            "rules"         => "required|min_length[5]",
        ]
    ];

    public $createUser = [
        "username"          => [
            "label"         => "User.username",
            "rules"         => "required|is_unique[users.username]|min_length[4]",
        ],
        "password"          => [
            "label"         => "User.password",
            "rules"         => "required|min_length[5]",
        ],
        "name"              => [
            "label"         => "User.name",
            "rules"         => "required"
        ],
        "role"              => [
            "label"         => "User.role",
            "rules"         => "required",
        ]
    ];

    public $createCategory = [
        "name"              => [
            "label"         => "Category.name",
            "rules"         => "required"
        ]
    ];

    public $updateCategory = [
        "name"              => [
            "label"         => "Category.name",
            "rules"         => "required"
        ]
    ];

    public $createSupplier = [
        "name"              => [
            "label"         => "Supplier.name",
            "rules"         => "required"
        ]
    ];

    public $updateSupplier = [
        "name"              => [
            "label"         => "Supplier.name",
            "rules"         => "required"
        ]
    ];

    public $createCustomer = [
        "name"              => [
            "label"         => "Customer.name",
            "rules"         => "required"
        ],
        "role"              => [
            "label"         => "Customer.role",
            "rules"         => "required"
        ]
    ];

    public $updateCustomer = [
        "name"              => [
            "label"         => "Customer.name",
            "rules"         => "required"
        ],
        "role"              => [
            "label"         => "Customer.role",
            "rules"         => "required"
        ]
    ];

    public $createProduct = [
        "name"              => ["label" => "Product.name", "rules" => "required"],
    ];

    public $updateProduct = [
        "name"              => ["label" => "Product.name", "rules" => "required"],
    ];

}
