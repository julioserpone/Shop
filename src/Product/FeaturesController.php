<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\Product;

use Antvel\Http\Controller;
use Antvel\Product\Models\ProductFeatures;
use Antvel\Product\Requests\FeaturesRequest;
use Antvel\Product\Parsers\FeaturesValidationRulesParser;

class FeaturesController extends Controller
{
	/**
	 * The features repository.
	 *
	 * @var Features
	 */
	protected $features = null;

	/**
	 * Creates a new instance.
	 *
	 * @param Features $features
	 *
	 * @return void
	 */
	public function __construct(Features $features)
	{
		$this->features = $features;
	}

	/**
     * Shows categories list.
     *
     * @return void
     */
	public function index()
	{
        return view('dashboard.sections.features.index', [
        	'features' => $this->features->all()
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
            'allowed_rules' => FeaturesValidationRulesParser::allowed(),
            'validation_rules' => collect(),
        ]);
    }

     /**
     * Stores a new category.
     *
     * @param  CategoriesRequest $request
     *
     * @return void
     */
    public function store(FeaturesRequest $request)
    {
        $feature = $this->features->create(
            $request->all()
        );

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
            'validation_rules' => FeaturesValidationRulesParser::decode($feature->validation_rules)->all(),
            'allowed_rules' => FeaturesValidationRulesParser::allowed(),
            'feature' => $feature,
        ]);
    }

    /**
     * Updates the given category.
     *
     * @param  CategoriesRequest $request
     * @param  Category $category
     *
     * @return void
     */
    public function update(FeaturesRequest $request, ProductFeatures $feature)
    {
        $this->features->update(
            $request->all(), $feature
        );

        return redirect()->route('features.edit', $feature)->with('status', trans('globals.success_text'));
    }
}
