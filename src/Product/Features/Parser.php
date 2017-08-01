<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\Product\Features;

use Illuminate\Support\Collection;

class Parser
{
	/**
	 * Parses the given features to Json.
	 *
	 * @param  array|Collection $features
	 *
	 * @return null|string
	 */
	public static function toJson($features)
	{
		if (is_null($features) || count($features) == 0) {
			return null;
		}

		return Collection::make($features)->filter(function ($item) {
			return trim($item) != '';
		})->toJson();
	}
}
