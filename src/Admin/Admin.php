<?php

namespace WPSHIFTSTUDIO\CustomServicePerformance\Admin;

use WPSHIFTSTUDIO\CustomServicePerformance\Admin\Metabox;
use WPSHIFTSTUDIO\CustomServicePerformance\Admin\Settings;

class Admin {

    public function __construct() {
        new Metabox();
        new Settings();
    }
}