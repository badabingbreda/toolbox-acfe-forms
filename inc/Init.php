<?php

namespace ToolboxACFEForms;

use ToolboxACFEForms\Integration\ACFExtended;
use ToolboxACFEForms\Integration\Timber;

class Init {

    public function __construct() {

        new ACFExtended();
        new Timber();

    }
}