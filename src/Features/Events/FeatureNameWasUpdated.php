<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Features\Events;

use Epikfy\Features\Models\Feature;
use Illuminate\Queue\SerializesModels;

class FeatureNameWasUpdated
{
	use SerializesModels;

    /**
     * The feature to be updated.
     *
     * @var Feature
     */
    public $feature = null;

    /**
     * The new feature name.
     *
     * @var string
     */
    public $updatedName = '';

    /**
     * Create a new event instance.
     *
     * @param ProductFeatures $feature
     *
     * @return void
     */
    public function __construct(Feature $feature, $updatedName)
    {
        $this->feature = $feature;
        $this->updatedName = $updatedName;
    }
}
