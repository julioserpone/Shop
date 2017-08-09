<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\Features\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Antvel\Features\Events\ProductFeatureSaved;

// use  Antvel\Feature\Models\Product;
use  Antvel\Features\Parser;

class UpdateFeatureName implements ShouldQueue
{
	/**
     * Handle the event.
     *
     * @param  ProductFeatureSaved  $event
     *
     * @return void
     */
    public function handle(ProductFeatureSaved $event)
    {
        dd('listening!');

    	// if ($event->updatedName != $event->feature->name) {
     //        $products = Product::filter(['color' => 'red'])->get();
     //        $data = Parser::replaceTheGivenKeyFor($products, $event->feature->name, $event->updatedName);

     //        foreach ($products as $product) {
     //            $product->update([
     //                'features' => json_encode($data[$product->id])
     //            ]);
     //            $product->save();
     //        }

     //        $event->feature->update(['name' => $event->updatedName]);

     //        // dd('hi', $event->feature->name, $event->updatedName);
     //    }
    }
}
