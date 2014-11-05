<?php
/**
 * Skeleton extension for Bolt
 *
 * Copyright (C) 2014  John Doe
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author
 * @copyright
 * @license   http://opensource.org/licenses/GPL-3.0 GNU Public License 3.0
 */
use Bolt\Extension\VendorName\BoltExtensionName\Extension;

$app['extensions']->register(new Extension($app));
