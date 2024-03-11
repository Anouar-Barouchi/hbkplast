<?php

namespace Modules\User\Http\Controllers\Admin;

use FleetCart\Driver;
use Modules\Admin\Traits\HasCrudActions;

class DriverController
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Driver::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'user::users.driver';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'user::admin.drivers';

    

   

   
}
