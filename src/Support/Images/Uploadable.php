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

use Epikfy\Support\Images\Manager as Images;

trait Uploadable
{
	/**
     * Set the image value of a given model.
     *
     * @param  array  $attr
     *
     * @return null|String
     */
	public function setPicturesAttribute(array $attr)
    {
        $current = $this->image;
        $image = Images::parse($attr)->on($this->storageFolder());

        if ($image->wantsDeletion()) {
            $image->delete($current);
            return $this->attributes['image'] = null;
        }

        $picture = $image->update($current);

        return $this->attributes['image'] = $picture['path'];
    }

    /**
     * Define the storage folder for a given model image.
     *
     * @return string
     */
    abstract protected function storageFolder() : string;
}
