<?php

declare(strict_types=1);

Schedule::command(\App\Console\Commands\ParseAuto::class)->hourly();
