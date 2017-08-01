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

use Antvel\Http\Controller;
use Antvel\Product\Models\ProductFeatures;
use Antvel\Product\Requests\FeaturesRequest;

class FeaturesController extends Controller
{
	/**
     * Shows features list.
     *
     * @return void
     */
	public function index()
	{
        return view('dashboard.sections.features.index', [
            'features' => ProductFeatures::paginate(50)
        ]);
	}

	/**
     * Creates a new feature.
     *
     * @return void
     */
    public function create()
    {
    	return view('dashboard.sections.features.create', [
            'allowed_rules' => ValidationRulesParser::allowed(),
            'validation_rules' => collect(),
        ]);
    }

     /**
     * Stores a new feature.
     *
     * @param  FeaturesRequest $request
     *
     * @return void
     */
    public function store(FeaturesRequest $request)
    {
        $feature = ProductFeatures::create($request->all());

        return redirect()->route('features.edit', $feature)->with('status', trans('globals.success_text'));
    }

    /**
     * Edits a given category.
     *
     * @param  ProductFeatures $feature
     *
     * @return void
     */
    public function edit(ProductFeatures $feature)
    {
        return view('dashboard.sections.features.edit', [
            'validation_rules' => ValidationRulesParser::decode($feature->validation_rules)->all(),
            'allowed_rules' => ValidationRulesParser::allowed(),
            'feature' => $feature,
        ]);
    }

    /**
     * Updates the given feature.
     *
     * @param  FeaturesRequest $request
     * @param  ProductFeatures $feature
     *
     * @return void
     */
    public function update(FeaturesRequest $request, ProductFeatures $feature)
    {
        $feature->update($request->all());

        return redirect()->route('features.edit', $feature)->with('status', trans('globals.success_text'));
    }
}
