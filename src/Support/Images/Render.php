<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Support\Images;

use Illuminate\Support\Arr;
use Intervention\Image\ImageManager;

class Render
{
	/**
	 * The observable image.
	 *
	 * @var string
	 */
	protected $image = null;

	/**
	 * The observable image thumbnail.
	 *
	 * @var string
	 */
	protected $thumbnail = null;

	/**
	 * The requetes options.
	 *
	 * @var array
	 */
	protected $options = [];

	/**
	 * The intervention image manager.
	 *
	 * @var Intervention\Image\ImageManager
	 */
	protected $intervention = null;

	/**
	 * Creates a new instance.
	 *
	 * @param  string $image
	 * @param  array  $options
	 *
	 * @return self
	 */
	public static function image($image, $options = [])
	{
		$static = new static;

		$static->image = $image;
		$static->options = $options;
		$static->intervention = new ImageManager(['driver' => 'gd']);

		$static->normalizeNames();

		return $static;
	}

	/**
	 * Normalizes the image name.
	 *
	 * @return void
	 */
	protected function normalizeNames()
	{
        if (! $this->validFile($this->imagePath())) {
			$this->image = $this->default();
		}

		if ($this->hasOptions()) {
			$this->createThumbnail();
		}
	}

	/**
	 * Checks whether the given file has a valid format and exist in the base path.
	 *
	 * @param  string $file
	 *
	 * @return bool
	 */
	protected function validFile($file)
	{
		return !! (preg_match('/\.(gif|png|jpe?g)$/', $file) && file_exists($file));
	}

	/**
	 * Checks whether the request contains info about resizing the given file.
	 *
	 * @return bool
	 */
	protected function hasOptions()
    {
    	return !! count($this->options) > 0;
    }

    /**
     * Creates a new thumbnail.
     *
     * @return void
     */
	protected function createThumbnail()
    {
		$this->thumbnail = $this->thumbnailName();

    	if (! $this->validFile($this->thumbnailPath())) {
    		$img = $this->intervention
				->make($this->imagePath())
				->resize($this->width(), $this->height(), function ($constraint) {
            		$constraint->aspectRatio();
            		$constraint->upsize();
        		});

        	$img->save($this->thumbnailPath());
    	}
    }

    /**
     * Returns the thumbnail name
     *
     * @return string
     */
    protected function thumbnailName()
    {
    	$file = explode('.', $this->image);

		$fileName = Arr::first($file);
		$fileExt = Arr::last($file);

		return $fileName
    		. ($this->width() ? '_w' . $this->width() : '')
    		. ($this->height() ? '_h' . $this->height() : '')
    		. '.' . $fileExt;
    }

    /**
     * Renders the given file.
     *
     * @return void
     */
	public function cast()
	{
		$image = is_null($this->thumbnail)
			? $this->imagePath()
			: $this->thumbnailPath();


        $imginfo = getimagesize($image);
        header('Content-type: '.$imginfo['mime']);
        readfile($image);
	}

    /**
     * Returns the rendered image path for testing purposes.
     *
     * @return string
     */
    public function mock()
    {
        $image = is_null($this->thumbnail)
            ? $this->imagePath()
            : $this->thumbnailPath();

        return $image;
    }

	/**
     * Returns the requested width.
     *
     * @return integer
     */
    protected function width()
    {
    	return Arr::get($this->options, 'w');
    }

    /**
     * Returns the requested height.
     *
     * @return integer
     */
    protected function height()
    {
    	return Arr::get($this->options, 'h');
    }

    /**
     * Returns the default image.
     *
     * @return string
     */
    protected function default()
    {
    	return 'no-image.jpg';
    }

    /**
     * Returns the base path.
     *
     * @return string
     */
    public function basePath()
    {
    	return storage_path('images');
    }

    /**
     * Returns the image full path.
     *
     * @return string
     */
    protected function imagePath()
    {
    	return $this->basePath() . '/' . $this->image;
    }

    /**
     * Returns the thumbnail full path.
     *
     * @return string
     */
    protected function thumbnailPath()
    {
    	return $this->basePath() . '/' . $this->thumbnail;
    }
}
